<?php
    session_start(); //starts the session

    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/staff_common.php"; //requires in common for functions

    $staff_type = getStaffType(dbconn_select(), $_SESSION['user']); //gets the staff type based on their staff id

    if (!isset($_SESSION['user'])) {  //ensures user is logged in to continue
        $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message
        header("Location: staff_login.php");  // redirects them to login
        exit;  // stops further code execution
    } elseif (implode($staff_type) != 'adm' && implode($staff_type) != 'sto') {  //ensures user has a staff type and its admin or store staff to access the page
        $_SESSION['usermessage'] = "ERROR: Account does not have clearance to access this page!"; // sets error message
        header("Location: staff_dash.php");  // redirects them to the dashboard
        exit;  // stops further code execution

    } elseif ($_SERVER["REQUEST_METHOD"] === "POST") { //using post as it is a secure method
        try {
            if (add_stock(dbconn_update(), $_POST['quantity']  ,$_POST['itemid'])) {  // only checks for in basket as date order for can be different (see basket page code)
                $_SESSION['usermessage'] = "SUCCESS: Item quantity updated Successfully!"; //message displayed when an item is successfully added to basket
                audtitor(dbconn_insert(), $_SESSION['user'], "pro", "User has successfully updated product quantity"); //adds an audit to the system when a user adds an item to the basket
                //this audit may need to be removed if it clogs up the audit system.
                header('Location: update_product_quan.php');  // redirects them back to the page after the item is added (essentially the system refreshing the page for the user)
                exit;  // stops further code execution
            } //else {
               //wip

        } catch (PDOException $e) {
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();
            header('Location: products.php');  // redirects them
            exit;  // stops further code execution
        } catch (Exception $e) {
            $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();
            header('Location: products.php');  // redirects them
            exit;  // stops further code execution
        }
    }




    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
    echo "<title>Products - Greenfield Local Hub</title>"; //puts a title on the tab of the page
    echo "</head>";

    echo "<body>";

    echo "<h1>Products</h1>";

    try {

        $products = getproducts(dbconn_select()); //gets the products by running the function

    } catch(PDOException $e){
        $_SESSION['message'] = "ERROR: ".$e->getMessage();
        header('Location: user_dash.php');  // send them back to dashboard
        exit;  // ensure no other code can execute
    } catch (Exception $e) {
        $_SESSION['message'] = "ERROR: " . $e->getMessage();
        header('Location: user_dash.php');  // send them back to dashboard
        exit;  // ensure no other code can execute
    }

    echo user_message(); //displays any user messages to the user.


    if (!$products) {

        $_SESSION['message'] = "No products found"; //sends a message if no products can be found

    } else {

        echo "<div class= product-list>";
        foreach ($products as $product) { //sets it so a product is displayed for each product taken from the database
            echo "<div class='product-item'>"; //puts the item into a class

            echo "<h2>" . $product['name'] . "</h2>"; //brings name from database and displays it
            echo "<p><strong>Current Quantity:  </strong> " . $product['quantity'] . "</p>";

                echo " <form action='' method='post'>";
                echo "<td>";
                echo "<input type='hidden' name='itemid' value=" . $product['product_id'] . ">";
                echo "<input type='number' name='quantity' min='1' max= " . $product['quantity'] . "  value='1' />"; //sets the quantity to add to basket
                echo "<input type='submit' name='addprod' value='Update Quantity' />"; //this causes the page to reload and the product to the basket
                echo "</td>";
                echo "</form>";
        }
        echo "</div>";
    }

    echo "<br><br><a href='staff_dash.php'><- Back</a>"; //to make it so you can easily get back to the dash since there's no header

    echo "</body>";

    echo "</html>";
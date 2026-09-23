<?php
    session_start(); //starts the session

    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions


    if (!isset($_SESSION['user'])) {  //ensures user is logged in to continue
        $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message
        header("Location: login.php");  // redirects them to login
        exit;  // stops further code execution
    } elseif($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['quantity']>0) {  // if the user has posted
        try {
            if (in_basket($_POST['itemid'])) {  // only checks for in basket as date order for can be different (see basket page code)
                $_SESSION["basket"][$_POST['itemid']] = $_POST['quantity'];
                $_SESSION['usermessage'] = "SUCCESS: Item added to your Basket!"; //message displayed when an item is successfully added to basket
                audtitor(dbconn_insert(), $_SESSION['user'], "bas", "User has successfully added an item to basket"); //adds an audit to the system when a user adds an item to the basket
                //this audit may need to be removed if it clogs up the audit system.
                header('Location: products.php');  // redirects them back to the page after the item is added (essentially the system refreshing the page for the user)
                exit;  // stops further code execution
            } else {
                $_SESSION['usermessage'] = "ERROR: In basket already"; //sends a message to the user if the item is already in the basket
                header('Location: basket.php');  // redirects them to their basket
                exit;  // stops further code execution
            }
        } catch (PDOException $e) {
            $_SESSION['usermessage'] = "ERROR: ".$e->getMessage();
            header('Location: products.php');  // redirects them
            exit;  // stops further code execution
        } catch (Exception $e){
            $_SESSION['usermessage'] = "ERROR: ".$e->getMessage();
            header('Location: products.php');  // redirects them
            exit;  // stops further code execution
        }
    } elseif($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['quantity']==0) {
        $_SESSION['usermessage'] = "ERROR: You need a quantity higher than 1!"; // sets error message if user tries to add 0 items to the basket
        header("Location: products.php");  // redirects them
        exit;  // stops further code execution
    }



echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

        echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
            echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links to the style sheet
            echo "<title>Products - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

        echo "<body>";

            require "assets/header.php"; //requires the header for the page to load

            echo "<h1>Products</h1>";

            try {

                $products = getProducts(dbconn_select()); //gets the products by running the function

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

            try {
                echo "";
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            if (!$products) {

                $_SESSION['message'] = "No products found"; //sends a message if no products can be found

            } else {

                echo "<div class= product-list>";
                foreach ($products as $product) { //sets it so a product is displayed for each product taken from the database
                    echo "<div class='product-item'>"; //puts the item into a class
                    if (!empty($product['image'])) { //if image is not empty
                        echo "<a href='product_single.php?id=" . $product['product_id'] . "'><img src='" . $product['image'] . "' alt='" . $product['image_alt'] . "'></a>"; //brings product from database and puts them in
                    }
                    echo "<a href='product_single.php?id=" . $product['product_id'] . "'><h2>" . $product['name'] . "</h2></a>"; //brings name from database and displays it
                    echo "<p><strong>Price:  </strong> £" . $product['price'] . "</p>"; //brings price from database and displays it

                   echo " <form action='' method='post'>";
                        echo "<td>";
                         echo "<input type='hidden' name='itemid' value=" . $product['product_id'] . ">";
                         echo "<input type='number' name='quantity' min='1' max= " . $product['quantity'] . "  value='1' />";
                         echo "<input type='submit' name='addprod' value='Add to basket' />";
                       echo "</td>";
                  echo "</form>";


                }
                echo "</div>";
            }





            require "assets/footer.php"; //requires the header for the page to load

            echo "</body>";

    echo "</html>";

    if (!$message) {
        echo user_message(); // runs the user message function if the message variable is empty
    } else {
        echo $message;
    }

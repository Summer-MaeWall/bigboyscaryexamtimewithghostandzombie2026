<?php // This open the php code section

    session_start();  // starts the session

    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions

   if (!isset($_SESSION['user'])) {  // If they have managed to get to this page without logging
        $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message if a user isn't logged in.
        header("Location: login.php");  // redirects them
        exit;  // ensures no other code executes

    } elseif($_SERVER["REQUEST_METHOD"] === "POST") {  // if the user has posted
       if (isset($_POST['delprod'])) {  // if they have clicked to remove the product
           unset($_SESSION['basket'][$_POST['itemid']]); //removes the product from the array
           $_SESSION['usermessage'] = "SUCCESS: Product Removed."; //sends a success message to the user on item removal
           audtitor(dbconn_insert(), $_SESSION['user'], "bas", "User has successfully removed an item from basket"); //adds an audit to the system when a user removes an item from their basket
           header('Location: basket.php');  // send them back to the updated basket page
           exit;  // ensure no other code can execute

       } elseif (isset($_POST['updateprod'])) {  // if the change appointment button was use
           $_SESSION['basket'][$_POST['itemid']] = $_POST['quantity']; // get the item id and update its quantity
           $_SESSION['usermessage'] = "SUCCESS: Quantity updated."; //sends a message to the user on quantity update
           audtitor(dbconn_insert(), $_SESSION['user'], "bas", "User has successfully updated an items quantity in the basket");
           header('Location: basket.php');  // send them back to basket.php after the quantity has been updated.
           exit;  // ensure no other code can execute

       } elseif (isset($_POST['clearorder'])) {  // if the change appointment button was use
           $_SESSION['basket'] = []; // capture the appointment id from the from
           $_SESSION['usermessage'] = "SUCCESS: Your basket has been cleared";
           header('Location: products.php');  // send them to the alterbooking page
           exit;  // ensure no other code can execute

       } elseif (isset($_POST['comporder'])) {  // if the change appointment button was use
           try {
               $selectedDate = $_POST['date'] ?? ''; //gets the date the user selected
               // Check if date is provided and valid
               if (!$selectedDate) {
                   $_SESSION['usermessage'] = "ERROR: Please select a valid date."; //displays a message to the user
                   header('Location: basket.php'); // redirect back to basket or order page
                   exit; //stops code execution
               } else {
                   $today = date('Y-m-d'); //sets the current date
                   if ($selectedDate <= $today) {
                       $_SESSION['usermessage'] = "ERROR: You cannot place an order for a past date or today. Please select a future date."; //displays message to user
                       header('Location: basket.php'); // redirect back to basket or order page
                       exit; //stops code execution
                   } else {
                       #check stock of all items,
                       #if not in stock wanted, return to basket with message
                       $failedItems = stock_check(dbconn_select(), $_POST['date']);
                       if (empty($failedItems)) {
                           $orderid = commit_order(dbconn_insert(), $_POST, $_SESSION['total']);
                           add_points(dbconn_update(), $_SESSION['user'], $_SESSION['points']); // adds points to the users loyalty system

                           if (add_basket(dbconn_insert(), $_SESSION['basket'], $orderid)) { //adds items to the basket column
                               if (remove_stock(dbconn_update(), $_SESSION['basket'])) { //updates the stock to reflect what the user just ordered
                                   $_SESSION['basket'] = []; // capture the appointment id from the from
                                   $_SESSION['usermessage'] = "SUCCESS: Your Order has been completed"; //displays a success message to the user.
                                   audtitor(dbconn_insert(), $_SESSION['user'], "ord", "User has successfully Placed an order"); //to add an audit to the system when user places an order
                                   header('Location: ord.php');  // send them to the alterbooking page
                                   exit;  // ensure no other code can execute
                               } else {
                                   $_SESSION['usermessage'] = "ERROR: Your order did not complete!"; //displays a message to the user
                                   header('Location: basket.php');  // send them to the alterbooking page
                                   exit;  // ensure no other code can execute
                               }
                           }
                       } else {
                           $_SESSION['usermessage'] = "ERROR: Sorry, the following items are sold out: " . implode(', ', $failedItems); //sends a message to the user
                           header('Location: basket.php');  // send them to the alterbooking page
                           exit;  // ensure no other code can execute
                       }
                   }
               }

           } catch (PDOException $e) {
               $_SESSION['usermessage'] = "Error: " . $e->getMessage();
               header('Location: basket.php');  // send them to the alterbooking page
               exit;  // ensure no other code can execute
           } catch (exception $e) {
               $_SESSION['usermessage'] = "Error: " . $e->getMessage();
               header('Location: basket.php');  // send them to the alterbooking page
               exit;  // ensure no other code can execute
           }

       }


       if (!isset($_SESSION['basket'])) { //if basket doesnt exist, creates a basket
           $_SESSION['basket'] = []; //creates basket as an array.
       }
   }




    echo "<!DOCTYPE html>";
    echo "<html lang='en'>"; //sets language to english
        echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
            echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links the stylesheet
            echo "<title>Basket - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

    echo "<body>";  # opens the body for the main content of the page.

        require "assets/header.php"; //requires the header for the page to load

        echo "<h2>Basket</h2>";  // sets a h2 heading as a welcome

        echo "<br>";
        echo user_message(); //displays messages to the user
        echo "<br>";

        echo "<p class='content'> Below are the Items in your basket </p>";


        try{
            $products = getproducts(dbconn_select()); //gets the products from the database
            $ordersubtotal = 0;
        } catch(PDOException $e){
            $_SESSION['message'] = "ERROR: ".$e->getMessage();
            header('Location: user_dash.php');  // send them back to the dashboard
            exit;  // ensure no other code can execute
        } catch (Exception $e){
            $_SESSION['message'] = "ERROR: ".$e->getMessage();
            header('Location: user_dash.php');  // send them back to the dashboard
            exit;  // ensure no other code can execute
        }

        echo "<table id='basket'>";

        echo "<thead>"; //names at the top of the page for each category
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Price</th>";
            echo "<th>Sub-Total</th>";
            echo "<th>quantity</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
        echo "</thead>";

        $productsById = []; //creates an associative array
        foreach ($products as $product) { //for each product in the product array
            $productsById[$product['product_id']] = $product; //put the product id in the new array
        }

        // DISPLAY THE BASKET ITEMS
        foreach ($_SESSION['basket'] as $itemid => $quantity) { // for each item in the users basket with quantities

            if (isset($productsById[$itemid])) { // if the item id is set in the productsbyid array
                $product = $productsById[$itemid]; //product is the item id

                echo "<tr>";

                echo "<td>" . htmlspecialchars($product['name']) . "</td>"; // displays product name
                echo "<td>£" . number_format($product['price'], 2) . "</td>"; // displays product price

                echo "<td>";
                $itemsubtotal = $product['price'] * $quantity; //creates a subtotal for each item based on how many a user has put in their basket
                $ordersubtotal += $itemsubtotal; //adds the item subtotal to the order total
                echo "£" . number_format($itemsubtotal, 2); //displays the item subtotal to the user
                echo "</td>";

                echo "<td>";
                echo "<form id='ind_item' action='' method='post'>
                        <input type='hidden' name='itemid' value='" . htmlspecialchars($itemid) . "'> 
                        <input type='number' name='quantity' min='0' max='" . intval($product['quantity']) . "' value='" . intval($quantity) . "' />
                        <input type='submit' name='updateprod' value='Update Quantity' />
                        <input type='submit' name='delprod' value='Delete' /> 
                      </form>"; //displays an items quantity and allows user to update item quantity and delete items form the system
                echo "<hr>";

                echo "</td>";
                echo "</tr>";

            } else {
                echo "<tr><td>Product not found</td></tr>"; //error message in case the product id can not be found
            }
        }


        echo "</table>"; //ends the table for all the items in the foreach loop

        // placing order here.
            $_SESSION['points'] = intval($ordersubtotal); //sets the points to be the int of the subtotal (1 point per £1 spent)
            $_SESSION['total'] = $ordersubtotal; //gets the order subtotal for inserting into the order table

            echo "<hr>";
            echo "<h2> Your Basket Total</h2>";

            echo "<table id='subtotal'>";
            echo "<tr>";
                echo "<td><p> Your Basket Subtotal: £" . number_format($ordersubtotal, 2) . "</p></td>";//displays the baskets total to the user.
                echo "<td><p> Points Earned: " . $_SESSION['points'] . "</p>"; //displays points to the user

            echo "</tr>";
            echo "<tr>";
                echo "<td>";

                    echo "<form id='ind_item' action='' method='post'>"; //form for user to input checkout details
                        echo "<label for='type'>Please select an option: </label>";
                        echo "<select id='type' name='type'>";
                        echo"<option value='col'>Collection</option>";
                        echo"<option value='del'>Delivery</option>";
                        echo "</select>";
                        echo "<br><label> Select delivery or collection date: </label>";
                        echo "<br><input type='date' id='start' name='date' min='2026-01-01' max='2026-12-31'>";
                        echo "<br><br><input type='submit' name='clearorder' value='Delete Basket' />";
                        echo "<br><br><input type='submit' name='comporder' value='Complete Order' />";
                    echo "</form>";
                echo "</td>";
            echo "</tr>";
        echo "</table>";

        echo "<br>";

        require "assets/footer.php"; //requires the footer for the page to load

    echo "</body>";

    echo "</html>";

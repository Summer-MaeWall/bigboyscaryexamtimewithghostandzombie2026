    <?php // This open the php code section

    session_start();  // starts the session

    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions

    if (!isset($_SESSION['user'])) {  # If they have managed to get to this page without logging in
        $_SESSION['usermessage'] = "ERROR: You are not logged in!"; //sets error message
        header("Location: login.php"); //redirects them to login
        exit; //stops further execution
    } elseif($_SERVER["REQUEST_METHOD"] === "POST") { //sets teh server request method to post
        if (isset($_POST["orddelete"])) {
            try {
                //put stock check and remove loyalty points here

               if (remove_points(dbconn_update(), $_SESSION["user"], $_SESSION["totalpoints"])) { //removes the points, if it comes back true then moves on

                   $stock = find_stock(dbconn_select(), $_POST["order_id"]); //gets the stock from all the items in the order

                  if (add_stock(dbconn_update(), $stock)) { //adds the stock back to be available, if it comes back true allows order to be deleted

                      if (cancel_ord(dbconn_delete(), $_POST['order_id'])) { //deletes the order from the database

                          $_SESSION['usermessage'] = "SUCCESS: Appointment has been cancelled."; //success message displayed to the user on a successful cancellation.
                          audtitor(dbconn_insert(), $_SESSION['user'], "ord", "User has successfully cancelled order."); //audit to the system on order cancellation
                      } else {
                          $_SESSION['usermessage'] = "ERROR: Could not be able to execute complete this action"; //displays failure message to the user
                      }
                  }
               }
            } catch (PDOException $e) { //catches pdo errors and displays the message
                $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();
            } catch (Exception $e) {
                $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();
            }
        }
    }
    //to view the orders make a button called order details to display the contents of the basket

    echo "<!DOCTYPE html>";

        echo "<html lang='en'>";

            echo "<head>";
                echo "<meta charset='UTF-8'>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
                echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links to the style sheet
                echo "<title>Your Orders - Greenfield Local Hub</title>"; //title of the page for the tab
            echo "</head>";

            echo "<body>";

                require "assets/header.php"; //requires in the header

                echo user_message();

                echo "<h2>Your Orders</h2>";

                echo "<p> Below are your orders: </p>";

                $orders = ord_getter(dbconn_select()); //gets the orders from the database

                $date = date("Y-m-d"); //sets the current date

                if (!$orders) {
                    echo "<p>There are no orders found.</p>"; //displays a message to the user if no orders are found
                } else {
                    // arrays to hold table rows
                    $currentOrdersRows = '';
                    $pastOrdersRows = '';

                    foreach ($orders as $order) {
                        // selects a type based on whether the order is for collection or delivery
                        if ($order['type'] == "col") {
                            $type = "Collection"; //sets type as collection
                        } else if ($order['type'] == "del") {
                            $type = "Delivery"; //sets type as delivery
                        }

                        $_SESSION['totalpoints'] = intval($order['total']); //gets the integer of the total to use to remove loyalty points

                        // Create the row HTML once per order
                        $row = "<form action='' method='post'>";
                        $row .= "<tr>";
                        $row .= "<td> Delivery Date: " . htmlspecialchars($order['delivery_date']) . "</td>"; //displays the delivery date in the db
                        $row .= "<td> Ordered on: " . htmlspecialchars($order['order_date']) . "</td>"; //displays the order date in the db
                        $row .= "<td> For : " . $type . "</td>"; //displays the order type
                        $row .= "<td> Total : £" . number_format($order['total'], 2) . "</td>"; //displays the order total

                        // Different buttons depending on current or past order
                        if ($order['delivery_date'] >= $date) {
                            $row .= "<td><input type='hidden' name='order_id' value='" . intval($order['order_id']) . "'> 
                                 <input type='submit' name='orddetails' value='View Order Details' />
                                 <input type='submit' name='orddelete' value='Cancel Order' />
                                 <input type='submit' name='ordchange' value='Edit Order' /></td>"; //edit order and view order details will not have functionality
                        } else {
                            $row .= "<td><input type='hidden' name='apptid' value='" . intval($order['order_id']) . "'> 
                                 <input type='submit' name='orddetails' value='View Order Details' />
                                 <input type='submit' name='ordrefund' value='Request Refund' /></td>"; //these buttons will not have functionality
                        }

                        $row .= "</tr>";
                        $row .= "</form>";

                        // Assigns the row to the correct group
                        if ($order['delivery_date'] >= $date) {
                            $currentOrdersRows .= $row; //sets current orders to appear first
                        } else {
                            $pastOrdersRows .= $row; //sets past orders to appear last
                        }
                    }

                    // Outputs current orders table if there are any
                    if ($currentOrdersRows) {
                        echo "<h3>Current orders</h3>";
                        echo "<table id='current_orders'>";
                        echo $currentOrdersRows;
                        echo "</table>";
                    }

                    // Outputs past orders table if there are any
                    if ($pastOrdersRows) {
                        echo "<h3>Past orders</h3>";
                        echo "<table id='past_orders'>";
                        echo $pastOrdersRows;
                        echo "</table>";
                    }
                }

                                require "assets/footer.php"; //requires in the footer

                            echo "</body>";

                        echo "</html>";
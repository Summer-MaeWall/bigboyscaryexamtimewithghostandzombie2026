<?php //WIP

    session_start(); //starts the session

    require_once("assets/dbconn.php"); //requires dbconn.php to be brought in for the page to run as it is needed to insert data into the database.
    require_once("assets/staff_common.php"); // requires common.php to be brought in for the page to run as it needed to use any of the functions.

    $staff_type = getStaffType(dbconn_select(), $_SESSION['user']); //gets the staff type based on their staff id

    if (!isset($_SESSION['user'])) {  //ensures user is logged in to continue
        $_SESSION['usermessage'] = "ERROR: You are not logged in!"; // sets error message
        header("Location: staff_login.php");  // redirects them to login
        exit;  // stops further code execution
    } elseif (!$staff_type == 'adm') {  //ensures user has the correct staff type to access the page
        $_SESSION['usermessage'] = "ERROR: Account does not have clearance to access this page!"; // sets error message
        header("Location: staff_dash.php");  // redirects them to the dashboard
        exit;  // stops further code execution

    } elseif ($_SERVER["REQUEST_METHOD"] === "POST") { //using post as it is a secure method
       try {
            if (new_prod(dbconn_insert(), $_POST)) { //in an if statement so if its successful it will display the success message
                $_SESSION['usermessage'] = "Product added successfully!"; //displays a message to the user on success
                audtitor(dbconn_insert(), $_SESSION['user'], "pro", "User has added a new product"); //audits the system when a user adds a new product
                header("Location: new_products.php"); //redirects back to the same page incase they are adding multiple products
            } else {
                $_SESSION['usermessage'] = "ERROR: Product adding failed!"; //displays a message to the user on fail
                header("Location: new_products.php"); //redirects back to the same page
            }
       } catch (PDOException $e) {
           $_SESSION['usermessage'] = "ERROR: " . $e->getMessage(); //to catch errors
       } catch (Exception $e) {
           $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();
       }
    }





    echo "<!DOCTYPE html>";

    echo "<html lang='en'>"; //sets language to english
        echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
            // echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links stylesheet for now the staff system will not have a style sheet for convience
            echo "<title>Add New Products - Greenfield Local Hub</title>"; //puts a title on the tab of the page
        echo "</head>";

        echo "<body>";


            echo "<br>";
            echo user_message(); //displays user messages
            echo "<br>";

            echo "<h1>Add New Product</h1>"; //label for clarity (UAC 1.3)

            echo "<form action='' method='post'>"; //creates a form with appropriate action and method.

            echo "<label for='name'>Product Name:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='text' name='name' id='name' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<label for='desc'>Product Description:</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='text' name='desc' id='desc' required><br>"; //input box, is required so form cannot be submitted without it.


            echo "<label for='farm'>Farms</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
           // this will be a select that gets farms from the database
            echo "<select name='farm' id='farm' required>";

                echo "<option disabled>Select Farm</option>";
                try {
                    $farm = get_farms(dbconn_select()); //gets the farm names and codes from the database

                    foreach ($farm as $fr) { //displays each farm in a foreach loop

                        echo "<option value='" . $fr['farm_code'] . "'>" . $fr['farm_name'] . "</option>"; //displays the farm name to the user, with the value of the farm code

                    }
                } catch (PDOException $e) {
                    $_SESSION['usermessage'] = "ERROR: " . $e->getMessage(); //to catch errors
                } catch (Exception $e) {
                    $_SESSION['usermessage'] = "ERROR: " . $e->getMessage();
                }


            echo "</select><br>";

            echo "<label for='img'>Image</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='text' name='img' id='img' required><br>"; //input box, is required so form cannot be submitted without it.

            // this will input like egg.jpg and then file path needs to be added after

            echo "<label for='imgalt'>Image Alt Tag</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='text' name='imgalt' id='imgalt' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<label for='price'>Product Price</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='number' name='price' id='price' step='any' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<label for='quan'>Product Quantity</label><br>"; //label for the input box. Makes the page clear and easy to understand (UAC 1.3, NFR 1.1)
            echo "<input type='number' name='quan' id='quan' step='any' required><br>"; //input box, is required so form cannot be submitted without it.

            echo "<br><input type='submit' name='submit' id='submit' value='Add Product'>"; //submit button, once clicked causes form to be submitted

            echo "</form>";


            echo "<br><br><a href='staff_dash.php'><- Back</a>"; //to make it so you can easily get back to the dash since there's no header



        echo "</body>";

    echo "</html>";
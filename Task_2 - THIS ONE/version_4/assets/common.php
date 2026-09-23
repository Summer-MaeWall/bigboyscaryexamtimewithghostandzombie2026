<?php

    //all functions will be stored in the common for proper code organisation and to reduce repeating code, making the system run faster (UAC 1.4)

    function user_message(){ // function for outputting messages to the user
        if(isset($_SESSION['usermessage'])){
            $message = "<p>" . $_SESSION['usermessage'] . "</p>";
            unset($_SESSION['usermessage']);
            return $message;
        } else {
            $message = "";
            return $message;
        }
    }

    function reg_user($conn, $post){
        $sql = "INSERT INTO customers (email, password, sign_up_date) VALUES (?,?,?)"; //sql statement
        $stmt = $conn->prepare($sql); //prepare to sql
        $signupdate = date("Y-m-d");
        $hpwsd = password_hash($post['password'], PASSWORD_DEFAULT); //hash the password,
        // using default encrytion because we don't have anything else built in.
        // If it was a production system i would use better encryption like bcrypt or argon.
        $stmt->bindparam(1, $post['email']); //bind parameters for security
        $stmt->bindparam(2, $hpwsd);
        $stmt->bindparam(3, $signupdate);

        $stmt->execute(); //run the query to insert
        $conn = null; //closes the connection so it cant be abuse
        return true; //registration successful

    }

    function email_ver($conn, $email){
        $sql = "SELECT email FROM customers WHERE email = ?"; //sql statement
        $stmt = $conn->prepare($sql); //prepare to sql
        $stmt->bindparam(1, $email); //binds parameters for security
        $stmt->execute(); //runs the query to select
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetchs the results
        if($result) {
            return true; //if a result is returned, returns true
        } else {
            return false; //if a result is not returned, returns false
        }
    }


    function login($conn, $post){
        $sql = "SELECT user_id, password FROM customers WHERE email = ?"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares the statement
        $stmt->bindparam(1, $post['email']); //binds parameters to execute
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //bring back results
        $conn = null; //nulls off the connection so can't be abused

        if($result) { //if there is a result returned
            return $result;
        } else {
            $_SESSION['usermessage'] = "ERROR: User not found!"; //sends a user message if a user is not found
            header("Location: login.php"); //redirects user back to the index page
            exit; //stop further execution
        }
    }

function audtitor($conn, $userid, $code, $long){ //on doing any action, the auditor logs it
    $sql = "INSERT INTO user_audit ( user_id, code, long_desc, date) VALUES (?,?,?,?)"; //prepared statement
    $stmt = $conn->prepare($sql); //prepare to sql
    $date = date("Y-m-d"); //exact structure that a mysql date field accepts
    $stmt->bindparam(1, $userid); //bind params for security
    $stmt->bindparam(2, $code);
    $stmt->bindparam(3, $long);
    $stmt->bindparam(4, $date);

    $stmt->execute(); //runs the query to insert
    $conn = null; //closes the connection so it can't be abused
    return true; //registration successful
}


function getnewuserid($conn, $email){ //upon registering, this retrieves the userid from the database
    $sql = "SELECT user_id FROM customers WHERE email = ?"; //sql statement
    $stmt = $conn->prepare($sql); //prepares statement
    $stmt->bindparam(1, $email); //binds params for security
    $stmt->execute(); //run sql code
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //bring back results
    $conn = null; //closes the connection to prevent abuse
    return $result['user_id']; //returns the user id

}

/* WIP
   function change_password($conn, $userid, $newpassword){
   $sql = "UPDATE customers SET password = ? WHERE user_id = ?";
    $hpwsd = password_hash($post['password'], PASSWORD_DEFAULT); //hash the password,
    $stmt = $conn->prepare($sql);
    $stmt->bindparam(1, $pwsd);
    $stmt->bindparam(2, $userid);
    $stmt->execute();
    $conn = null;
    return true;
}  */

function getproducts($conn){
        $sql = "SELECT * FROM products";
        $stmt = $conn->prepare($sql); //prepares statement
        $stmt->execute(); //executes query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetches all the products
        $conn = null; //closes the connection to prevent abuse
        return $result; //returns result
}

function getproductbyid($conn, $product_id){
        $sql = "SELECT * FROM products WHERE product_id = ?"; //sql statement
        $stmt = $conn->prepare($sql); //prepares statement
        $stmt->bindparam(1, $product_id); //binds params for security
        $stmt->execute(); //executes statement
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetches results
        $conn = null; //closes the connection so it can't be abused
        return $result; //returns the result
}

function in_basket($itemid){
    if(array_key_exists($itemid, $_SESSION['basket'])){
        return false;  // returns false if the item already exists in their basket
    } else {
        return true; // returns true if the item does not already exist in the basket
    }

}

//for ordering, you need to complete the order, then add the order items to the basket with the order id.

//$date = date("Y-m-d H:i:s"); //use datetime to grab the appointment as it will only bring back one result, even if user makes multiple orders in one day.
//use epoch time instead, that as backup if it doesn't work.
//select order_id from orders where epoch time = ?
//scrap all this, use lastInsertId(), its more efficent.

function commit_order($conn, $post,$total){
        // puts order into order table
    $sql = "INSERT INTO orders (user_id, type, total, delivery_date,order_date) VALUES (?,?,?,?,?)"; //prepared statement, this is the best way to prevent sql injections

    $stmt = $conn->prepare($sql); //prepares to sql
    $orderdate = date("Y-m-d"); //gets the date the order was created on for logging purposes

    $stmt->bindparam(1, $_SESSION['user']);//bind params for security
    $stmt->bindparam(2, $post['type']);
    $stmt->bindparam(3, $total);
    $stmt->bindparam(4, $post['date']);
    $stmt->bindparam(5, $orderdate);

    $stmt->execute(); //runs the query to insert
    $new_orderid = $conn->lastInsertId(); //grabs the order id from the last insert (the one we just inserted)
    $conn = null; //these here temp.
    return $new_orderid;
}

//puts all the items from the order into its own table.
function add_basket($conn, $basket, $orderid){
        $productstmt = $conn->prepare("INSERT INTO basket (product_id, order_id, quantity, date) VALUES (?,?,?, NOW())");
        //prepares an sql statement. NOW() gets the current date to insert

    foreach ($basket as $itemid => $quantity){
        $productstmt->execute([$itemid, $orderid, $quantity]);
    } //executes for every single item in the users orders to the basket table.
    $conn = null;
    return true;
}

function stock_check($conn){ //checks if items are in stock

    // 1. Get the master daily limits for items
    $sql = "SELECT product_id, quantity FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stock = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $unavailableItems = []; //set unvailable items as an array

    // 2. Loop through the current user's basket
    foreach ($_SESSION['basket'] as $itemid => $requestedQuant) {
        #These lines use the Null Coalescing Operator (??), which is a shorthand way of
        # saying: "Try to use this value, but if it doesn't exist, use this default instead."

        $availablestock = $stock[$itemid] ?? 0;
        $sold = $_SESSION['basket'][$_POST['itemid']] ?? 0; //gets the quantity of an item from the basket

        $remainingStock = $availablestock - $sold;

        if ($requestedQuant > $remainingStock) {
            // This item is short on stock! Store the ID (or name)
            $unavailableItems[] = $itemid;
        }
    }

    // Return the list of items that failed the check
    return $unavailableItems;

}

function ord_getter($conn){ //gets orders to display to the user

    //display: collection or delivery, delivery date, date ordered

    $sql = "SELECT * FROM orders  WHERE user_id = ? ORDER BY order_date ASC"; //sql statement

    $stmt = $conn->prepare($sql); //prepares the sql

    $stmt->bindparam(1, $_SESSION['user']); //binds params for security
    $stmt->execute(); //executes query
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all iss important to ensure that all the data from the db is pulled not just the first one
    $conn = null; //closes the connection so it cant be abused
    if($result) {
        return $result; //if a result is returned, return the result
    } else {
        return false; //if a result is not returned, return false
    }
}


//WIP need to figure out how to add back the stock before you delete the items from the basket. sort out stock management then come back
// select product_id, quantity from basket where order_id = ?


//may reuse this to display order items
function find_stock($conn, $order_id){ //gets items out of the basket for the order id
    $sql = "SELECT * FROM basket WHERE order_id = ?";  //sql statement
    $stmt = $conn->prepare($sql); //prepares statement
    $stmt->bindparam(1, $order_id);
    $stmt->execute(); //executes query
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetches all the products
    $conn = null; //closes the connection to prevent abuse
    return $result; //returns result


}
/*
function add_stock($conn, $stock){
    $stockstmt = $conn->prepare("UPDATE products SET quantity = quantity + ? WHERE product_id = ?");

    foreach ($stock as $itemid => $quantity) {
        $stockstmt->execute([$quantity, $itemid]); //this may not work because it was designed for session
    }
    $conn = null;
    return true;
}

*/

function add_stock($conn, $stock){ //updates the quantity of items in the product table
    $stockstmt = $conn->prepare("UPDATE products SET quantity = quantity + ? WHERE product_id = ?"); //prepares the sql statement

    foreach ($stock as $item) {
        // Defensive checks
        if (!isset($item['product_id'], $item['quantity'])) {
            continue; // skip invalid entries
        } //ensures that product_id and quantity is set

        $quantity = $item['quantity']; //makes quantity and product id into their own arrays
        $product_id = $item['product_id'];


        if (is_array($quantity) || is_array($product_id)) {
            continue; // skip invalid entries
        } //checks to make sure that quantity and product id are arrays

        $stockstmt->execute([$quantity, $product_id]); //executes statement into the database with the arrays
    }

    $conn = null; //closes the connection so it can't be abused
    return true; //returns true on success
}


function remove_stock($conn, $basket) //removes stock from the database when ordered
{
    $stockstmt = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE product_id = ?"); //prepares sql statement

    foreach ($basket as $itemid => $quantity) {
        $stockstmt->execute([$quantity, $itemid]); //executes each item in the basket to update their quantities
    }
    $conn = null; //closes the connection so it cant be abused
    return true; //returns true on success

}


function cancel_ord($conn, $orderid){ //cancels an order by deleting them from the orders and basket table
        //repeating the code isn't the most maintainable way of coding but i do not have the technical knowledge to do a successful join for these tables.

    $sql = "DELETE FROM orders WHERE order_id = ?"; //sql statement to delete the order and the items in the basket
    $stmt = $conn->prepare($sql); //prepares the sql to bind param
    $stmt->bindparam(1, $orderid); //binds the params for security
    $stmt->execute(); //executes the pdo statement

    $sql = "DELETE FROM basket WHERE order_id = ?"; //sql statement to delete the order and the items in the basket
    $stmt = $conn->prepare($sql); //prepares the sql to bind param
    $stmt->bindparam(1, $orderid); //binds the params for security
    $stmt->execute(); //executes the pdo statement
    $conn = null; //closes the connection so it can't be abused
    return true; //returns true on success


}

function create_loyalty($conn, $userid, $points){ //function to create a row in the loyalty table on signup
        $sql = "INSERT INTO loyalty (user_id, points) VALUES (?,?)"; //sql statement
        $stmt = $conn->prepare($sql); //prepares the sql
        $stmt->bindparam(1, $userid); //bind params for security
        $stmt->bindparam(2, $points);

        $stmt->execute(); //executes the statement
        $conn = null; //closes the connection so it cant be abused
        return true; //returns true

}

function display_loyalty($conn, $userid){ //function to get the loyalty points to display to the user
        $sql = "SELECT points FROM loyalty WHERE user_id = ?"; //sql statement
        $stmt = $conn->prepare($sql); //prepares the sql
        $stmt->bindparam(1, $userid); //bind params for security
        $stmt->execute(); //executes the statement
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetches the result
        $conn = null; //closes the connection so it cant be abused
        return $result; //returns the result
}

function add_points($conn, $userid, $points){ //adds points to a users account when they place an order
    $sql = "UPDATE loyalty SET points = points + ? WHERE user_id = ?"; //sql statement
    $stmt = $conn->prepare($sql); //prepares statement
    $stmt->bindparam(1,$points); //binds parameters for security
    $stmt->bindparam(2, $userid);

    $stmt->execute(); //executes statement
    $conn = null; //closes connection so it can't be abused
    return true; //returns true on success
}

function remove_points($conn, $userid, $points){ //removes points from a users account when they return an order so they cant abuse the point system
    $sql = "UPDATE loyalty SET points = points - ? WHERE user_id = ?"; //sql statement
    $stmt = $conn->prepare($sql); //prepares statement
    $stmt->bindparam(1,$points); //binds params for security
    $stmt->bindparam(2, $userid);

    $stmt->execute(); //executes statement
    $conn = null; //closes connection so it cant be abused
    return true; //returns true on success
}

function get_farms($conn){
    $sql = "SELECT * FROM farms WHERE 1"; //sql statement
    $stmt = $conn->prepare($sql); //prepares to sql
    $stmt->execute(); //executes statement
    $result = $stmt->fetchall(PDO::FETCH_ASSOC); //returns the result as an associative array
    $conn = null; //closes connection so it cant be abused
    return $result; //returns the result

}








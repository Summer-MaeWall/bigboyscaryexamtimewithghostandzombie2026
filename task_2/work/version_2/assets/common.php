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
            $_SESSION['usermessage'] = "User not found"; //sends a user message if a user is not found
            header("Location: index.php"); //redirects user back to the index page
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

function getproducts($conn){
        $sql = "SELECT * FROM products";
        $stmt = $conn->prepare($sql); //prepares statement
        $stmt->execute(); //executes query
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetches all the products
        $conn = null; //closes the connection to prevent abuse
        return $result; //returns result
}

function getproductbyid($conn, $product_id){
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindparam(1, $product_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $conn = null;
        return $result;
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

function commit_order($conn, $post){
        // puts order into order table
    $sql = "INSERT INTO orders (user_id, type, delivery_date,order_date) VALUES (?,?,?,?)"; //prepared statement, this is the best way to prevent sql injections

    $stmt = $conn->prepare($sql); //prepares to sql
    $orderdate = date("Y-m-d"); //gets the date the order was created on for logging purposes

    $stmt->bindparam(1, $_SESSION['user']);//bind params for security
    $stmt->bindparam(2, $post['type']);
    $stmt->bindparam(3, $post['date']);
    $stmt->bindparam(4, $orderdate);

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
    }
    $conn = null;
    return true;
}


// this doesn't work with my system, this needs updating.
function stock_check($conn, $date){

    // 1. Get already sold totals for that date
    // Note: Use backticks ` or no quotes for table names, not single quotes '
    $sql = "SELECT b.product_id, SUM(b.quantity) as total_sold 
            FROM orders AS o 
            JOIN basket AS b ON o.order_id = b.order_id 
            WHERE o.delivery_date = ? 
            GROUP BY b.product_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$date]);
    // Use FETCH_KEY_PAIR to get [itemid => total_sold] for easy math
    $alreadySold = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    // 2. Get the master daily limits for items
    $sql = "SELECT product_id, quantity FROM products";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $dailyLimits = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $unavailableItems = [];

    // 3. Loop through the current user's basket
    foreach ($_SESSION['basket'] as $itemid => $requestedQuant) {
        #These lines use the Null Coalescing Operator (??), which is a shorthand way of
        # saying: "Try to use this value, but if it doesn't exist, use this default instead."

        $limit = $dailyLimits[$itemid] ?? 0;
        $sold = $alreadySold[$itemid] ?? 0;

        $remainingStock = $limit - $sold;

        if ($requestedQuant > $remainingStock) {
            // This item is short on stock! Store the ID (or name)
            $unavailableItems[] = $itemid;
        }
    }

    // Return the list of items that failed the check
    return $unavailableItems;

}






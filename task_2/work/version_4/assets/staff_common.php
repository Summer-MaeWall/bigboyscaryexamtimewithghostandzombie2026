<?php

//all functions will be stored in the common for proper code organisation and to reduce repeating code, making the system run faster (UAC 1.4)
// to reduce the change of an unregistered user breaching the system, The staff system will have its own common for functions so in the case of a breach,
// a hacker will not have access to the functions that can damage the staff system (eg cancelling order, removing products etc)

//to save time, the user message, login, audit and register system will be copied from the user side and altered to meet the needs for the staff system.
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

function login($conn, $post){
    $sql = "SELECT staff_id, password FROM staff WHERE email = ?"; //set up the sql statement
    $stmt = $conn->prepare($sql); //prepares the statement
    $stmt->bindparam(1, $post['email']); //binds parameters to execute
    $stmt->execute(); //run the sql code
    $result = $stmt->fetch(PDO::FETCH_ASSOC); //bring back results
    $conn = null; //nulls off the connection so can't be abused

    if($result) { //if there is a result returned
        return $result;
    } else {
        $_SESSION['usermessage'] = "ERROR: User not found!"; //sends a user message if a user is not found
        header("Location: staff_login.php"); //redirects user back to the index page
        exit; //stop further execution
    }
}

function audtitor($conn, $userid, $code, $long){ //on doing any action, the auditor logs it
    $sql = "INSERT INTO staff_audit ( staff_id, code, long_desc, date) VALUES (?,?,?,?)"; //prepared statement
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

function reg_user($conn, $post){
    $sql = "INSERT INTO staff (email, type, password, sign_up_date) VALUES (?,?,?,?)"; //sql statement
    $stmt = $conn->prepare($sql); //prepare to sql
    $signupdate = date("Y-m-d");
    $hpwsd = password_hash($post['password'], PASSWORD_DEFAULT); //hash the password,
    // using default encrytion because we don't have anything else built in.
    // If it was a production system i would use better encryption like bcrypt or argon.
    $stmt->bindparam(1, $post['email']); //bind parameters for security
    $stmt->bindparam(2, $post['type']);
    $stmt->bindparam(3, $hpwsd);
    $stmt->bindparam(4, $signupdate);

    $stmt->execute(); //run the query to insert
    $conn = null; //closes the connection so it cant be abuse
    return true; //registration successful

}

function email_ver($conn, $email){
    $sql = "SELECT email FROM staff WHERE email = ?"; //sql statement
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

function getStaffType ($conn, $userid){ //to get the staff type for organising pages and making sure staff can only access pages they need too.
        $sql = "SELECT type FROM staff WHERE staff_id = ?"; //sql statement
        $stmt = $conn->prepare($sql); //prepares statement

        $stmt->bindparam(1, $userid); //binds params for security

        $stmt->execute(); //executes statement
        $result = $stmt->fetch(PDO::FETCH_ASSOC); //fetches results
        $conn = null; //closes the connection so it cant be abused
        return $result; //returns results
}

function new_prod($conn, $post)
{
    $sql = "INSERT INTO products (name, description, farm, image, image_alt, price, quantity) VALUES (?,?,?,?,?,?,?)"; //sql statement
    $stmt = $conn->prepare($sql); //prepare to sql

    $img_name = $_POST['img']; //gets the image name inputted
    $img_folder = "assets/images/"; //sets the file path needed
    $img_path = $img_folder . $img_name; //creates an image path

    $stmt->bindparam(1, $post['name']); //bind parameters for security
    $stmt->bindparam(2, $post['desc']);
    $stmt->bindparam(3, $post['farm']);
    $stmt->bindparam(4, $img_path); //image is called in separately to add the file path needed
    $stmt->bindparam(5, $post['imgalt']);
    $stmt->bindparam(6, $post['price']);
    $stmt->bindparam(7, $post['quan']);

    $stmt->execute(); //run the query to insert
    $conn = null; //closes the connection so it cant be abuse
    return true; //registration successfulI had
}

function get_farms($conn){
    $sql = "SELECT * FROM farms WHERE 1"; //sql statement
    $stmt = $conn->prepare($sql); //prepares to sql
    $stmt->execute(); //executes statement
    $result = $stmt->fetchall(PDO::FETCH_ASSOC); //returns the result as an associative array
    $conn = null; //closes connection so it cant be abused
    return $result; //returns the result

}

function getproducts($conn){
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql); //prepares statement
    $stmt->execute(); //executes query
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetches all the products
    $conn = null; //closes the connection to prevent abuse
    return $result; //returns result
}


function add_stock($conn, $quan, $id){ //updates the quantity of items in the product table
    $sql = "UPDATE products SET quantity = quantity + ? WHERE product_id = ?"; //sql statement
    $stmt = $conn->prepare($sql); //prepares the sql statement
    $stmt->bindparam(1, $quan);
    $stmt->bindparam(2, $id);
    $stmt->execute(); //executes the
    $conn = null; //closes the connection so it can't be abused
    return true; //returns true on success
}



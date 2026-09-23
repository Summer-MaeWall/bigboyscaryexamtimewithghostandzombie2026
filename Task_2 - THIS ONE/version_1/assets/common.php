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
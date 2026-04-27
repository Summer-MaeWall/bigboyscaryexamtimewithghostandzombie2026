    <?php

    if (!isset($_GET['message'])) {  // checks if the message parameter exists in the URL
        session_start(); //starts the session
        $message = false; //sets the default value to false when no message is passed
    } else {
        //decode the message for display
        $message = htmlspecialchars(urldecode($_GET['message'])); //retrieves a message and decodes it into something meaningful (something that a user can understand)
    }


    require_once "assets/dbconn.php"; //requires in dbconn for the database connection
    require_once "assets/common.php"; //requires in common for functions


    echo "<!DOCTYPE html>";

        echo "<html lang='en'>"; //sets language to english
            echo "<head>";
                echo "<meta charset='UTF-8'>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>"; //meta data
                echo "<link rel='stylesheet' type='text/css' href='assets/styles.css'>"; //links the stylesheet
                echo "<title>About Us - Greenfield Local Hub</title>"; //puts a title on the tab of the page
            echo "</head>";

            echo "<body>";

                require "assets/header.php"; //requires the header for the page to load

                echo "<h1>About Us</h1>";

                // filler lorem ipsum. To be replaced by images and content provided by the client.
                // in a real development environment, The client would need to send the developers content to fill their webpages,
                // especially pages like an about page as well as product information.

                echo "<p>Aenean tristique id lorem eu bibendum. Cras ut semper purus. Curabitur viverra sollicitudin elementum. Sed quis aliquam ipsum.
                     Praesent sit amet orci consectetur turpis condimentum congue a condimentum nunc. Curabitur euismod efficitur est, a facilisis sapien bibendum sit amet.
                      Phasellus lectus lectus, sagittis vitae elit non, efficitur consectetur ex. Phasellus ut elit tincidunt, porta purus vel, mollis odio. Cras rhoncus est et 
                      euismod eleifend. Nullam luctus neque id orci tempor laoreet vel sed enim. Cras mollis orci vitae sodales consequat. Ut purus tellus, commodo quis felis pretium,
                       rhoncus semper massa. Nunc tempor eu ipsum nec porttitor. Suspendisse potenti.</p>";

                echo "<br>";

                echo "<p>Integer dictum faucibus enim vitae elementum. Donec sollicitudin libero at ullamcorper cursus. Maecenas a orci ex. 
                    Sed at elit vel arcu bibendum pretium volutpat eu odio. Duis at laoreet nisi. Integer ac ante scelerisque, dapibus tellus sed, tincidunt sem.
                     Fusce metus erat, lacinia in eros sed, tincidunt vulputate elit. Praesent pellentesque ac sem ac porta. Cras sed libero maximus, tristique quam ut, 
                     pellentesque purus. Mauris iaculis quam ut bibendum pharetra. Mauris odio urna, cursus a libero at, tempus tristique lorem. Curabitur id orci sit amet 
                     velit vestibulum rhoncus sed eget lacus. In in quam neque. Vivamus ut ex mi.</p>";
                echo "<p>Integer dolor nunc, maximus ut ultricies eget, faucibus ac justo. Nulla lorem dolor, sollicitudin ut libero sit amet,
                 ornare ultrices neque. Integer maximus augue vitae enim vestibulum eleifend. Etiam tempus diam in lorem posuere malesuada. Integer pulvinar arcu ullamcorper,
                  pretium dolor id, dignissim eros. Sed ligula ipsum, aliquam non nunc laoreet, tempus efficitur est. Vivamus posuere eleifend tellus eu ultrices. Aenean maximus
                   lectus non imperdiet volutpat.</p>";

                 echo "<br>";

                echo "<p>Sed nec libero id metus lacinia rhoncus id quis nisl. Curabitur molestie augue vitae hendrerit posuere. 
                    Donec consectetur maximus accumsan. Nullam mi neque, rhoncus vel erat sit amet, posuere mollis neque. Proin et dui nibh. 
                    Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam lectus nisl, sollicitudin et urna vel, 
                    posuere vulputate lorem. Integer lacus leo, molestie vel porta at, eleifend ac orci. Ut enim elit, condimentum a vehicula quis, hendrerit vitae ipsum. 
                    Vestibulum sagittis mi vel ante imperdiet, sed molestie massa ullamcorper. Nulla sed lorem ultrices, sollicitudin nibh iaculis, suscipit lacus. Proin at justo 
                    vitae tortor mollis placerat. Vestibulum nec felis at nisl euismod egestas. Mauris at luctus sapien. Nam vulputate vehicula nisl, a imperdiet velit.</p>";

                 echo "<br>";

                echo "<p>Sed et lectus sit amet odio faucibus porta. Sed gravida sapien sed purus faucibus vestibulum. 
                    Integer mollis erat molestie nisi malesuada, vel rutrum ex aliquam. Nulla lacinia leo quis nisi vehicula convallis. 
                    Sed sed tellus aliquet, tempor eros non, porta felis. Aenean fringilla, nibh vel blandit vehicula, lacus arcu cursus risus, et tincidunt sem felis at nisi.
                     Mauris mattis, nibh at molestie fringilla, arcu leo rutrum lacus, vitae consequat diam ipsum non dolor. Quisque tincidunt arcu felis, 
                     sit amet pharetra diam dapibus ut. Quisque vestibulum lorem eget purus aliquet, nec ornare ligula mattis. Nam lacinia, diam eu tincidunt sagittis, 
                     lacus orci condimentum arcu, at placerat dolor elit a est. Morbi congue bibendum est, quis aliquam ipsum vehicula quis.</p>";

                echo "<br>";

                echo user_message();

                try {
                    echo "";
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                require "assets/footer.php"; //requires the footer for the page to load

            echo "</body>";

        echo "</html>";


    if (!$message) {
        echo user_message();  // runs the user message function if the message variable is empty
    } else {
        echo $message;
    }
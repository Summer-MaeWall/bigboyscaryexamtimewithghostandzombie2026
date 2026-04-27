<?php
    echo "<header class='header'>";  // header tags since its the header
        echo"<nav>"; // defines everything into a nav
        echo "<a id='title'>Greenfield Local Hub</a><br>"; //should have a link to the home but don't know how to set it differently for logged in vs out yet.
        echo "<a id='subheading'>Locally Sourced Produce and Meats</a>";

        echo "<a href='basket.php'><img src='assets/images/basket.png' alt='a basket icon'</a>";

        echo "<ul class='nav_bar'>"; //declares an unordered list

            if (!isset($_SESSION['user'])){ //this changes what appears on the navbar depending on if the user is logged in or not.
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='products.php'>Browse Products ↓</a></li>";
                echo "<li><a href='about.php'>About us</a></li>";
                echo "<li><a href='register.php'>Register</a></li>";
                echo "<li><a href='login.php'>Login</a></li>";

            } else {
                echo "<li><a href='user_dash.php'>Home</a></li>"; //ignore these for now, not done.
                echo "<li><a href='products.php'>Browse Products ↓</a></li>";
                echo "<li><a href='about.php'>About us</a></li>";
                echo "<li><a href='orders.php'>View Orders</a></li>";
                echo "<li><a href='settings.php'>Settings</a></li>";
                echo "<li><a href='logout.php'>Logout</a></li>";
            }

        echo "</ul>";
        echo "</nav>";
    echo "</header>";
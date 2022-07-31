<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C19PPS index page</title>
    <link rel="stylesheet" href="CSS/style.css" type="text/css" />
    
</head>

<body>
    
    <nav>
        <div class="wrapper">       
            <a href=""><img src="IMG/1.png" alt="C19PPS logo"></a>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index_admin.php">Adminstrators</a></li>
                <li><a href="index_researcher.php">Researchers</a></li>
                <li><a href="index_orgDelegate.php">Delegates</a></li>
                <?php
                    // check if useruid is exist in the website to make sure users are logged in
                    //userid is stored in the session
                    if(isset($_SESSION["username"])) {
                        echo "<li><a href='subscribe.php'>My subscription</a></li>";
                        echo "<li><a href='logout.php'>Log out</a></li>"; 
                    }
                    else {
                        echo "<li><a href='signup.php'>Sign up</a></li>";
                        echo "<li><a href='login.php'>Log in</a></li>";
                    }
                ?>
            </ul>
        </div>
    </nav>

    <div class="wrapper">
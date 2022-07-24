<?php

if(isset($_POST["submit"])) {

    $userName = $_POST["uid"];
    $password = $_POST["password"];

    require_once 'dbh.php';
    require_once 'functions.php';

    if(emptyInputLogin($userName, $password) !== false) {
        header("location: ../PHP/login.php?error=emptyinput");
        exit();
    }

    loginUser($connection, $userName, $password);

}

else {
    // if users input username and password incorrectly, send back to login page
    header("location: ../PHP/login.php");
    exit();
}
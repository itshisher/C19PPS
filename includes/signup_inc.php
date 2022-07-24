<?php

// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["submit"])) {   

    $name = $_POST["lName"];
    $email = $_POST["email"];
    $userName = $_POST["uid"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];

    //include error handlers to catch potential problems users made
    require_once 'dbh.php';
    require_once 'functions.php';

    if(emptyInputSignup($name, $email, $userName, $password, $passwordRepeat) !== false) {
        header("location: ../PHP/signup.php?error=emptyinput");
        exit();
    }

    if(invalidUid($userName) !== false) {
        header("location: ../PHP/signup.php?error=invaliduid");
        exit();
    }

    if(pwdMatch($password, $passwordRepeat) !== false) {
        header("location: ../PHP/signup.php?error=pwdnotmatch");
        exit();
    }

    if(uidExists($connection, $userName, $email) !== false) {
        header("location: ../PHP/signup.php?error=usernametaken");
        exit();
    }

    createUser($connection, $name, $email, $userName, $password);

}
else {
    header("location: ../PHP/signup.php");
    exit();
}
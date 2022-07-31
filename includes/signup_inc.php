<?php

// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["submit"])) {   

    $fname = $_POST["fName"];
    $lname = $_POST["lName"];
    $citizenship = $_POST["citizenship"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $userName = $_POST["uid"];
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];
    

    //include error handlers to catch potential problems users made
    require_once 'dbh.php';
    require_once 'functions.php';

    if(emptyInputSignup($fname, $lname, $citizenship, $email, $phone, $userName, $password, $passwordRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if(invalidUid($userName) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }

    if(pwdMatch($password, $passwordRepeat) !== false) {
        header("location: ../signup.php?error=pwdnotmatch");
        exit();
    }

    if(uidExists($connection, $userName, $email) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    createUser($connection, $fname, $lname, $citizenship, $email, $phone, $userName, $password);

}
else {
    header("location: ../signup.php");
    exit();
}
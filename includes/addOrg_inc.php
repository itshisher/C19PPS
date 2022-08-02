<?php

// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["submitNewUser"])) {   

    $afname = $_POST["addFname"];
    $alname = $_POST["addLname"];
    $acitizenship = $_POST["addCitizen"];
    $aemail = $_POST["addEmail"];
    $aphone = $_POST["addPhone"];
    $auserName = $_POST["addUsername"];
    $auserType = $_POST["addUserType"];
    $apassword = $_POST["addPassword"];
    $apasswordRepeat = $_POST["rptPassword"];
    

    //include error handlers to catch potential problems users made
    require_once 'dbh.php';
    require_once 'functions.php';

    if(emptyInputSignup($afname, $alname, $acitizenship, $aemail, $aphone, $auserName, $apassword, $apasswordRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }

    if(invalidUid($auserName) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }

    if(pwdMatch($apassword, $apasswordRepeat) !== false) {
        header("location: ../signup.php?error=pwdnotmatch");
        exit();
    }

    if(uidExists($connection, $auserName, $aemail) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    addUser($connection, $afname, $alname, $acitizenship, $aemail, $aphone, $auserName, $auserType, $apassword);

}
else {
    header("location: ../addUser.php");
    exit();
}
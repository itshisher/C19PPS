<?php

// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["editUser"])) {   

    $vUser = $_POST["verifyUser"];
    $edituserTpye = $_POST["editUserType"];
    $suspend = $_POST["editIsSuspend"];
    
    

    //include error handlers to catch potential problems users made
    require_once 'dbh.php';
    require_once 'functions.php';


    // if(!(uidExists($connection, $vUser) !== false)) {
    //     header("location: ../editUser.php?error=usernotexist");
    //     exit();
    // }

    // this function cannot be done 
    editUser($connection, $vUser, $edituserTpye, $suspend);

}
else {
    header("location: ../editUser.php");
    exit();
}
<?php

// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["editUser"])) {   
    
    // @yang data validation?
    $uid = $_POST['uid'];
    $ufname = $_POST['uFName'];
    $ulname = $_POST['ulname'];
    $citizenship = $_POST['citizenship'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $isSuspended = $_POST['isSuspended'];
    $suspendDate = $_POST['suspendDate'];
    $userType = $_POST['userType'];
    
    $sql = "
    UPDATE User SET
    uFName = $ufname,
    uLName = $ulname,
    @yang complete the other attributes
    ...
    WHERE userID=$uid;
    ";


    //include error handlers to catch potential problems users made
    require_once 'dbh.php';
    require_once 'functions.php';

    // @yang execute the UPDATE query on the database
    // https://www.php.net/manual/en/book.mysqli.php
    // https://duckduckgo.com/?t=ffab&q=php+update+mysqli&ia=web

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
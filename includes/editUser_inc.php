<?php

require_once 'dbh.php';
// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["editUser"])) {   
    
    $uid = $_POST['uid'];
    $ufname = $_POST['uFName'];
    $ulname = $_POST['uLName'];
    $citizenship = $_POST['citizenship'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $isSuspended = $_POST['isSuspended'];
    $suspendDate = $_POST['suspendDate'];
    $userType = $_POST['userType'];
    
    
    $sql = "UPDATE User 
    SET uFName = '$ufname',
    uLName = '$ulname',
    citizenship = '$citizenship',
    phone_number = '$phone_number',
    email = '$email',
    username = '$username',
    isSuspended = $isSuspended,
    suspendDate = '$suspendDate',
    userType = '$userType'
    WHERE userID = $uid;";


    // @yang execute the UPDATE query on the database
    // https://www.php.net/manual/en/book.mysqli.php
    // https://duckduckgo.com/?t=ffab&q=php+update+mysqli&ia=web
    if ($connection->query($sql) === TRUE) {
        echo ("<script LANGUAGE='JavaScript'>
                        window.alert('Congrats! You have successfully edited an user!');
                        window.location.href='../cded_users.php';
                    </script>");
      } else {
        echo "Error updating record: " . $connection->error;
      }
   
}
else {
    header("location: ../cded_users.php");
    exit();
}
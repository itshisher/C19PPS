<?php

// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["addNewOrg"])) {   

    $addOrgName = $_POST["addOrgName"];
    $addOrgType = $_POST["addOrgType"];
    $addOrgCountryID = $_POST["addOrgCountryID"];
   
    

    //include error handlers to catch potential problems users made
    require_once 'dbh.php';
    require_once 'functions.php';


    addOrg($connection, $addOrgName, $addOrgType, $addOrgCountryID);

}
else {
    header("location: ../addUser.php");
    exit();
}
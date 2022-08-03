<?php

// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["addNewEmp"])) {   

    $addEmpFname = $_POST["addEmpFname"];
    $addEmpLName = $_POST["addEmpLName"];
    $addEmpTitle = $_POST["addEmpTitle"];
    $addEmpOrgID = $_POST["addEmpOrgID"];
    

    //include error handlers to catch potential problems users made
    require_once 'dbh.php';
    require_once 'functions.php';


    addEmp($connection, $addEmpFname, $addEmpLName, $addEmpTitle, $addEmpOrgID);

}
else {
    header("location: ../addEmployee.php");
    exit();
}
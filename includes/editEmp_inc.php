<?php

require_once 'dbh.php';
// unless users click on sumbit button to sign up, otherwise they will be send back to the sign up web page
if(isset($_POST["editEmp"])) {   
    
    $eID = $_POST['eID'];
    $eFName = $_POST['eFName'];
    $eLName = $_POST['eLName'];
    $jobTitle = $_POST['jobTitle'];
    $empOrgID = $_POST['empOrgID'];
    
    $sql = "UPDATE Employees 
    SET efName = '$eFName',
    eLName = '$eLName',
    job_title = '$jobTitle',
    oID = $empOrgID
    WHERE eID = $eID;";


    // @yang execute the UPDATE query on the database
    // https://www.php.net/manual/en/book.mysqli.php
    // https://duckduckgo.com/?t=ffab&q=php+update+mysqli&ia=web
    if ($connection->query($sql) === TRUE) {
        echo ("<script LANGUAGE='JavaScript'>
                        window.alert('Congrats! You have successfully edited an organization!');
                        window.location.href='../cded_employee.php';
                    </script>");
      } else {
        echo "Error updating record: " . $connection->error;
      }
    
}
else {
    header("location: ../cded_orgs.php");
    exit();
}
<?php

$serverName = "ouc353.encs.concordia.ca:3306";
$DBUserName = "ouc353_1";
$DBPassword = "YSYD1234";
$DBName = "ouc353_1";

$connection = mysqli_connect($serverName, $DBUserName, $DBPassword, $DBName);

if(!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// try{
//     $connection = new PDO("mysql:host=$serverName; dbname=$DBName;", $DBUserName, $DBPassword);
// } catch (PDOException $e) {
//     die('Connection Failed: ' . $e -> getMessage());
// }
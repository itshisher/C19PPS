<?php

$serverName = "localhost";
$DBUserName = "root";
$DBPassword = "";
$DBName = "login_test";

$connection = mysqli_connect($serverName, $DBUserName, $DBPassword, $DBName);

if(!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
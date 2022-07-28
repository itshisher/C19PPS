<?php

function emptyInputSignup($name, $email, $userName, $password, $passwordRepeat) {
    $result;
    if(empty($name) || empty($email) || empty($userName) || empty($password) || empty($passwordRepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($userName) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $userName)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $passwordRepeat) {
    $result;
    if ($password != $passwordRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($connection, $userName, $email) {
    $result;
    $sql = "SELECT * FROM ouc353_1.users WHERE usersUid = ? or usersEmail = ?;";
    // initialize a statement to use sql statements 
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../PHP/signup.php?error=stmtfailed");
        exit();
    }

    //pass the data from users
    mysqli_stmt_bind_param($stmt, "ss", $userName, $email);
    mysqli_stmt_execute($stmt);
    
    $resultData = mysqli_stmt_get_result($stmt);

    // returns true if get some data from the database
    if($row = mysqli_fetch_assoc($resultData)) {
        // this parameter will be used again in login form
        return $row;
    }
    else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createUser($connection, $name, $email, $userName, $password) {
    $sql = "INSERT INTO ouc353_1.users(UsersName, UsersEmail, UsersUID, UsersPwd) VALUES (?, ?, ?, ?);";
    //initialize a statment using the connection to the database
    $stmt = mysqli_stmt_init($connection);
    //check if it's possible to give database the information above 
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../PHP/signup.php?error=stmtfailed");
        exit();
    }
    //use function hashed password to provide more security
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    //then bind parameters to the database
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $userName, $hashedPwd);
    // execute the statement
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../PHP/signup.php?error=none");
    exit();
}

function emptyInputLogin($userName, $password) {
    $result;
    if(empty($userName) || empty($password)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($connection, $userName, $password) {
    //function uidExists ask either if the user input their username or email
    // users can decide to login use thier username or email address
    $uidExists = uidExists($connection, $userName, $userName);

    if($uidExists === false) {
        header("location: ../PHP/login.php?error=wronglogin");
        exit();
    }

    // UsersPwd is the attribute in the database
    $pwdHashed = $uidExists["UsersPwd"];
    // check if the password users input matches to the hashed password
    $checkPwd = password_verify($password, $pwdHashed);

    if($checkPwd === false) {  
        //wrong password
        header("location: ../PHP/login.php?error=wronglogin");
        exit();
    }
    else if($checkPwd === true) {
        //log in users into the website
        //start sessions to store data
        session_start();
        $_SESSION["userid"] = $uidExists["usersID"];
        $_SESSION["useruid"] = $uidExists["UsersUID"];
        //successfully loged in, go to the main webpage
        header("location: ../PHP/index.php");
        exit();
    }
}
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
    if (!preg_match("/^[a-zA-Z0-9]*$/"), $userName) {
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

// function uidExists($connection, $userName, $email) {
//     $sql = "SELECT * FROM users WHERE usersUid = ? or usersEmail = ?;";
//     $stmt = mysqli_stmt_init($connection);
//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../PHP/signup.php?error=stmtfailed");
//         exit();
//     }
// }
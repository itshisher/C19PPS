<?php

function emptyInputSignup($fname, $lname, $citizenship, $email, $phone, $userName, $password, $passwordRepeat) {
    $result;
    if(empty($fname) || empty($lname) || empty($citizenship) || empty($email)|| empty($phone) || empty($userName) || empty($password) || empty($passwordRepeat)){
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
    $sql = "SELECT * FROM ouc353_1.User WHERE username = ? or email = ?;";
    // initialize a statement to use sql statements 
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
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

function createUser($connection, $fname, $lname, $citizenship, $email, $phone, $userName, $password) {
    $sql = "INSERT INTO ouc353_1.User(uFName, uLName, citizenship, email, phone_number, username, password) VALUES (?, ?, ?, ?, ?, ?, ?);";
    //initialize a statment using the connection to the database
    $stmt = mysqli_stmt_init($connection);
    //check if it's possible to give database the information above 
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    //use function hashed password to provide more security
    //$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    //then bind parameters to the database
    mysqli_stmt_bind_param($stmt, "sssssss", $fname, $lname, $citizenship, $email, $phone, $userName, $password);
    // execute the statement
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

//add new users
function addUser($connection, $fname, $lname, $citizenship, $email, $phone, $userName, $userType,$password) {
    $sql = "INSERT INTO ouc353_1.User(uFName, uLName, citizenship, email, phone_number, username, userType, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    //initialize a statment using the connection to the database
    $stmt = mysqli_stmt_init($connection);
    //check if it's possible to give database the information above 
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    //use function hashed password to provide more security
    //$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    //then bind parameters to the database
    mysqli_stmt_bind_param($stmt, "ssssssss", $fname, $lname, $citizenship, $email, $phone, $userName, $userType, $password);
    // execute the statement
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../addUser.php?error=none");
    exit();
}

// edit user
function editUser($connection, $username, $userType, $isSuspended) {
    // $sql = "INSERT INTO ouc353_1.User(uFName, uLName, citizenship, email, phone_number, username, userType, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
    $sql = "UPDATE ouc353_1.User SET userType = $userType, isSuspended = $isSuspended WHERE username = $username";
    //initialize a statment using the connection to the database
    $stmt = mysqli_stmt_init($connection);
    //check if it's possible to give database the information above 
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    //use function hashed password to provide more security
    //$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    //then bind parameters to the database
    mysqli_stmt_bind_param($stmt, "sss", $username, $userType, $isSuspended);
    // execute the statement
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../editUser.php?error=none");
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
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    // UsersPwd is the attribute in the database
    //$pwdHashed = $uidExists["password"];
    $pwd = $uidExists["password"];
    $isSuspended = $uidExists["isSuspended"];
    // check if the password users input matches to the hashed password
    //$checkPwd = password_verify($password, $pws);

    if($pwd !== $password) {  
        //wrong password
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if($isSuspended == 1) {
        header("location: ../login.php?error=issuspended");
        exit();
    }
    else if($pwd === $password) {
        //log in users into the website
        //start sessions to store data
        session_start();
        $_SESSION["userType"] = $uidExists["userType"];
        $_SESSION["username"] = $uidExists["username"];
        
        $_SESSION["isSuspended"] = $uidExists["isSuspended"];

        //successfully loged in, go to the main webpage

        $name = $uidExists["username"];
        $sql = "SELECT userType FROM ouc353_1.User WHERE username='$name'";
        $result = $connection->query($sql);

        if ($result->num_rows == 1) {
            // Get user type
            $row = $result->fetch_assoc();
            $uType = $row["userType"];

            switch($uType) {
                
                case "administrator": 
                    header("location: ../index_admin.php");
                    exit();
                    break;

                case "researchers": 
                    header("location: ../index_researcher.php");
                    exit();
                    break;

                case "organizationDele": 
                    header("location: ../index_orgDelegate.php");
                    exit();
                    break;

                case "regular": 
                    header("location: ../index.php");
                    exit();
                    break;
                
            }
        }
        else{
            echo "no result";
        }

        header("location: ../index.php");
        exit();
    }
    
}


/**
 * Displays the result of a SQL query as an HTML table.
 *
 * This table can be stylized through the qryres-{table|tr|th|td} CSS classes.
 *
 * $result The result of the query, as returned by mysqli::query.
 * $headers A list of strings for the table headers (th) to be displayed.
 */
function display_qry_result($result, $headers) {
    if ($result->num_rows == 0) {
        echo '0 results';
        return;
    }

    // Display result table
    echo '<table class="qryres-table">';

    // Display table headers
    echo '<tr class="qryres-tr">';
    foreach ($headers as $th)
        echo '<th class="qryres-th">' . htmlspecialchars($th) . '</th>';
    echo '</tr>';

    // Display table body, the sql query result
    while ($row = $result->fetch_assoc()) {
        echo '<tr class="qryres-tr">';
        foreach ($row as $td)
            echo '<td class="qryres-td">' . htmlspecialchars($td) . '</td>';
        echo '</tr>';
        
    }
    
    echo '</table>';
}

// create a table with an extra column shows delete/edit actions
function display_qry_result2($result, $headers) {
    if ($result->num_rows == 0) {
        echo '0 results';
        return;
    }

    // Display result table
    echo '<table class="qryres-table">';

    // Display table headers
    echo '<tr class="qryres-tr">';
    foreach ($headers as $th)
        echo '<th class="qryres-th">' . htmlspecialchars($th) . '</th>';
    echo '</tr>';

    // Display table body, the sql query result
    while ($row = $result->fetch_assoc()) {
        $id = array_shift($row);
        echo '<tr class="qryres-tr">';
        foreach ($row as $td)
            echo '<td class="qryres-td">' . htmlspecialchars($td) . '</td>';
            echo '<td><a href="editUser.php?id=' . $id . '">Edit</a> &nbsp <a href="deleteUser.php?id=' . $id . '">Delete</a></td>';
        echo '</tr>';

        
    }
    
    echo '</table>';
}
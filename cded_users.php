<?php
    include_once 'header.php';
?>

    <section class="index-intro">
        <p>Following are all the users that exist in our system</p>

        
        <?php 

            require_once 'includes/dbh.php';
            
            $sql = "SELECT userID, userType, username, uFName, uLName, citizenship, email, phone_number FROM ouc353_1.User";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $headers = ["user role", "username", "first name", "last name", "citizenship", "email", "phone", "Actions"];
                require_once 'includes/functions.php';
                $url_edit = 'editUser.php';
                $url_delete = 'deleteUser.php';
                display_qry_result2($result, $headers, $url_edit, $url_delete);
            } else {
                echo "0 results";
            }
        ?>
        <br>
        <a href="addUser.php">Add a user</a> <br><br>
        <a href="index_admin.php">Go back to Admin page</a>

    </section>
    

<?php
    include_once 'footer.php';
?>
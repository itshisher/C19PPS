<?php
    include_once 'header.php';
?>

    <section class="signup-form">
        <p>Edit a user</p>
        <form action="includes/editUser_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="verifyUser" placeholder="Enter username to verify"> <br>
                <input type="text" name="editUserType" placeholder="Edit users' type"> <br>
                <input type="number" name="editIsSuspend" placeholder="Enter 1 to suspend a user, else enter 0" min="0", max="1"> <br>
                <button type="sumbit" name="editUser">Edit</button>
            </div>
            </form>
            
        <br>
        <a href="cded_users.php">GO back</a>
        <?php
            if(isset($_GET["error"])) {
                if($_GET["error"] == "emptyinput") {
                    echo "<p>Please fill all blanks!</p>";
                }

                else if($_GET["error"] == "usernotexist") {
                    echo "<p>User does not exist in the database, Please try again!</p>";
                }
                
            }
        ?>

    </section>
    

<?php
    include_once 'footer.php';
?>
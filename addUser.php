<?php
    include_once 'header.php';
    
?>

    <section class="signup-form">
        <h2>Add a user</h2>
        <form action="includes/addUser_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="addFname" placeholder="Please enter his/her first name"> <br>
                <input type="text" name="addLname" placeholder="Please enter his/her last name"> <br>
                <input type="text" name="addCitizen" placeholder="Please enter his/her citizenship"> <br>
                <input type="text" name="addEmail" placeholder="Please enter his/her email address"> <br>
                <input type="tel" name="addPhone" placeholder="Phone number..."> <br>
                <input type="text" name="addUsername" placeholder="Please enter his/her username"> <br>
                <input type="text" name="addUserType" placeholder="Please determine his/her user type"> <br>
                <input type="password" name="addPassword" placeholder="Please create a password"> <br>
                <input type="password" name="rptPassword" placeholder="Peasee repeat the password"> <br>
                <button type="sumbit" name="submitNewUser">Add</button> <br><br>
                <a href="cded_users.php">Go back</a>
            </div>
        </form>
        <!--error messages or sign up messages are included here  -->
        <?php
            if(isset($_GET["error"])) {
                if($_GET["error"] == "emptyinput") {
                    echo "<p>Please fill all blanks!</p>";
                }

                else if($_GET["error"] == "invaliduid") {
                    echo "<p>Please enter a valid username!</p>";
                }

                else if($_GET["error"] == "pwdnotmatch") {
                    echo "<p>Password does not match, please enter again</p>";
                }

                else if($_GET["error"] == "usernametaken") {
                    echo "<p>Username exists already, please try again</p>";
                }

                else if($_GET["error"] == "none") {
                    echo "<p>Congrats! You have successfully added a new user!</p>";
                }
            }
        ?>
    </section>

    


<?php
    include_once 'footer.php';
?>
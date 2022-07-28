<?php
    include_once 'header.php';
?>
    
    <section class="signup-form">
        <h2>Sign up</h2>
        <form action="includes/signup_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="fName" placeholder="First name..."> <br>
                <input type="text" name="lName" placeholder="Last name..."> <br>
                <input type="text" name="citizenship" placeholder="Citizenship..."> <br>
                <input type="email" name="email" placeholder="Email address..."> <br>
                <input type="tel" name="phone" placeholder="Phone number..."> <br>
                <input type="text" name="uid" placeholder="Username..."> <br>
                <input type="password" name="password" placeholder="Password..."> <br>
                <input type="password" name="passwordRepeat" placeholder="Repeat your password..."> <br>
                <button type="sumbit" name="submit">Sign up</button>
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
                    echo "<p>Thanks! You are successfully signed up!</p>";
                }
            }
        ?>
    </section>

    


<?php
    include_once 'footer.php';
?>
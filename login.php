<?php
    include_once 'header.php';
?>
    
    <section class="signup-form">
        <h2>Log in</h2>
        <form action="includes/login_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="uid" placeholder="Username/Email..."> <br>
                <input type="password" name="password" placeholder="Password..."> <br>
                <button type="sumbit" name="submit">Log in</button>
            </div>
        </form>
        <!--error messages or sign up messages are included here  -->
        <?php
            if(isset($_GET["error"])) {
                if($_GET["error"] == "emptyinput") {
                    echo "<p>Please fill all blanks!</p>";
                }

                else if($_GET["error"] == "wronglogin") {
                    echo "<p>Incorrect login information, please enter again!</p>";
                }
                else if($_GET["error"] == "issuspended") {
                    echo "<p>Your account is suspended by an adminstrator, please contact him!</p>";
                }
            }
        ?>
    </section>

<?php
    include_once 'footer.php';
?>
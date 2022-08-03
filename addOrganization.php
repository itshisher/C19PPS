<?php
    include_once 'header.php'; 
?>

    <section class="signup-form">
        <h2>Add an organization</h2>
        <form action="includes/addOrg_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="addOrgName" placeholder="Please enter an organization name"> <br>
                <input type="text" name="addOrgType" placeholder="Research center/Company/Government agency"> <br>
                <input type="number" name="addOrgCountryID" placeholder="Please indicate Country ID for this organization" max="10" min="1"> <br>
        
                <button type="sumbit" name="addNewOrg">Add</button> <br><br>
                <a href="cded_orgs.php">Go back</a>
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
                    echo "<p>Congrats! You have successfully added a new organization!</p>";
                }
            }
        ?>
    </section>

    


<?php
    include_once 'footer.php';
?>
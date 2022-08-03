<?php
    include_once 'header.php'; 
?>

    <section class="signup-form">
        <h2>Add an employee</h2>
        <form action="includes/addEmp_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="addEmpFname" placeholder="Please enter his/her first name"> <br>
                <input type="text" name="addEmpLName" placeholder="Please enter his/her last name"> <br>
                <input type="text" name="addEmpTitle" placeholder="Please enter his/her job title"> <br>
                <input type="number" name="addEmpOrgID" min="0" placeholder="Please indicate organization ID for this employee" > <br>
        
                <button type="sumbit" name="addNewEmp">Add</button> <br><br>
                <a href="cded_employee.php">Go back</a>
            </div>
        </form>
        <!--error messages or sign up messages are included here  -->
        <?php
            if(isset($_GET["error"])) {
                if($_GET["error"] == "emptyinput") {
                    echo "<p>Please fill all blanks!</p>";
                }

                else if($_GET["error"] == "none") {
                    echo "<p>Congrats! You have successfully added a new employee!</p>";
                }
            }
        ?>
    </section>

    


<?php
    include_once 'footer.php';
?>
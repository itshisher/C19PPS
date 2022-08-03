<?php

    include_once 'header.php';
    require_once 'includes/dbh.php';

    if(!isset($_GET['id'])) {
    header('location: cded_employee.php');
    }

    
    $eid = $_GET['id'];
    $emp_result = $connection->query("
    SELECT efName,
        eLName,
        job_title,
        oID
    FROM Employees
    WHERE eID=$eid;
    ");

    $some_new_var = $emp_result->fetch_assoc();
    ?>

    <section class="signup-form">
        <p>Edit an organization</p>
        <form action="includes/editEmp_inc.php" method="post">
            <div class="signup-form-style">
                <input type="hidden" name="eID" value="<?=$eid?>"/>
                <div>
                    <label for="eFName">First name:</label>
                    <input type="text" name="eFName" id="eFName" value=<?=$some_new_var['efName']?>>
                </div>
                <div>
                    <label for="eLName">Last name:</label>
                    <input type="text" name="eLName" id="eLName" value=<?=$some_new_var['eLName']?>>
                </div>
                <div>
                    <label for="jobTitle">Job title:</label>
                    <input type="text" name="jobTitle" id="jobTitle" value=<?=$some_new_var['job_title']?>>
                </div>
                <div>
                    <!-- @yang maybe make a <select> with <option> for the countries -->
                    <label for="empOrgID">Organization ID:</label>
                    <input type="text" name="empOrgID" id="empOrgID" value=<?=$some_new_var['oID']?>>
                </div>
                
                <button type="sumbit" name="editEmp">Edit</button>
            </div>
            </form>
            
        <br>
        <a href="cded_employee.php">GO back</a>
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
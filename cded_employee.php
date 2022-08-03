<?php
    include_once 'header.php';
?>

    <section class="index-intro">
        <p>Following are all the employees of organizations that exist in our system</p>

        
        <?php 

            require_once 'includes/dbh.php';
            
            $sql = "SELECT eID, efName, eLName, job_title, oID FROM ouc353_1.Employees";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $headers = ["Employee first name", "Employee last name", "Job title", "Organization ID", "Actions"];

                require_once 'includes/functions.php';
                
                edit_del_emp($result, $headers);
            } else {
                echo "0 results";
            }
        ?>
        <br>
        <a href="addEmployee.php">Add an Employee</a> <br><br>
        <a href="index_admin.php">Go back to Admin page</a>

    </section>
    

<?php
    include_once 'footer.php';
?>
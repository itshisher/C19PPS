<?php
    include_once 'header.php';
?>

    <section class="index-intro">
        <p>Following are all the organizations that exist in our system</p>

        
        <?php 

            require_once 'includes/dbh.php';
            
            $sql = "SELECT oID, oName, oType, countryID FROM ouc353_1.Organizations";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $headers = ["Organization name", "Organization type", "Country ID", "Actions"];

                require_once 'includes/functions.php';
                
                edit_del_org($result, $headers);
            } else {
                echo "0 results";
            }
        ?>
        <br>
        <a href="addOrganization.php">Add an Organization</a> <br><br>
        <a href="index_admin.php">Go back to Admin page</a>

    </section>
    
<?php
    include_once 'footer.php';
?>
<?php

    include_once 'header.php';
    require_once 'includes/dbh.php';

    if(!isset($_GET['id'])) {
    header('location: cded_orgs.php');
    }

    
    $oid = $_GET['id'];
    $org_result = $connection->query("
    SELECT oName,
        oType,
        countryID
    FROM Organizations
    WHERE oID=$oid;
    ");

    $some_new_var = $org_result->fetch_assoc();
    ?>

    <section class="signup-form">
        <p>Edit an organization</p>
        <form action="includes/editOrg_inc.php" method="post">
            <div class="signup-form-style">
                <input type="hidden" name="oID" value="<?=$oid?>"/>
                <div>
                    <label for="oName">Organization name:</label>
                    <input type="text" name="oName" id="oName" value=<?=$some_new_var['oName']?>>
                </div>
                <div>
                    <label for="oType">Organization type:</label>
                    <input type="text" name="oType" id="oType" placeholder="Research center/Company/Government agency" value=<?=$some_new_var['oType']?>>
                </div>
                <div>
                    <!-- @yang maybe make a <select> with <option> for the countries -->
                    <label for="countryID">Country ID:</label>
                    <input type="text" name="countryID" id="countryID" value=<?=$some_new_var['countryID']?>>
                </div>
                
                <button type="sumbit" name="editOrg">Edit</button>
            </div>
            </form>
            
        <br>
        <a href="cded_orgs.php">GO back</a>
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
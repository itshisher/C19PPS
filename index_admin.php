<?php
    include_once 'header.php';
?>

<section class="index-intro">
        <h1>Welcome! 
            <?php
                if(isset($_SESSION["username"]) && $_SESSION["userType"] == "Admin") {
                    echo $_SESSION["username"];
                    
                }
                else {
                    echo ("<script LANGUAGE='JavaScript'>
                        window.alert('Sorry, you are not a adminstrator.');
                        window.location.href='index.php';
                    </script>");
                }
            ?>
        </h1>

        <!-- following include normal features that can be also seen by other users -->
        <p>You are the adminstrator.</p>
        <p>Please choose one of the following options:</p>

        <button id="users">Create/Delete/Edit users</button>
        <button id="orgs">Create/Delete/Edit organizations</button>
        <button id="country">Create/Delete/Edit countries</button>
        <button id="prostater">Create/Delete/Edit province/states/territories</button>
        

        
</section>

<?php
    include_once 'footer.php';
?>
<?php
    include_once 'header.php';
?>

<section class="index-intro">
        <h1>Welcome! 
            <?php
                if(isset($_SESSION["username"]) && $_SESSION["userType"] == "researchers") {
                    echo $_SESSION["username"];
                    
                }
                else {
                    echo ("<script LANGUAGE='JavaScript'>
                        window.alert('Sorry, you are not a researcher.');
                        window.location.href='index.php';
                    </script>");
                }
            ?>
        </h1>

        <!-- following include normal features that can be also seen by other users -->
        <p>You are the researcher.</p>
        <p>Please choose one of the following options:</p>
        
</section>

<?php
    include_once 'footer.php';
?>
<?php
    include_once 'header.php';
?>

<section class="index-intro">
        <h1>Welcome! 
            <?php
                echo $_SESSION["username"];
            ?>
        </h1>

        <!-- following include normal features that can be also seen by other users -->
        
</section>

<?php
    include_once 'footer.php';
?>
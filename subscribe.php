<?php
    include_once 'header.php';
?>

    <section class="index-intro">
        <p>Following are all the authors that exist in our system</p>

        
        <?php 

            require_once 'includes/dbh.php';
            
            $sql = "SELECT aID, author, authorType, majorTopic, minorTopic FROM ouc353_1.Articles";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $headers = ["Author name", "Author type", "Major topic", "Minor topic", "Actions"];

                require_once 'includes/functions.php';
                
                sub_author($result, $headers);
            } else {
                echo "0 results";
            }
        ?>
        <br>

    </section>
    
<?php
    include_once 'footer.php';
?>
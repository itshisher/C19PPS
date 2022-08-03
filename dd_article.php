<?php
    include_once 'header.php';
?>

    <section class="index-intro">
        <p>Following are all the articles that exist in our system</p>

        
        <?php 

            require_once 'includes/dbh.php';
            
            $sql = "SELECT aID, author, authorType, majorTopic, minorTopic FROM ouc353_1.Articles";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                $headers = ["Article ID" ,"Author name", "Author type", "Major topic", "Minor topic"];

                require_once 'includes/functions.php';
                
                display_qry_result($result, $headers);
            } else {
                echo "0 results";
            }
        ?>
        <br>
        <a href="index_admin.php">Go back to Admin page</a>

    </section>
    
<?php
    include_once 'footer.php';
?>
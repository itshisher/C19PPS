<?php
    include_once 'header.php';
?>

    <section class="index-intro">
        <h1>COVID-19 Pandemic Progress System</h1>
        <p>The C19PPS system help researchers, companies, and world population to keep track of the COVID-19 pandemic progress.</p>
        
        <?php 
		
		
	
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("06spareek@gmail.com","DB email notification test",$msg);


            require_once 'includes/dbh.php';
            
            $sql = "SELECT cName FROM ouc353_1.Countries";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<br> name: ". $row["cName"] . "<br>";
                }
            } else {
                echo "0 results";
            }
        ?>
    </section>
    

<?php
    include_once 'footer.php';
?>
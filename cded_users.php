<?php
    include_once 'header.php';
?>

    <section class="index-intro">
        <h1>COVID-19 Pandemic Progress System</h1>
        <p>The C19PPS system help researchers, companies, and world population to keep track of the COVID-19 pandemic progress.</p>
        
        <table>
            <thead>
                <tr>
                    <td>User role</td>
                    <td>Username</td>
                    <td>First name</td>
                    <td>Last name</td>
                    <td>Citizenship</td>
                    <td>Email address</td>
                    <td>Phone numer</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    require_once 'includes/dbh.php';

                    $sql = "SELECT * FROM ouc353_1.newUser";
                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {
                            <tr>
                                <td><? $row["userType"]</td>
                                <td> $row["username"]</td>
                                <td> $row["fName"]</td>
                                <td> $row["lName"]</td>
                                <td> $row["citizenship"]</td>
                                <td> $row["email"]</td>
                                <td> $row["phone"]</td>
                            </tr>
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
            </tbody>
        </table>

        <?php 

            require_once 'includes/dbh.php';
            
            $sql = "SELECT * FROM ouc353_1.newUser";
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
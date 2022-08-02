<?php
if(!isset($_GET['id'])) {
  header('location: cded_users.php');
}

$uid = $_GET['id'];
$user_result = $connection->query("
SELECT uFName,
    uLName,
    citizenship,
    phone_number,
    email,
    username,
    password,
    isSuspended,
    suspendDate,
    userType
FROM User
WHERE userID=$uid;
");

include_once 'header.php';
?>

    <section class="signup-form">
        <p>Edit a user</p>
        <form action="includes/editUser_inc.php" method="post">
            <div class="signup-form-style">
                <input type="hidden" name="uid" value="<?=$uid?>"/>
                <div>
                    <label for="uFName">First name:</label>
                    <input type="text" name="uFName" id="uFName" value=<?=$user_result['uFName']?>/>
                </div>
                <div>
                    <label for="uLName">Last name:</label>
                    <input type="text" name="uLName" id="uLName" value=<?=$user_result['uLName']?>/>
                </div>
                <div>
                    <!-- @yang maybe make a <select> with <option> for the countries -->
                    <label for="citizenship">Citizenship</label>
                    <input type="text" name="citizenship" id="citizenship" value=<?=$user_result['citizenship']?>/>
                </div>
                <div>
                    <label for="phone_number">Phone number:</label>
                    <input type="phone" name="phone_number" id="phone_number" value=<?=$user_result['']?>/>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value=<?=$user_result['email']?>/>
                </div>
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" value=<?=$user_result['username']?>/>
                </div>
                <div>
                    <input type="hidden" name="password" id="password" value=<?=$user_result['password']?>/>
                </div>
                <div>
                    <!-- @yang how to make a checkbox? -->
                    <label for="isSuspended">Is suspended:</label>
                    <input type="text" name="isSuspended" id="isSuspended" value=<?=$user_result['isSuspended']?>/>
                </div>
                <div>
                    <!-- @yang how to make a date input? -->
                    <label for="suspendDate">Suspend Date:</label>
                    <input type="text" name="suspendDate" id="suspendDate" value=<?=$user_result['suspendDate']?>/>
                </div>
                <div>
                    <label for="userType">User type:</label>
                    <input type="text" name="userType" id="userType" value=<?=$user_result['userType']?>/>
                </div>

                <button type="sumbit" name="editUser">Edit</button>
            </div>
            </form>
            
        <br>
        <a href="cded_users.php">GO back</a>
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
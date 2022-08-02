<?php
if(!isset($_GET['id'])) {
  header('location: cded_users.php');
}

$uid = $_GET['id'];

$sql = "DELETE User WHERE userID=uid;";

    // @yang execute the DELETE query on the database
    // https://www.php.net/manual/en/book.mysqli.php
    // https://duckduckgo.com/?t=ffab&q=php+delete+mysqli

    // @yang maybe some confirmation prompt "do you really want to delete a user?"
header('location: cded_users.php');
?>

    <!-- <section class="signup-form">
        <p>Delete a user</p>
        <form action="includes/editUser_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="delUsername" placeholder="Enter the username"> <br>
                <input type="text" name="verifyDelUser" placeholder="Enter the username again to verify"> <br>
                <button type="sumbit" name="editUser">Delete</button>
            </div>
            
        </form>
        <br>
        <a href="cded_users.php">GO back</a>
    </section> -->
    

<?php
    include_once 'footer.php';
?>
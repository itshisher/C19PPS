<?php
    include_once 'header.php';
?>

    <section class="signup-form">
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
    </section>
    

<?php
    include_once 'footer.php';
?>
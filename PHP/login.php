<?php
    include_once 'header.php';
?>
    
    <section class="signup-form">
        <h2>Log in</h2>
        <form action="../includes/login_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="uid" placeholder="Username/Email..."> <br>
                <input type="password" name="password" placeholder="Password..."> <br>
                <button type="sumbit" name="submit">Log in</button>
            </div>
        </form>
    </section>

<?php
    include_once 'footer.php';
?>
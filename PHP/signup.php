<?php
    include_once 'header.php';
?>
    
    <section class="signup-form">
        <h2>Sign up</h2>
        <form action="../includes/signup_inc.php" method="post">
            <div class="signup-form-style">
                <input type="text" name="fName" placeholder="First name..."> <br>
                <input type="text" name="lName" placeholder="Last name..."> <br>
                <input type="text" name="citizenship" placeholder="Citizenship..."> <br>
                <input type="email" name="email" placeholder="Email address..."> <br>
                <input type="tel" name="phone" placeholder="Phone number..."> <br>
                <input type="text" name="uid" placeholder="Username..."> <br>
                <input type="password" name="password" placeholder="Password..."> <br>
                <input type="password" name="passwordRepeat" placeholder="Repeat your password..."> <br>
                <button type="sumbit" name="submit">Sign up</button>
            </div>
        </form>
    </section>

<?php
    include_once 'footer.php';
?>
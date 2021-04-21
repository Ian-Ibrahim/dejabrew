<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cinzel+Decorative&family=Hind+Madurai:wght@300&family=Monoton&family=Montez&family=Sansita:wght@700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b2d1a2836c.js" crossorigin="anonymous"></script>
    <title>Register</title>
</head>

<body class="body-content">

    <header class="header">
        <div class="logo logo-alt">
            <i class="fas fa-coffee"></i>
            Deja<span>-Brew</span>
        </div>
    </header>
    <main class="main-content">
        <h3>please register account with your details.</h3>
        <form class="register-form" id="registration" action="create.php" method="post">
            <div class=" inputs ">
                <label for="user-type" class="users"><i class="fas fa-users"></i>user Type:</label>
                <select id="user-type" class="users" name="user-type" form="registration" required>
                    <option value="client" class="user-choice">Client</option>
                    <option value="admin" class="user-choice">Admin</option>
                </select>
            </div>
            <div class="inputs">
                <i class="fas fa-user-alt"></i>
                <input type="text" class="login_input" id="first-name" required name="fName" placeholder="first name">
                <br>
            </div>
            <div class="inputs">
                <i class="fas fa-asterisk" style="color: transparent;"></i>
                <input type="text" class="login_input" id="last-name" required name="lName" placeholder="last name">
                <br>
            </div>

            <div class="inputs">
                <i class="fas fa-envelope"></i>
                <input type="email" class="login_input" id="email" name="mail" required placeholder="Your email"><br>

            </div>
            <div class="inputs">
                <i class="fas fa-mobile-alt"></i>
                <input type="tel" class="login_input" id="mobile-no" name="phone" required placeholder="mobile number">
            </div>
            <div class="inputs">
                <i class="fas fa-key"></i>
                <input type="password" class="login_input" name="passcode"id="password" required placeholder="enter password" onkeyup="check()" /><br>
            </div>
            <div class="inputs">
                <i class="fas fa-key"></i>
                <input type="password" class="login_input" required id="confirm_password" placeholder="re-enter password" onkeyup="check()" />
                <i id="icon"></i>
            </div>
            <span id="message"></span>
            <div class=" inputs ">
                <input type="submit" class="input-btns" id="submit-btn" name="register" value="Register">
            </div>
            <div class="inputs">
                <input type="reset" class="input-btns" id="reset-btn" value="Clear">
            </div>
        </form>
        <p>Already Have an account?<a href="login.php" title="register">Click here</a></p>
    </main>
</body>
<script>

function check() {
    if(document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
        document.getElementById('icon').className="fas fa-check-circle";
        document.getElementById('submit-btn').style.display = 'block';
        document.getElementById('message').innerHTML="";

    } else {
        document.getElementById('icon').className="fas fa-times-circle";
        document.getElementById('submit-btn').style.display = 'none';
        document.getElementById("message").innerHTML="passwords need to match!";
    }
}
</script>

</html>

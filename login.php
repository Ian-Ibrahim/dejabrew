<?php
session_start();
 ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cinzel+Decorative&family=Hind+Madurai:wght@300&family=Monoton&family=Montez&family=Sansita:wght@700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b2d1a2836c.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body class="body-content">
    <header class="header">
      <div class="logo">
          <i class="fas fa-coffee"></i>
          Deja<span>-Brew</span>
      </div>
    </header>

    <main class="main-content">
        <h2 class="headers">Please Log in to your account to continue </h2>
        <form class="login-form" method="post" id="loginform" >
          <h4>Logging in</h4>
            <div class="inputs">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" class="login_input" id="email" placeholder="Your email" required><br>

            </div>
            <div class="inputs">
                <i class="fa fa-key icon">
                </i>
                <input type="password" name="password" class="login_input" id="password" required placeholder="password"><br>
            </div>
            <div class="inputs">
                <input type="submit" class="input-btns" id="login-btn" name="submit-user" value="Log In">
            </div>

        </form>
        <?php
        require_once ("db_connect.php");

        if(isset($_POST["submit-user"])){
          $mail=$_POST["email"];
          $passcode=$_POST["password"];
          $sql="SELECT email,password,firstName,lastName,phoneNumber,userId,userType FROM users WHERE email='$mail' and password='$passcode' ";
          $result = $conn->query($sql);
          if ($result->num_rows == 1) {
            $_SESSION['login_user']=$mail;
            // retrive user name
            $row = $result->fetch_assoc();
            // store username in  a session by combining the two column values
            $user=$row['userType'];
            $_SESSION['user_type']=$user;
            $_SESSION['user_name']= $row['firstName']."&#160".$row['lastName'];
            $_SESSION['phone']=$row['phoneNumber'];

            if($user=="client"){
            header("Location:client_index.php");
            $_SESSION['user_Id']=$row['userId'];

            exit();
          }else{
            header("Location:admin_index.php");
            $_SESSION['admin_Id']=$row['userId'];
            exit();
          }
        }
      else{
          echo "<br /><div id='error' onshow='error()'>
          <p class='error-message id='error-message'>
          <i class='error-close fas fa-times' id='error-close' onclick='errorExit()'></i>
          <i class='error-emoji far fa-frown'></i> <br />
          <div>
          <span>ERROR!</span>
          </div>
          Your Username or password maybe wrong
          </p>
          </div>
          ";
        }
      }
        else {
          // echo "Unable to login user";
        }
         ?>
        <p>Do Not Have an account yet?<a href="register.php" title="login">Click here</a></p>
    </main>
</body >
<script>
function errorExit(){
  document.getElementById("error").style.display="none";
  document.getElementById("loginform").style.display="inline-block";
}
function error(){
  document.getElementById("loginform").style.display="none";
}

</script>
</html>

<?php
session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cinzel+Decorative&family=Hind+Madurai:wght@300&family=Monoton&family=Montez&family=Sansita:wght@700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b2d1a2836c.js" crossorigin="anonymous"></script>
    <title>Update users</title>
</head>
<header class="user-header main-header">
    <nav class="navigation-bar">


    </nav>
    <div class="header-item user-header-item">
        <p class="headline"> User &nbsp;Details</p>
        <p><a >Update Details</a></p>
    </div>
</header>
<body>


<?php

require_once("db_connect.php");

$id = $_GET['id'];

$qry = mysqli_query($conn,"select * from users where userid='$id'"); // select query
$data = mysqli_fetch_array($qry);

if(isset($_POST['update'])) // when click on Update button
{
  $firstName=$_POST["fName"];
  $lastName=$_POST["lName"];
  $email=$_POST["mail"];
  $password=$_POST["passcode"];
$user=$_POST["user-type"];
  $phoneNumber=$_POST["phone"];

    $edit = mysqli_query($conn,"update users set firstName='$firstName',lastName='$lastName',email='$email',password='$password',phoneNumber='$phoneNumber',userType='$user'  where userid='$id'");

    if($edit)
    {

      if($_SESSION['user_type']=="admin"){ // Close connection
        header("location:admin_index.php"); // redirects to all records page
        exit;
      }
      if($_SESSION['user_type']=="client"){
        header("location:client_index.php"); // redirects to all records page
        exit;
      }

    }
    else
    {
        echo mysqli_error();
    }
}

?>
<br />
<div class="dbaction">

<form class="register-form " id="update _user" method="post">

  <div class=" inputs ">
      <label for="user-type" class="users"><i class="fas fa-users"></i>user Type:</label>
      <select id="user-type" class="users" name="user-type" form="update _user" required>
        <?php if( $data['userType']=='client'){
          echo "<option value='client' class='user-choice'selected>Client</option>
          <option value='admin' class='user-choice' >Admin</option>
          ";
        } else{
          echo "<option value='admin' class='user-choice' selected>Admin</option>
          <option value='client' class='user-choice'  >Client</option>
          ";
        }
        ?>
      </select>
  </div>
    <div class="inputs">
        <i class="fas fa-user-alt"></i>
        <input type="text" id="first-name" value="<?php echo $data['firstName'] ?>"required name="fName" placeholder="first name">
        <br>
    </div>
    <div class="inputs">
        <i class="fas fa-asterisk" style="color: transparent;"></i>
        <input type="text" id="last-name" value="<?php echo $data['lastName'] ?>" required name="lName" placeholder="last name">
        <br>
    </div>

    <div class="inputs">
        <i class="fas fa-envelope"></i>
        <input type="email" id="email" value="<?php echo $data['email'] ?>" name="mail" required placeholder="Your email"><br>
    </div>
    <div class="inputs">
        <i class="fas fa-mobile-alt"></i>
        <input type="tel" id="mobile-no" name="phone" value="<?php echo $data['phoneNumber'] ?>" required placeholder="mobile number">
    </div>
    <div class="inputs">
        <i class="fas fa-key"></i>
        <input type="password" name="passcode"id="password" value="<?php echo $data['password'] ?>" required placeholder="enter password" onkeyup="check()" /><br>
    </div>
    <div class="inputs">
        <i class="fas fa-key"></i>
        <input type="password" required id="confirm_password" placeholder="re-enter password" onkeyup="check()" />
        <i id="icon"></i>
    </div>
    <span id="message"></span>
    <div class=" inputs ">
        <input type="submit" class="input-btns" id="submit-btn" name="update" value="Update">
    </div>
</form>
</div>

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

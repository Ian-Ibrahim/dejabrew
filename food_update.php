<?php session_start();require_once("db_connect.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Food Update</title>
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cinzel+Decorative&family=Hind+Madurai:wght@300&family=Monoton&family=Montez&family=Sansita:wght@700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b2d1a2836c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/phpstyles.css">
    <link rel="stylesheet" href="style/style.css">

</head>
<?php
if(!isset($_SESSION['admin_Id'])){
header("refresh:5;url=login.php");
?>
<div id="overlay" >
    <div id="text">
      <div class='dberror'>
      <div id="error">
      <p class="error-message" id="error-message">
      <i class='error-emoji far fa-frown'></i> <br />
      <div>
      <span>Opps!! You need to login first!</span>
      </div>
      Redirecting to login page ...
      </p>
      </div>
    </div>
  </div>
    <br />
</div>
<?php
  }
?>
<body class="body-content">
  <header class="admin-content sidebar">
        <nav class="navigation-bar">
            <div class="logo admin-logo">
                <i class="fas fa-coffee"></i>
                Deja<span>-Brew</span>
            </div>
            <div class='user_name'>
              <i class="fas fa-user-alt"></i>ADMIN<br />
            <?php echo $_SESSION['user_name'];?>
            <br />
            <form method="post" class="sign-out">
                <button type="submit" class="user-type" name="log-out" value="Log Out">Log out</button>
            </form>
            <?php
          if(isset($_POST['log-out'])){
            session_unset();
            session_destroy();
            header("Location:login.php");
            exit();
          }
           ?>
         <a class="admin-btn user-type" href="update.php?id=<?php echo $_SESSION['admin_Id'] ?>">Edit Details</a>
          </div>

        </nav>
        <div class="navigation">
            <a class="navitems active">Home </a><br />
            <a class="navitems" href="#food_form">Add food </a><br />
            <a class="navitems" href="#orders">Orders </a><br />
            <a class="navitems" href="#food_table">Food Table </a><br />
            <a class="navitems" href="#users-table">Users Table </a><br />
            <a class="navitems" href="#reports">reports </a><br />

        </div>
  </header>
  <main class="admin-content">
    <h3 class="headers">Update Food Info</h3>
    <form class="food_update_form" enctype="multipart/form-data"  id="food_update_form" method="post" >

    <?php
    $food_updateid = $_GET['updateid'];
    $sql = "SELECT * FROM food WHERE foodId='$food_updateid' ORDER BY foodId ASC ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

    ?>

    <label>Food Name</label>
    <input type="text" name="food_name" class="login_input" value="<?php echo $row["foodName"]?>"/><br />
    <label>Food Price</label>
    <input type="number" name="food_price" class="login_input" value="<?php echo $row["price"]?>"/><br />
    <label>Image</label><br />
    <input type="file" name="image" /><br />
    <input type="submit" name="update_food" class="input-btns" style="width:50%;" value="Update" />
</form>
    <?php
      if(isset($_POST['update_food'])){
        $foodName=$_POST['food_name'];
        $foodprice=$_POST['food_price'];

         $image = $_FILES['image']['name'];
         $target = "images/products/".basename($image);
        $edit = mysqli_query($conn,"update food set  foodName='$foodName',image='$image',price='$foodprice' where foodId='$food_updateid'");

        if($edit)
        {
          if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
               $msg = "Image uploaded successfully";
          }else{
               $msg = "Failed to upload image";
          }
          if($_SESSION['user_type']=="admin"){ // Close connection
            echo "<script>window.location.replace('admin_index.php')</script>";
            // redirects to all records page
            exit;
          }
        }
        else
        {
            echo mysqli_error();
        }
      }
    }
    }
    ?>

  </main>
</body>

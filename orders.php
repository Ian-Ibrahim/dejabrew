<?php session_start();require_once("db_connect.php"); ?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cinzel+Decorative&family=Hind+Madurai:wght@300&family=Monoton&family=Sansita:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b2d1a2836c.js" crossorigin="anonymous"></script>
    <title>Orders</title>
  </head>
  <header class="user-header main-header">
      <nav class="navigation-bar">
          <div class="logo">
              <i class="fas fa-coffee"></i>
              Deja<span>-Brew</span>
          </div>
          <div class="navigation">
              <a class="navitems active" href="index.html">Home </a>
              <a class="navitems " href="client_index.php">Shop </a>
              <div class=" dropdown" >
                <a class="navitems dropbtn profile" onclick="profile()" > Click to View Profile</a><wbr>
                <div class="dropdown-content user-details" id="drop-content">
                  <i class="far fa-times-circle profile-close" onclick="profileExit()"></i><br />
                  <label for="user-name">First Name</label><input disabled id="user-name" type="text" class="login_input" value='<?php echo $_SESSION['user_name'] ?>'/><br />
                  <label for="phone">phoneNumber</label><input disabled id="phone" class="login_input" value='<?php echo $_SESSION['phone'] ?>'/><br />
                  <label for="mail">Email address</label><input disabled id="mail" class="login_input" value='<?php echo $_SESSION['login_user'] ?>'/><br />
                  <a  href="update.php?id=<?php echo $_SESSION['user_Id'] ?>">Edit Details</a>
                </div>
              </div>

              <div class="cart-icon">
              <i class="fas fa-shopping-basket"></i>
              <span>
                <?php
                if(!empty($_SESSION["cart"])){
              $count=count($_SESSION["cart"]);
               echo $count;}else{echo "0";}
               ?></span>
              </div>
              <form method="post" class="sign-out">
              <input type="submit" class="user-type" name="log-out" value="Log Out"></input>
              </form>
              <?php
              if(isset($_POST['log-out'])){
                session_unset();
                session_destroy();
                header("Location:login.php");
                exit();
              }
               ?>
          </div>
          <?php
          echo "<div class='user_name'>Welcome:" ,$_SESSION['user_name'],"</div>";
           ?>
      </nav>
      <div class="header-item user-header-item">
          <p class="headline"> Client &nbsp;Orders</p>
          <p><a href="client_index.php">  Shop-</a>orders</p>
      </div>
  </header>
  <body>
       <h3 class="headers">Your  completed orders</h3>
       <?php
       $order_no=1;
       $total_products=0;
       $id=$_SESSION['user_Id'];
       $order_sql="SELECT * FROM orders WHERE userId='$id' AND status='completed' ";
       $order_result = $conn->query($order_sql);
       $income=0;
       if ($order_result->num_rows > 0) {
         // output data of each row
         while($order_row = $order_result->fetch_assoc()) {
           $order=$order_row["orderId"];
           $cart_sql="SELECT * FROM cart_items WHERE orderId='$order' ";
           $cart_result = $conn->query($cart_sql);
           ?>
           <div class="order-item" style="display:inline-block;">
             <p class="order-title"><strong>Order</strong><?php echo $order_no; ?></p>
             <p class="order-title"><strong>Order Id:</strong><?php echo $order;?></p>
             <p class="order-title">  <strong>Date:</strong><?php echo $order_row["date/time"]; ?> </p><br />
             <div class="cart-items">
               <?php

                while($cart_row = $cart_result->fetch_assoc()){
                 echo $cart_row["productId"];
                 $total_products=$cart_row["quantity"]+$total_products;

                 $product=$cart_row["productId"];
                 $food_sql="SELECT foodName FROM food WHERE foodId='$product' ";
                 $food_result=$conn->query($food_sql);
                 $food_row = $food_result->fetch_assoc();
                 echo $food_row["foodName"],$cart_row["quantity"],"<br />";
                }
               ?>
               <div class="order-total">  Grand Total:
                 <?php
               echo $order_row["grandTotal"];
               $income=$income+ $order_row["grandTotal"];
               ?>

                </div>
             </div>
           </div>
             <?php
             $order_no=$order_no+1;
           }
         }else{
           echo "No completed orders";
         }
       ?>
       <h3 class="headers">Your pending orders</h3>
       <?php
       $order_no=1;
       $total_products=0;
       $id=$_SESSION['user_Id'];
       $order_sql="SELECT * FROM orders WHERE userId='$id' AND status='pending' ";
       $order_result = $conn->query($order_sql);
       $income=0;
       if ($order_result->num_rows > 0) {
         // output data of each row
         while($order_row = $order_result->fetch_assoc()) {
           $order=$order_row["orderId"];
           $cart_sql="SELECT * FROM cart_items WHERE orderId='$order' ";
           $cart_result = $conn->query($cart_sql);
           ?>
           <div class="order-item" style="display:inline-block;">
             <p class="order-title"><strong>Order</strong><?php echo $order_no; ?></p>
             <p class="order-title"><strong>Order Id:</strong><?php echo $order;?></p>
             <p class="order-title">  <strong>Date:</strong><?php echo $order_row["date/time"]; ?> </p><br />
             <div class="cart-items">
               <?php

                while($cart_row = $cart_result->fetch_assoc()){
                 echo $cart_row["productId"];
                 $total_products=$cart_row["quantity"]+$total_products;

                 $product=$cart_row["productId"];
                 $food_sql="SELECT foodName FROM food WHERE foodId='$product' ";
                 $food_result=$conn->query($food_sql);
                 $food_row = $food_result->fetch_assoc();
                 echo $food_row["foodName"],$cart_row["quantity"],"<br />";
                }
               ?>
               <div class="order-total">  Grand Total:
                 <?php
               echo $order_row["grandTotal"];
               $income=$income+ $order_row["grandTotal"];
               ?>

                </div>
             </div>
           </div>
             <?php
             $order_no=$order_no+1;
           }
         }
       ?>

  </body>
  <footer class="footer-content">
    <p style="text-align:center;">
      Opening hours from 7:00am - 7:30pm daily.
    </p>

     <div class="footer-item newsletter">
       <div class="logo">
           <i class="fas fa-coffee"></i>
           Deja<span>-Brew</span>
       </div>
       <p>
         <i class="fas fa-map-marked-alt"></i>
         Address:<a href="https://g.page/TheGalleriaShoppingMall-Kenya?share">Galleria Mall,Langata Mall</a><br />
         <a href="https://g.page/RosslynRivieraMall?share">Rosslyn Riviera Mall,Limuru Road</a>
       </p>

     </div>
     <div class="footer-item quick-links">
       <div class="payment-methods">
         <h4 class="">Let's Get social</h4>
         <a href="tel:+254758170781" class="social fas fa-phone"></a>
         <a class="social fas fa-envelope" href="mailto: ianokova@gmail.com"></a>
         <a class="social fab fa-tripadvisor" href="#"></a>
         <a class=" social fab fa-facebook-f" href="#"></a>
         <a class="social fab fa-instagram" href="#"></a>
         <a class="social fab fa-twitter" href="#"></a>
          <br />
           <h4 >Accepted payment methods</h4>
           <img src="https://www.flaticon.com/svg/static/icons/svg/1570/1570954.svg" title="Payment on delivery" alt="cash payments" class="payment">
           <img src="https://www.flaticon.com/svg/static/icons/svg/39/39134.svg" alt="visa" title="visa" class="payment">
           <img src="https://www.flaticon.com/svg/static/icons/svg/39/39031.svg" alt="mastercard" title="mastercard" class="payment">

       </div>
     </div>

   </footer>
   <p>
     Ian Okova 	&#169;&nbsp;<?php echo( date(" Y")); ?>
   </p>
</html>

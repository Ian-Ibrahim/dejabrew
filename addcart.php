<?php
session_start();
require_once("db_connect.php");
 ?>
 <html>

 <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="style/style.css">
     <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cinzel+Decorative&family=Hind+Madurai:wght@300&family=Monoton&family=Sansita:wght@700&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&display=swap" rel="stylesheet">
     <link href="style/confirm.css" rel="stylesheet" />
     <link rel="stylesheet" href="style/cart.css" />
     <script src="https://kit.fontawesome.com/b2d1a2836c.js" crossorigin="anonymous"></script>
     <title>shopping cart</title>
 </head>
 <body class="body-content">
   <!-- form to update quanity -->
   <form method="post" id="overlay" style="background:rgb(0,0,0,.5);">

     <div id="text" class="update_form">
       <a href="shopping-cart.php"><i class="fas fa-times" style="float:right;"></i></a><br />
     <label for="new">Enter New quantity</label>
     <br />
     <input type="number" class="login_input" id="new" name="new" required min="0"/>
     <br />
     <input type="submit" class="submit-btn " style="border: 1px solid #14242E;" name="add" />
     </div>
   </form>

   <header class="user-header main-header">
       <nav class="navigation-bar">
           <div class="logo">
               <i class="fas fa-coffee"></i>
               Deja<span>-Brew</span>
           </div>
           <div class="navigation">
               <a class="navitems active">Home </a>

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
               <i class="fas fa-shopping-basket"></i>
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
           <p class="headline"> Deja-Brew &nbsp;Shop</p>
           <p><a>Home-</a>checkout</p>
       </div>
   </header>
   <h3 >shopping cart</h3>
   <hr />

   <div class="cart">
     <form method="post">
     <button type="submit" name="empty_cart" class="user-type" style="float:right;"><i class="fas fa-trash-alt"></i>Empty cart </button><br /><br /><br />
   </form>
     <?php
     if(isset($_POST["empty_cart"])){
       foreach($_SESSION["cart"] as $keys=>$values){
           unset($_SESSION["cart"][$keys]);
       }
     }
     ?>
     <div class="cart-content">

      <table>
        <tr>
          <th style="border-right:0px;">Item Name</th>
          <th style="border-left:0px;">          </th>
          <th>Quantity</th>
          <th>price</th>
          <th>total</th>
          <th>action</th>
        </tr>
        <?php
        $grand_total=0;
        if(!empty($_SESSION["cart"])){
          $total=0;
          foreach($_SESSION["cart"] as $keys=>$values){
            ?>
            <tr>
              <?php
              $item=$values["item_id"];
              $sql = "SELECT foodName,foodId,image FROM food WHERE foodId=$item  ";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                echo "<td style='border-right:0px;'> <img class=' shopping_image'  src='images/products/".$row['image']."'></td> ";
                echo "<td style='border-left:0px;'>".$row["foodName"]."</td>";
              }
              } else {
                 echo "no results";
               }
              ?>
              <td>
                <?php echo $values["item_quantity"];?>
                <a href="addcart.php?id=<?php echo $values["item_id"]; ?>"> <i class="fas fa-trash-alt"></i>&#9; </a>
             </td><td>
                <?php   echo $values["item_price"];?>
              </td><td>
                <?php
                $product_total=$values["item_price"]* $values["item_quantity"];
                 echo $product_total;
                $grand_total=$grand_total+ $product_total;
                ?>
              </td><td>
                <a href="shopping-cart.php?action=delete&id=<?php echo $values["item_id"]?>">Remove</a>

                <br />
                <br />

              </td>
            </tr>
            <?php
          }
        }
        if(isset($_GET["action"])){
          if(isset($_GET["action"])=="delete"){
            foreach($_SESSION["cart"] as $keys=>$values){
              if($values["item_id"] == $_GET["id"]){
                unset($_SESSION["cart"][$keys]);
                echo "<script>window.location='shopping-cart.php'</script>";
              }
            }
          }
        }
         ?>
      </table>
           </div>
           <div class="cart-content">
             <form method="post">
               <h3>Grand Total:</h3>
               Ksh.<input class="grand_total" value="<?php echo $grand_total;?>" name="grand_total"/><br /><br />
               <button class="user-type cart-buttons" name="checkout" type="submit">
                 <i class="fas fa-clipboard-check"></i>Proceed to checkout
               </button>
             </form>


             <?php
             // insert into orders table
             $t=time();
             $cart_id=  $_SESSION['user_Id'].$t;

             if(isset($_POST["checkout"])){
               if(!empty($_SESSION["cart"])){
               $grand_total=$_POST["grand_total"];
               $user=$_SESSION['user_Id'];
               $sql="INSERT INTO orders(grandTotal,userId,cartId) VALUES('$grand_total','$user','$cart_id')";
               if(mysqli_query($conn,$sql)){
                 // echo "\r\n Record added successfully to user table";
               }
               else{
                 echo "\r\n Record not inserted ".mysqli_error($conn);
              }
              // select order Id
              $sql_order="SELECT orderId FROM orders WHERE cartId='$cart_id' ";
              $result = $conn->query($sql_order);
              if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                $order=$row["orderId"];
                }
              }
              // add to cart items

                $total=0;
                foreach($_SESSION["cart"] as $keys=>$values){
                  $product_total=$values["item_price"]* $values["item_quantity"];
                  $id=$values["item_id"];
                  $quantity=$values["item_quantity"];
                   $cart_items="INSERT INTO cart_items(productId,orderId,quantity,totalPrice) VALUES ('$id','$order','$quantity','$product_total')";
                   if(mysqli_query($conn,$cart_items)){
                     // echo "\r\n Record added successfully to user table";
                   }
                   else{
                     echo "\r\n Record not inserted ".mysqli_error($conn);
                  }
                      unset($_SESSION["cart"][$keys]);
                  ?>
                  <div id="overlay">
                    Thank You your order has been received
                    <h1>Cooking in progress..</h1>
       <div id="cooking">
           <div class="bubble"></div>
           <div class="bubble"></div>
           <div class="bubble"></div>
           <div class="bubble"></div>
           <div class="bubble"></div>
           <div id="area">
               <div id="sides">
                   <div id="pan"></div>
                   <div id="handle"></div>
               </div>
               <div id="pancake">
                   <div id="pastry"></div>
               </div>
           </div>
       </div>
                    <img src="https://www.flaticon.com/svg/static/icons/svg/3496/3496155.svg"/>
                  </div>
                  <?php
                }
              }else{
                echo "<script>alert('please add items to cart first')</script>cart has no items!!";
              }

             }

              ?>
           </div>
  </div>

</body>
 </html>

<?php
if(isset($_POST['add'])){
  foreach($_SESSION["cart"] as &$value){
      if($value['item_id'] === $_GET["id"]){
          $value['item_quantity'] = $_POST["new"];
          break; // Stop the loop after we've found the item

      }
  }
  echo "<script>window.location.replace('shopping-cart.php');</script>";
}
 ?>

  <?php
  session_start();
  require_once("db_connect.php");
  ?><html>
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="style/style.css">
      <link href="https://fonts.googleapis.com/css2?family=Actor&family=Cinzel+Decorative&family=Hind+Madurai:wght@300&family=Monoton&family=Sansita:wght@700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Cedarville+Cursive&display=swap" rel="stylesheet">
      <script src="https://kit.fontawesome.com/b2d1a2836c.js" crossorigin="anonymous"></script>
      <title>SHOP</title>
  </head>
  <?php
  if(!isset($_SESSION['user_Id'])){
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
  <body class=" body-content">
    <header class="user-header main-header">
        <nav class="navigation-bar">
            <div class="logo">
                <i class="fas fa-coffee"></i>
                Deja<span>-Brew</span>
            </div>
            <div class="navigation">
                <a class="navitems active" href="index.html">Home </a>
                <a class="navitems" href="orders.php">Orders</a>
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
                  <a href="shopping-cart.php">
                <i class="fas fa-shopping-basket"></i></a>
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
            echo "<div class='user_name'>Welcome " ,$_SESSION['user_name'],"</div>";
             ?>
        </nav>
        <div class="header-item user-header-item">
            <p class="headline"> Deja-Brew &nbsp;Shop</p>
            <p><a href="index.html">Home-</a>shop</p>

                <a class="header-btn order" href="shopping-cart.php">Proceed to Checkout</a><br>
        </div>
    </header>

  <main>

    <h3 class="headers">Products</h3>
    <form method="post" class="filter">
      <br />
      <input type="submit" class="user-type filter-item" value="all" name="all">
      <input type="submit" class="user-type filter-item" value="coffee" name="coffee">
      <input type="submit" class="user-type filter-item" value="tea" name="tea">
      <input type="submit" class="user-type filter-item" value="smoothies" name="smoothies">
      <input type="submit" class="user-type filter-item" value="juice" name="juice">
      <input type="submit" class="user-type filter-item" value="cake" name="cake">
      <input type="submit" class="user-type filter-item" value="milkshake" name="milkshake">
      <input type="submit" class="user-type filter-item" value="lemonade" name="lemonade">
      <input type="submit" class="user-type filter-item" value="pastry" name="pastry">
    </form>

    <?php
    require_once("db_connect.php");
    $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food";
    if(isset($_POST['all'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food  ";
      echo "<div class='products-type headers'>All products<br /></div>";
    }
    if(isset($_POST['lemonade'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='lemonade' ";
      echo "<div class='products-type headers'>Lemonade<br /></div>";
    }
    if(isset($_POST['milkshake'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='milkshake' ";
      echo "<div class='products-type headers'>Milkshake<br /></div>";
    }
    if(isset($_POST['pastry'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='pastry' ";
      echo "<div class='products-type headers'>Bread and pastry<br /></div>";
    }
    if(isset($_POST['cake'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='cake' ";
      echo "<div class='products-type headers'>Cakes<br /></div>";
    }
    if(isset($_POST['juice'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='juice' ";
      echo "<div class='products-type headers'>Juice<br /></div>";
    }
    if(isset($_POST['smoothies'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='smoothie' ";
      echo "<div class='products-type headers'>Smoothies<br /></div>";
    }
    if(isset($_POST['tea'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='tea' ";
      echo "<div class='products-type headers'>tea<br /></div>";
    }
    if(isset($_POST['coffee'])){
      $product_sql="SELECT foodName,price,foodType,badge,foodId,image FROM food WHERE foodType='coffee' ";
      echo "<div class='products-type headers'>Coffee<br /></div>";
    }
    $product_result=$conn->query($product_sql);
    $product_numbers=$product_result->num_rows;
    echo "<p style='margin-left:50px;'> ",$product_numbers,"Product(s)</p>";
    if ($product_result->num_rows > 0) {
    while($row = $product_result->fetch_assoc()) {
      $product_class= $row['foodType'];
      $foodId=$row['foodId'];
      $foodPrice=$row['price'];;
      $foodname=$row['foodName'];
      echo "
      <div id='$product_class' style='display:inline-block;'>

        <div class='product-card '>
            <img class='product-img' src='images/products/".$row['image']."'>
            <div class='badge'>",$row['badge'],"</div>
            <div class='product-content'>
                <p class='menu-desc'>",$row['foodName'],"<br><span class='price'>Ksh.",$row['price'],"</span>
                  <span class='offer'></span>
                </p>
            </div>
            <form method='post' action='client_index.php?action=add&id=$foodId'>
              <input type='number'id='quantity' class='quantity' name='quantity' controls='no' value='1'/>
              <input type='hidden' name='foodId' value=$foodId />
              <input type='hidden' name='hidden_price' value=$foodPrice />
              <input type='hidden' name='hidden_name' value=$foodname />
              <br />
              <button type='submit' name='add_to_cart' class='user-type cart-add'><i class='fas fa-cart-plus'></i><span>Add To cart</span> </button>
            </form>
        </div>
      </div>
      ";

    }
    if(isset($_POST['add_to_cart'])){
      if(isset($_SESSION["cart"])){
        $item_array_id= array_column($_SESSION["cart"],"item_id");
        if(!in_array($_GET["id"],$item_array_id)){
          $count=count($_SESSION["cart"]);
          $item_array= array(
            'item_id'=> $_POST["foodId"],
            'item_name'=> $_POST["hidden_name"],
            'item_price'=>$_POST["hidden_price"],
            'item_quantity'=> $_POST["quantity"]
          );
          $_SESSION["cart"][$count]=$item_array;
          echo "<script>window.location='client_index.php'</script>";
        }else{
          echo "<script>alert('item added')</script>";
        }
      }else{
        $item_array = array(
          'item_id'=> $_POST["foodId"],
          'item_name'=> $_POST["hidden_name"],
          'item_price'=>$_POST["hidden_price"],
          'item_quantity'=> $_POST["quantity"]
         );
         $_SESSION["cart"][0]=$item_array;
         echo "<script>alert('item added')</script>";
      }
    }

  }else {
    echo"<br />
    <div class='dberror'>
    <div id='error'>
    <p class='error-message id='error-message'>
    <i class='error-close fas fa-times' id='error-close-admin' ></i>
    <i class='error-emoji far fa-frown'></i> <br />
    <div>
    <span>Opps No product found!</span>
    </div>
    Your Username or password maybe wrong
    </p>
    </div>
      </div>
    ";
  }
     ?>

  </main>
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
   </body>
  <script>
  function profile(){
    document.getElementById('drop-content').style.display="block";
  }
  function profileExit(){
    document.getElementById('drop-content').style.display="none";
  }
  </script>
  </html>

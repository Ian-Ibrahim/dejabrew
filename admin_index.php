<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
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
                <button type="submit" class="admin-btn user-type"  style="color: #FC6E20;  border-color: #FC6E20;   background-color: transparent;" name="log-out" value="Log Out">Log out</button>
            </form>
            <?php
          if(isset($_POST['log-out'])){
            session_unset();
            session_destroy();
            header("Location:login.php");
            exit();
          }
           ?>
         <a class="admin-btn user-type"  style="color: #FC6E20;  border-color: #FC6E20;   background-color: transparent;"  href="update.php?id=<?php echo $_SESSION['admin_Id'] ?>">Edit Details</a>
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
    <div id="food_form">
          <h3 class="headers">Add food to database</h3>
          <form method="post"  enctype="multipart/form-data" id="food">
                <input type="hidden" name="size" value="1000000"/><br />
                <div class="inputs">
                  <input type="text" name="foodName" required placeholder="food Name"/><br />
                </div>
                <div class="inputs">
                <input type="number" name="price" min="1" placeholder="price" required/><br />
              </div>
              <div class="inputs">
                <label for="foodtype" class="food"></i>Food Type:</label>
                <select id="foodtype" class="food" name="food-type" form="food" required>
                    <option value="coffee" class="food-choice">Coffee</option>
                    <option value="tea" class="food-choice">Tea</option>
                    <option value="smoothie" class="food-choice">smoothie</option>
                    <option value="juice" class="food-choice">Juice</option>
                    <option value="pastry" class="food-choice">pastry</option>
                    <option value="Cake" class="food-choice">Cake</option>
                    <option value="milkshake" class="food-choice">Milk Shake</option>
                    <option value="lemonade" class="food-choice">Lemonade</option>
                </select>
              </div>
              <div class="inputs">
                <label for="badge-select" class="food-badge">Badge:</label>
                <select id="badge-select" class="badge-select" name="badge_info" form="food" required>
                  <option value=" " class="badge-choice" selected>None</option>
                    <option value="18+" class="badge-choice">+18</option>
                    <option value="per slice" class="badge-choice">per slice</option>
                    <option value="2 pieces" class="badge-choice">2 Pieces</option>
                    <option value="4 pack" class="badge-choice">4 pack</option>
                    <option value="6 pack" class="badge-choice">6 pack</option>
                    <option value="dozen" class="badge-choice">dozen</option>
                </select>
              </div>
              <div class="inputs">
                <input type="file" name="image" required/><br />
              </div>
              <div class="inputs">
                <input type="submit"class="user-type" name="upload" value="Add Item"/>
              </div>
          </form>
          <?php
            require_once ("db_connect.php");
             if (isset($_POST['upload'])) {
                 $image = $_FILES['image']['name'];
                 $food_name=$_POST['foodName'];
                 $price=$_POST['price'];
                 $food_type=$_POST['food-type'];
                 $badge_info=$_POST["badge_info"];
                 $target = "images/products/".basename($image);
                 $sql = "INSERT INTO food (foodName,price,foodType,badge,image) VALUES ('$food_name','$price','$food_type','$badge_info','$image')";
                 if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                  		$msg = "Image uploaded successfully";
        	       }else{
        		          $msg = "Failed to upload image";
        	       }
                 if(mysqli_query($conn,$sql)){
                 // echo "\r\n Record added successfully to user table";
                 }
                else{
                 echo "\r\n Record not inserted ".mysqli_error($conn);
                }
             }
           ?>
        </div>
    <div id="food_table">
      <h3 class="headers">Food Table</h3>
      <table>
        <tr>
          <th>  food Id </th>
          <th style="border-right:0px;">Food Name</th>
          <th style="border-left:0px;">          </th>
          <th>  food Price </th>
          <th>  food Type </th>
          <th>  Badge </th>
        </tr>

          <?php
            $sql = "SELECT * FROM food ORDER BY foodId ASC ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              ?>
              <tr>
              <td><?php echo $row["foodId"]?>      </td>
              <td style="border-right:0px;"><?php echo $row["foodName"]?>      </td>
              <td style="border-left:0px;">     <?php echo "<img class=' shopping_image'  src='images/products/".$row['image']."'>" ?>   </td>
              <td><?php echo $row["price"]?>      </td>
              <td><?php echo $row["foodType"]?>      </td>
              <td><?php echo $row["badge"]?>      </td>
              <td><a href="food_delete.php?id=<?php echo $row['foodId']; ?>&value2=<?php echo $row['image']; ?> "><i class="fas fa-trash-alt"></i> </td>
              <td > <a href="food_update.php?updateid=<?php echo $row['foodId']; ?>"><span onclick="update_form()">Update</span</a> </td>

              </tr>
              <?php
            }
          }else {
            echo "No food in the database";
          }
           ?>

      </table>
    </div>
    <div id="users-table">
      <h4 class="headers">Users Table</h4>
      <table class="pagination" data-pagecount="3">
            <tr>
              <th>User Id</th>
              <th>Name</th>
              <th>email</th>
              <th>phone Number</th>
              <th>User Type</th>
             </tr>
              <?php
                require_once("db_connect.php");
                // get page number
                if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                    $page_no = $_GET['page_no'];
                    } else {
                        $page_no = 1;
                        }
                  // set number of records
                  $total_records_per_page = 5;

                $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `users`");
                $total_records = mysqli_fetch_array($result_count);
                $total_records = $total_records['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);

                $second_last = $total_no_of_pages - 1;
                $offset = ($page_no-1) * $total_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;

                $sql = "SELECT userid, firstName, email,phoneNumber,lastName,userType FROM users ORDER BY userType DESC LIMIT $offset, $total_records_per_page";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {

                echo "<tr><td>" . $row["userid"]. "</td><td>" . $row["firstName"]. "\r\n". $row["lastName"]. "</td><td>"
                . $row["email"]."</td><td>".$row["phoneNumber"]. "</td><td>".$row["userType"]."</td>";

                ?>
                <td><a href="update.php?id=<?php echo $row['userid']; ?>"><i class="fas fa-user-edit"></i>&#9;Edit</a></td>
                <td><a href="delete.php?id=<?php echo $row['userid']; ?>"><i class="fas fa-trash-alt"></i>&#9; </a></td>
                <?php
                echo"</tr>";
                }
                } else {
                   echo "no results";
                 }
              ?>
        </table>
      <div style="text-align:justify;">
        <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
      </div>
      <ul class="pagination">
            <?php if($page_no > 1){
            echo "<li><a href='?page_no=1'>First Page</a></li>";
            } ?>
            <li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
            <a <?php if($page_no > 1){
            echo "href='?page_no=$previous_page'";
            } ?>>Previous</a>
            </li>
            <li <?php if($page_no >= $total_no_of_pages){
            echo "class='disabled'";
            } ?>>
            <a <?php if($page_no < $total_no_of_pages) {
            echo "href='?page_no=$next_page'";
            } ?>>Next</a>
            </li>
            <?php
            if($page_no < $total_no_of_pages){
            echo "<li><a href='?page_no=$total_no_of_pages'>Last </a></li>";
            }
            echo "<br />";
            $counter=1;
            while($total_no_of_pages>=$counter){
              echo "<li class='page-Number'> <a href='?page_no=$counter'>",$counter,"</a>   </li>";
              $counter=$counter+1;
            }
            ?>
      </ul>
    </div>
    <div id="orders">
      <h3 class="headers">Orders </h3>
      <?php
      $order_no=1;
      $order_sql="SELECT * FROM orders ORDER BY 'date/time' ASC ";
      $order_result = $conn->query($order_sql);

      if ($order_result->num_rows > 0) {
        // output data of each row
        while($order_row = $order_result->fetch_assoc()) {
          $order=$order_row["orderId"];
          $order_user=$order_row["userId"];
          $cart_sql="SELECT * FROM cart_items WHERE orderId='$order'   ";
          $cart_result = $conn->query($cart_sql);
          // retrive order details
          $order_names="SELECT * FROM users WHERE userId='$order_user' ";
          $order_user_details=$conn->query($order_names);
          while($order_name_row = $order_user_details->fetch_assoc()){

          ?>
          <div class="order-item">
            <p class="order-title"><strong>Order</strong><?php echo $order_no; ?></p>
            <p class="order-title"><strong>Order Id:</strong><?php echo $order;?></p>
            <p class="order-title">  <strong>Date:</strong><?php echo $order_row["date/time"]; ?> </p><br />
            <p class="order-title"><strong>Name:</strong> <?php echo $order_name_row["firstName"],"  ", $order_name_row["lastName"] ; ?> </p>
            <p class="order-title"> <strong>Email:</strong><?php echo $order_name_row["email"]?></p>
            <p class="order-title"> <strong>Phone:</strong><?php echo "0", $order_name_row["phoneNumber"]?></p><br />
            <div class="cart-items">

              <?php
            }
               while($cart_row = $cart_result->fetch_assoc()){
                 $product=$cart_row["productId"];
                 $food_sql="SELECT foodName FROM food WHERE foodId='$product' ";
                 $food_result=$conn->query($food_sql);
                 while($food_row = $food_result->fetch_assoc()){
                 ?>
                 <t able class="cart-items">
                     <td> <?php echo $food_row["foodName"];?>
                     <?php echo "(",$cart_row["quantity"],")";?>  </td>
                     <td> <?php echo $cart_row["totalPrice"];?>  </td><br />
                  </table>
                 <?php
               }
               }
              ?>
              <div class="order-total">
                  Total:
                <?php
              echo $order_row["grandTotal"];

              ?>

            </div><br />
               <a class="user-type" href="admin_index.php?order_id=<?php echo $order_row["orderId"]; ?>" >Confrim Order</a><br /><br />
            </div>
          </div>
            <?php
            if(isset($_GET['order_id'])){
            $order_updateid = $_GET['order_id'];
            $edit = mysqli_query($conn,"update orders set  status='completed' where orderId='$order_updateid'");
            echo '<script>window.location.replace("admin_index.php#orders");</script>';
            if($edit)
            {

            }
            else
            {
                echo mysqli_error();
            }
          }
            $order_no=$order_no+1;
          }
        }else
        {
          echo "No Orders";
        }
      ?>

    </div>
    <div id="reports">
      <h4 class="headers"><img src="https://www.flaticon.com/svg/static/icons/svg/1188/1188576.svg" alt="report" class="report-img"/><br />Reports</h4>
      <div class="report-card">
        <div class="report-content">
          <b>Number of users</b>
          <p style="padding-left:40%;font-size:25px;"> <?php echo $result->num_rows;  ?></p>
          <button>here</button>
          <br />
          <br />
          <br />
       </div>
       <div class="triangle"></div>
      </div>
      <div class="report-card">
        <div class="report-content">
          <b>Administrators</b>
          <p style="padding-left:40%;">
            <?php
            $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `users` WHERE userType='admin' ");
            $total_records = mysqli_fetch_array($result_count);
            $total_records = $total_records['total_records'];
            echo $total_records;
             ?>
           </p>
          <button>here</button>
          <br />
          <br />
          <br />
       </div>
       <div class="triangle"></div>
      </div>
      <div class="report-card">
        <div class="report-content">
          <b>Clients</b>
          <p style="padding-left:40%;"><?php
          $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `users` WHERE userType='client' ");
          $total_records = mysqli_fetch_array($result_count);
          $total_records = $total_records['total_records'];
          echo $total_records; ?>
        </p>
          <button>here</button>
          <br />
          <br />
          <br />
       </div>
       <div class="triangle"></div>
      </div>
      <div class="report-card">
        <div class="report-content">
          <b>Total Products</b>
          <p style="padding-left:40%;"><?php
          $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `food` ");
          $total_records = mysqli_fetch_array($result_count);
          $total_records = $total_records['total_records'];
          echo $total_records; ?>
        </p>
          <button>here</button>
          <br />
          <br />
          <br />
       </div>
       <div class="triangle"></div>
      </div>
      <div class="report-card">
        <div class="report-content">
          <b>Pending Orders</b>
          <p style="padding-left:40%;"><?php
          $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `orders` WHERE status='pending' ");
          $total_records = mysqli_fetch_array($result_count);
          $total_records = $total_records['total_records'];
          echo $total_records; ?>
        </p>
          <button>here</button>
          <br />
          <br />
          <br />
       </div>
       <div class="triangle"></div>
      </div>
      <div class="report-card">
        <div class="report-content">
          <b>Completed Orders</b>
          <p style="padding-left:40%;"><?php
          $result_count = mysqli_query($conn,"SELECT COUNT(*) As total_records FROM `orders` WHERE status='completed' ");
          $total_records = mysqli_fetch_array($result_count);
          $total_records = $total_records['total_records'];
          echo $total_records; ?>
        </p>
          <button>here</button>
          <br />
          <br />
          <br />
       </div>
       <div class="triangle"></div>
      </div>



    </div>
  </main>

</body>
<script>


function update_form(){
document.getElementById('food_update_form').style.display="block";
}
function profile(){
  document.getElementById('drop-content').style.display="block";
}
function profileExit(){
  document.getElementById('drop-content').style.display="none";
}
</script>
</html>

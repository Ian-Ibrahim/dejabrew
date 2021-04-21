<?php
        require_once ("connection.php");
       if(isset($_POST["submit"])){
        $name=$_POST["uname"];
          $passcode=$_POST["psw"];
           $sql="SELECT Username,Password, FROM users WHERE Username='$name' and Password='$passcode' ";
           $result = $conn->query($sql)
               if ($result->num_rows > 0) 
               {
                   $_SESSION['user_name']= $row['Username'];
                     echo "<script>alert('login successful')</script>";
              }
               else{
                 echo"<script>alert('username or password is incorrect');</script>";
           
              }


       }
      
?>

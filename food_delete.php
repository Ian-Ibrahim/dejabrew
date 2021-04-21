<?php
    require_once ("db_connect.php");
    $id = $_GET['id'];
    $img=$_GET['value2'];
      $del = mysqli_query($conn,"DELETE FROM food where foodId = '$id'");
      if($del)
      {
          mysqli_close($conn);
          header("location:admin_index.php#food_table");
          exit;
      }
      else
      {
          echo "Error deleting record";
      }
?>

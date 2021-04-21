<?php

  require_once ("db_connect.php");
  $id = $_GET['id'];

  $del = mysqli_query($conn,"DELETE FROM users where userid = '$id'");

  if($del)
  {
      mysqli_close($conn);
      header("location:admin_index.php#users-table");
      exit;
  }
  else
  {
      echo "Error deleting record";
  }
?>

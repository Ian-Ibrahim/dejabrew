<?php
require_once("db_connect.php");
if(isset($_POST["register"])){
    $firstName=$_POST["fName"];
    $lastName=$_POST["lName"];
    $email=$_POST["mail"];
    $password=$_POST["passcode"];
    $phoneNumber=$_POST["phone"];
    $user=$_POST["user-type"];

    $sql="INSERT INTO users(firstName,lastName,email,password,phoneNumber,userType) VALUES('$firstName','$lastName','$email','$password','$phoneNumber','$user')";
    $adminsql="INSERT INTO administrator(firstName,lastName,email,password,phoneNumber) VALUES('$firstName','$lastName','$email','$password','$phoneNumber')";

    if(mysqli_query($conn,$sql)){
    // echo "\r\n Record added successfully to user table";
    header("refresh:0;url=login.php");
    }
  else{
    echo "\r\n Record not inserted ".mysqli_error($conn);
  }

}
?>

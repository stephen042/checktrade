<?php
$conn = mysqli_connect("localhost","root","","provqfsu_forex","3308");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to Database: " . mysqli_connect_error();
  }
?>
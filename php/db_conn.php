<?php

if(!defined('acc'))
{
   header("Location: ../notfound.html");
   exit();
}

$servername = "localhost";
$username = "gpetenaz";
$password = "aeZoofei1vei3yoh";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");
mysqli_select_db ($conn, "gpetenaz");

?>

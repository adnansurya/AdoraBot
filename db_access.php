<?php

$servername = "localhost";
$username = "id13879968_adnanmikro";
$password = "Makassar-1995";
$dbname = "id13879968_betaku";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    // echo "<script>console.log('DB connected!' );</script>";
}

?>
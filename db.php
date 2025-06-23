<?php
$servername = "sql209.infinityfree.com";
$username = "if0_39157168";
$password = "niYiDFoMUZadj0";
$dbname = "if0_39157168_moekazi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

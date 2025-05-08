<?php

$server = "Localhost";
$username = "root";
$password_db = "password";
$database = "test";

// Create a connection
$connection = mysqli_connect($server, $username, $password_db, $database);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} 
?>

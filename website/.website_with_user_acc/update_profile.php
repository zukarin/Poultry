<?php
session_start();
include('../db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../login,signup/login_signup.php");
    exit();
}

$user_email = $_SESSION['user_email'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    // Get the form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $shipping_address = $_POST["shipping_address"];
    $phone_number = $_POST["phone_number"];
    $birthdate = $_POST["birthdate"];
    $gender = $_POST["gender"];

    // Update user information in the database
    $update_query = "UPDATE `users` SET username = ?, adress = ?, email = ?, phone_number = ?, birthdate = ?, gender = ? WHERE email = ?";
    $stmt = mysqli_prepare($connection, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssss", $username, $shipping_address, $email, $phone_number, $birthdate, $gender, $user_email);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Profile updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating profile: " . mysqli_error($connection) . "');</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

//

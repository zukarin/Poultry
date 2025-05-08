<?php
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form1-submit'])) {
    // Retrieve form data
    $username = $_POST['user'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute a query to insert user data into the database
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    try {
        $result = mysqli_query($connection, $query);

        // Check if the query was successful
        if ($result) {
            echo "<script>alert('Signup successful!');</script>";
        } else {
            throw new Exception(mysqli_error($connection));
        }
    } catch (Exception $e) {
        if ($e->getCode() == 1062) {
            echo "<script>alert('Email is already taken.');</script>";
        } else {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

// Close the database connection
mysqli_close($connection);
?>

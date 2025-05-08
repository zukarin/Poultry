<?php
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form2-submit'])) {
    // Retrieve data
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check the email and password in the database
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Check if there is a user with the provided email
        if (mysqli_num_rows($result) > 0) {
            // Sign-in successful
            echo "<script>alert('Sign-in successful!');</script>";
        } else {
            // No user found with the provided email or incorrect password
            echo "<script>alert('Incorrect email or password.');</script>";
        }
    } else {
        echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
    }
}

// Close the database connection
mysqli_close($connection);
?>

<?php
// Include the database connection and other necessary files
include('../db_connection.php');
include('../functions/other_function.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form2-submit'])) {
    // Retrieve data and sanitize inputs
    $email = mysqli_real_escape_string($connection, $_POST['email'] ?? '');
    $password = mysqli_real_escape_string($connection, $_POST['password'] ?? '');

    // Retrieve the username along with email and password
    $query = "SELECT username, email, password FROM users WHERE email=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        // Check if there is a user with the provided email
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            $retrieved_username = $row['username'];

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Start the session
                session_start();

                // Store both email and username in the session
                $_SESSION['user_email'] = $email;
                $_SESSION['username'] = $retrieved_username;

                // Redirect to home_user.php or any other page
                header("Location:../.website_with_user_acc/home_with_user.php");
                exit(); // Ensure that no further code is executed after the redirect
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('No user found with the provided email.');</script>";
        }
    } else {
        error_log(mysqli_error($connection));
        echo "<script>alert('An error occurred while processing your request. Please try again later.');</script>";
    }
}

mysqli_close($connection); // Close the database connection at the end of the script
?>

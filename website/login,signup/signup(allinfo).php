<?php
include('../db_connection.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form1-submit"])) {
    // Get the form data
    $username = $_POST["user"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $shipping_address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $birthday = $_POST["birthday"];
    $gender = $_POST["gender"];

    // Validate the form data (you can add more validation as needed)
    if ($password !== $confirm_password) {
        echo "<script>alert('Error: Passwords do not match');</script>";
    } else {
        // Check if the email already exists in the database
        $check_query = "SELECT * FROM `users` WHERE email = ?";
        $check_stmt = mysqli_prepare($connection, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            echo "<script>alert('Error: Email is already taken');</script>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into the database
            $insert_query = "INSERT INTO `users` (username, adress, email, password, phone_number, birthdate, gender) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connection, $insert_query);

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $username, $shipping_address, $email, $hashed_password, $phone_number, $birthday, $gender);

            // Execute the query
            $result = mysqli_stmt_execute($stmt);

            // Check if the insertion was successful
            if ($result) {
                echo "<script>
                alert('Registration successful');
                window.location.href = 'login_signup.php'; 
                    </script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }

        // Close the check statement
        mysqli_stmt_close($check_stmt);
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./signup(allinfo).css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Fill up more</title>
</head>
<body>
    <div class="big-card">
        <h2 class="form__title">Sign Up</h2>
        <form id="form1" method="post" action="">
            <div class="cards-container">
                    <div class="card">
                        <input type="text" name="user" placeholder="User" class="input" required />
                        <input type="email" name="email" placeholder="Email" class="input" required />
                        <input type="password" name="password" id="password" placeholder="Password" class="input" required />
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="input" required />
                    </div>

                    <div class="card">
                        <!-- Corrected name attribute to match the PHP code -->
                        <input type="text" name="address" placeholder="Shipping Address" class="input" required />
                        <input type="tel" name="phone_number" placeholder="Phone Number" class="input" required />
                        <label for="gender">Birth date:</label>
                        <input type="date" name="birthday" class="input" required />
                        <label for="gender">Gender:</label>
                        <select name="gender" id="gender" class="input" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>  
                            <option value="other">Other</option>
                        </select>
                    </div>

            </div>
            <button class="btn" type="submit" name="form1-submit">Sign Up</button>
        </form>
    </div>
</body>
</html>

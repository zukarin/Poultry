<?php
include('../db_connection.php');

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query the database for the admin with the given username and password
    $query = "SELECT * FROM test.admin WHERE name='$username' AND password='$password'";
    $result = mysqli_query($connection, $query);

    // Check if the query returned any rows
    if (mysqli_num_rows($result) > 0) {
        // Redirect to the other site if the login is successful
        header("Location: ./admin.php");
        exit();
    } else {
        // Display an error message if the login is unsuccessful
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url("./product_images/poultry.png");
    background-size: cover;
    background-position: center;
        }

        .container {
            text-align: center;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;    
        }

        .link {
            color: var(--gray);
            font-size: 0.9rem;
            margin: 1.5rem 0;
            text-decoration: none;
            text-align: center;
        }

        input[type="submit"]:hover {
            background-color:rgb(136, 103, 50);
        }
    </style>
    
</head>
<body>
    <div class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="card">
            <h1 class="header">ADMIN LOGIN</h1>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <input type="submit" value="Log in">
            <a href="./signup.php" class="link">Or signup</a>
        </form>
    </div>
</body>
</html>

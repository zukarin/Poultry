<?php
$server = "localhost";
$username = "root";
$password = "password";
$database = "test";

// Create a connection
$connection = mysqli_connect($server, $username, $password, $database);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'product_id' is set in the GET parameters
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // SQL query to retrieve product details based on 'product_id'
    $selectQuery = "SELECT * FROM products WHERE product_id = '$productId'";
    $resultQuery = mysqli_query($connection, $selectQuery);

    if ($resultQuery && mysqli_num_rows($resultQuery) > 0) {
        // Fetch product details as an associative array
        $product = mysqli_fetch_assoc($resultQuery);

        // Return product details as JSON
        echo json_encode($product);
    } else {
        // Return an error message if the product is not found
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    // Return an error message if 'product_id' is not provided
    echo json_encode(['error' => 'Product ID not provided']);
}

// Close the database connection
mysqli_close($connection);
?>

<?php
include('../db_connection.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    // Use $product_id to query the database and retrieve product details
    $select_query = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result_query = mysqli_query($connection, $select_query);

    if ($row_data = mysqli_fetch_assoc($result_query)) {
        // Send product details as JSON response
        echo json_encode($row_data);
    } else {
        // Handle the case when the product is not found
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    // Handle the case when product_id is not set
    echo json_encode(['error' => 'Product ID not provided']);
}
?>

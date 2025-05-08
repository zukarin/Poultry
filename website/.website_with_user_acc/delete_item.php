<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        // Assuming $_SESSION['cart'] is an array containing items
        // You might need to adjust this based on your actual cart structure
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            // Optionally, you can add a message or perform other actions after deletion
        }
    }
}

// Redirect back to the cart or any other page
header("Location: viewcart.php"); // Adjust the URL as needed
exit();
?>

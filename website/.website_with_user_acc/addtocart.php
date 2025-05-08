<?php
session_start();

// Initialize cart as an empty array if it's not set or set to null
if (!isset($_SESSION['cart']) || $_SESSION['cart'] === null) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the item with the given ID is already in the cart
    if (!isset($_SESSION['cart'][$id])) {
        // If not, add it to the cart
        $_SESSION['cart'][$id] = array('quantity' => 1); // You can include more details about the product in this array if needed

       
        echo '<script>alert("Item successfully added to the cart!"); window.history.back();</script>';
    } else {
        // If already in the cart, increase the quantity
        $_SESSION['cart'][$id]['quantity']++;

        
        echo '<script>alert("Item quantity increased in the cart!"); window.history.back();</script>';
    }

    // Display the contents of the cart (for testing purposes)
    // echo '<pre>';
    // print_r($_SESSION['cart']);
    // echo '</pre>';
}
?>

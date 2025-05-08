<?php
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve order_id and new order_status from the form
    $order_id = $_POST['order_id'];
    $new_status = $_POST['order_status'];

    // Update the order status in the database
    $update_status_query = "UPDATE orders SET order_status = ? WHERE order_id = ?";
    $stmt = mysqli_prepare($connection, $update_status_query);
    mysqli_stmt_bind_param($stmt, "si", $new_status, $order_id);
    
    if (mysqli_stmt_execute($stmt)) {
        // Order status updated successfully
        echo "<script>
                alert('Order status updated successfully.');
                window.location.href = 'admin_orders.php';
              </script>";
    } else {
        // Error updating order status
        echo "Error updating order status: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($connection);
?>

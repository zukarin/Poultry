<?php
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'], $_POST['cancelable_status'])) {
    $order_id = $_POST['order_id'];
    $cancelable_status = $_POST['cancelable_status'];

    // Check if the order is not cancellable
    if ($cancelable_status == 0) {
        // Update the order status to "Packing"
        $update_order_status_query = "UPDATE orders SET order_status = 'Packing' WHERE order_id = ?";
        $stmt_update_order_status = mysqli_prepare($connection, $update_order_status_query);
        mysqli_stmt_bind_param($stmt_update_order_status, "i", $order_id);
        mysqli_stmt_execute($stmt_update_order_status);
        mysqli_stmt_close($stmt_update_order_status);
    }

    // Update the cancellable status
    $update_cancelable_query = "UPDATE orders SET cancelable = ? WHERE order_id = ?";
    $stmt_update_cancelable = mysqli_prepare($connection, $update_cancelable_query);
    mysqli_stmt_bind_param($stmt_update_cancelable, "ii", $cancelable_status, $order_id);
    mysqli_stmt_execute($stmt_update_cancelable);
    mysqli_stmt_close($stmt_update_cancelable);

    // Close the database connection
    mysqli_close($connection);

    // Alert and redirect
    echo "<script>alert('Cancellable status updated successfully.');</script>";
    header("Location: admin_orders.php");
    exit();
} else {
    // Redirect to the appropriate page if accessed without proper parameters
    header("Location: admin_orders.php");
    exit();
}
?>

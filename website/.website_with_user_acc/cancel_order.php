<?php
// Include your database connection file
include('../db_connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../login,signup/login_signup.php");
    exit();
}

$user_email = $_SESSION['user_email'];

// Handle order cancellation if order_id is provided
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Check if the order is cancelable
    $check_cancelable_query = "SELECT cancelable FROM orders WHERE order_id = ?";
    $stmt_cancelable = mysqli_prepare($connection, $check_cancelable_query);

    if (!$stmt_cancelable) {
        die("Error in prepare: " . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt_cancelable, "i", $order_id);
    mysqli_stmt_execute($stmt_cancelable);
    $result_cancelable = mysqli_stmt_get_result($stmt_cancelable);

    // Check if result is not null before accessing 'cancelable'
    if ($result_cancelable && $cancelable = mysqli_fetch_assoc($result_cancelable)) {
        $cancelable_status = $cancelable['cancelable'];

        if ($cancelable_status == 0) {
            // Order is not cancelable
            echo "<script>alert('This order cannot be canceled as it has already been packed or delivered.');</script>";
        } else {
            // Delete the order
            $delete_order_query = "DELETE FROM orders WHERE order_id = ?";
            $stmt_delete_order = mysqli_prepare($connection, $delete_order_query);

            if (!$stmt_delete_order) {
                die("Error in prepare: " . mysqli_error($connection));
            }

            mysqli_stmt_bind_param($stmt_delete_order, "i", $order_id);
            mysqli_stmt_execute($stmt_delete_order);

            echo "<script>alert('Order canceled successfully.'); window.location.reload();</script>";

            // Close the statement
            mysqli_stmt_close($stmt_delete_order);
        }
    } else {
        // echo "<script>alert('Error fetching cancelable status.');</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt_cancelable);
}

// Fetch order history for the logged-in user with product details
$select_orders_query = "SELECT orders.*, products.product_title, products.product_image1
                        FROM orders
                        INNER JOIN products ON orders.product_id = products.product_id
                        WHERE user_email = ?";
$stmt_orders = mysqli_prepare($connection, $select_orders_query);
mysqli_stmt_bind_param($stmt_orders, "s", $user_email);
mysqli_stmt_execute($stmt_orders);
$result_orders = mysqli_stmt_get_result($stmt_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="./home_with_user.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./shop_user.css">
    
    <title>Order History</title>
    <!-- Add your CSS styles or use an external stylesheet -->
    <style>
        /* Add your table styling here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .cancel-btn {
            cursor: pointer;
            color: red;
            text-decoration: underline;
        }

        .product-img {
            max-width: 50px;
            max-height: 50px;
        }
    </style>
</head>
<body>

<section id="header">
<?php

if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];
    $username = $_SESSION['username'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: ../login,signup/login_signup.php");
    exit();
}
$cart = $_SESSION['cart']; 
    $totalQuantity = 0;

    foreach ($cart as $item) {
        $totalQuantity += $item['quantity'];
    }


    
?>

<!-- sa taas ng web(navigator-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="../flower/1.html">Furniture Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./home_with_user.php">Home</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./home_shop_user.php">Shop</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./about_.php">About</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./contact.php">Contact</a>
                </li>
                <li class="nav-item mx-4">
                
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fa-solid fa-user" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">  Welcome,  <?php echo $username; ?></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="profile.php">Account information</a></li>
                        <!-- <li><a class="dropdown-item" href="./viewcart.php"> Cart <i class="fa-solid fa-cart-shopping"><sup><sup><?php echo $totalQuantity ?></sup></sup></i>  </a></li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../login,signup/login_signup.php" target="_self">Logout</a></li>
                    </ul>
                </li>

                <div class='text-right ml-5'>
                    <li class="nav-item dropdown">
                        <div class="dropdowns">
                            <button type="button" class="btn btn-info" data-toggle="dropdown">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger"><?php echo $totalQuantity ?></span>
                            </button>
                            <div class="dropdown-menu">
                                <?php
                                $totalQuantity = 0;
                                $totalCartPrice = 0;

                                foreach ($cart as $key => $cartItem):
                                    $select_products = "SELECT products.*, brands.brand_title 
                                        FROM products 
                                        LEFT JOIN brands ON products.brand_id = brands.brand_id 
                                        WHERE product_id = $key";
                                    $result = mysqli_query($connection, $select_products);
                                    $row = mysqli_fetch_assoc($result);

                                    $totalPrice = $row['product_price'] * $cartItem['quantity'];
                                    $totalQuantity += $cartItem['quantity'];
                                    $totalCartPrice += $totalPrice;
                                ?>

                                <div class="row cart-detail">
                                    <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                        <img width='50' src="../admin/product_images/<?php echo $row['product_image1']; ?>" alt="Product Image">
                                    </div>
                                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                        <p><?php echo $row['product_title'] . ' (' . $row['brand_title'] . ')' ?></p>
                                        <span class="price text-info">₱ <?php echo number_format($row['product_price']); ?></span> <span class="count"> Quantity: <?php echo $cartItem['quantity']; ?></span>
                                    </div>
                                </div>

                                <?php endforeach;?>
                                
                                <div class="row total-header-section">
                                    <div class="col-lg-6 col-sm-6 col-6">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger"><?php echo $totalQuantity ?></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                        <p>Total: <span class="text-info">₱ <?php echo number_format($totalCartPrice, 2); ?></span></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                    <button class="btn btn-primary btn-block" onclick="window.location.href='checkout.php'">Checkout</button>
                                        <a href="./viewcart.php" class="btn btn-primary btn-block">Cart</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </li>
                </div> 
            </ul>
        </div>
    </div>
</nav>


</section> 

<h2>Your Order History</h2>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Product Title</th>
            <th>Product Image</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Order Status</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop through each order and display the details in the table
        while ($order = mysqli_fetch_assoc($result_orders)) {
            echo "<tr>";
            echo "<td>{$order['order_id']}</td>";
            echo "<td>{$order['product_title']}</td>";
            echo "<td><img class='product-img' src='../admin/product_images/{$order['product_image1']}' alt='Product Image'></td>";
            echo "<td>{$order['quantity']}</td>";
            echo "<td>{$order['total_price']}</td>";
            echo "<td>{$order['payment_method']}</td>";
            echo "<td>{$order['order_status']}</td>";
            echo "<td>{$order['order_date']}</td>";
            echo "<td>";
            echo "<span class='cancel-btn' onclick='cancelOrder({$order['order_id']})'>Cancel Order</span>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<script>
    function cancelOrder(orderId) {
        var confirmCancel = confirm("Are you sure you want to cancel this order?");
        if (confirmCancel) {
            // Redirect to the same page for handling the order cancellation
            window.location.href = 'order_history.php?order_id=' + orderId;
        }
    }
</script>

</body>
</html>

<?php
// Close the statement and database connection
mysqli_stmt_close($stmt_orders);
mysqli_close($connection);
?>

<?php
include('../db_connection.php');

// Fetch unique emails for the dropdown
$email_query = "SELECT DISTINCT email FROM users";
$email_result = mysqli_query($connection, $email_query);
$emails = mysqli_fetch_all($email_result, MYSQLI_ASSOC);

// Fetch unique payment methods for the dropdown
$payment_method_query = "SELECT DISTINCT payment_method FROM orders";
$payment_method_result = mysqli_query($connection, $payment_method_query);
$payment_methods = mysqli_fetch_all($payment_method_result, MYSQLI_ASSOC);

// Fetch unique order statuses for the dropdown
$order_status_query = "SELECT DISTINCT order_status FROM orders";
$order_status_result = mysqli_query($connection, $order_status_query);
$order_statuses = mysqli_fetch_all($order_status_result, MYSQLI_ASSOC);

// Fetch all orders with user information
$select_orders_query = "SELECT orders.*, users.username, users.email, products.product_title
                        FROM orders
                        INNER JOIN users ON orders.user_email = users.email
                        INNER JOIN products ON orders.product_id = products.product_id";

// Define filter variables
$filter_email = $_GET['email'] ?? '';
$filter_payment_method = $_GET['payment_method'] ?? '';
$filter_order_status = $_GET['order_status'] ?? '';

// Apply filters
if (!empty($filter_email)) {
    $select_orders_query .= " WHERE users.email = '$filter_email'";
}

if (!empty($filter_payment_method)) {
    $select_orders_query .= (empty($filter_email) ? ' WHERE' : ' AND') . " orders.payment_method = '$filter_payment_method'";
}

if (!empty($filter_order_status)) {
    $select_orders_query .= (empty($filter_email) && empty($filter_payment_method) ? ' WHERE' : ' AND') . " orders.order_status = '$filter_order_status'";
}

$result_orders = mysqli_query($connection, $select_orders_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
 
    <title>Admin - Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        th, td {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        button {
            padding: 5px 10px;
            cursor: pointer;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            margin-right: 10px;
        }
    </style>
</head>
<body>


<section id="header">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand fw-bold" href="admin.php">Administrator</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
              <li class="nav-item mx-5">
                <a class="nav-link active" aria-current="page" href="./admin_orders.php"> Orders </a>
              </li>
              <!-- <li class="nav-item mx-5">
                <a class="nav-link active" aria-current="page" href="../homepage/homepage.php"> Payments </a>
              </li> -->
              <li class="nav-item mx-5">
                <a class="nav-link active" aria-current="page" href="admin.php?users=true"> Users </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Product </a>
                <ul class="dropdown-menu" aria-labelledby="productDropdown">
                  <li><a class="dropdown-item" href="admin.php?insert_product=true">Insert Product</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="admin.php?view_product=true">View Product</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Categories </a>
                <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                  <li><a class="dropdown-item" href="admin.php?insert_category=true">Insert Categories</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="admin.php?view_categories=true">View Categories</a></li>    
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="brandsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Brands </a>
                <ul class="dropdown-menu" aria-labelledby="brandsDropdown">
                  <li><a class="dropdown-item" href="admin.php?insert_brand=true">Insert Brands</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="admin.php?view_brands=true">View Brands</a></li>
                </ul>
              </li>
              <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Account </a>
                <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                  <li><a class="dropdown-item" href="foodingredients.html">Login</a></li>
                  <li><a class="dropdown-item" href="foodsteps.html">Signup</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="../login,signup/login_signup.php" target="_self">Login/Signup</a></li>
                </ul>
              </li> -->
              <li class="nav-item mx-5">
                <a class="fa-solid fa-user fa-lg" style="color: #fafaf9" aria-current="page" href="login.php">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </section>
    
<!-- Add a form for filtering -->
<h2>Admin - Orders</h2>
<form method="get" action="admin_orders.php">
    <label for="email">Filter by Email:</label>
    <select name="email" id="email">
        <option value="">All Emails</option>
        <?php foreach ($emails as $emailOption) : ?>
            <option value="<?= $emailOption['email'] ?>" <?= ($filter_email == $emailOption['email']) ? 'selected' : '' ?>>
                <?= $emailOption['email'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="payment_method">Filter by Payment Method:</label>
    <select name="payment_method" id="payment_method">
        <option value="">All Payment Methods</option>
        <?php foreach ($payment_methods as $paymentMethodOption) : ?>
            <option value="<?= $paymentMethodOption['payment_method'] ?>" <?= ($filter_payment_method == $paymentMethodOption['payment_method']) ? 'selected' : '' ?>>
                <?= $paymentMethodOption['payment_method'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="order_status">Filter by Order Status:</label>
    <select name="order_status" id="order_status">
        <option value="">All Order Statuses</option>
        <?php foreach ($order_statuses as $orderStatusOption) : ?>
            <option value="<?= $orderStatusOption['order_status'] ?>" <?= ($filter_order_status == $orderStatusOption['order_status']) ? 'selected' : '' ?>>
                <?= $orderStatusOption['order_status'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Apply Filters</button>
</form>

<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Email</th>
            <th>Product Title</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Payment Method</th>
            <th>Order Status</th>
            <th>Order Date</th>
            <th>Cancelable</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop through each order and display the details in the table
while ($order = mysqli_fetch_assoc($result_orders)) {
    echo "<tr>";
    echo "<td>{$order['order_id']}</td>";
    echo "<td>{$order['username']}</td>";
    echo "<td>{$order['email']}</td>";  // Include the email column
    echo "<td>{$order['product_title']}</td>";
    echo "<td>{$order['quantity']}</td>";
    echo "<td>{$order['total_price']}</td>";
    echo "<td>{$order['payment_method']}</td>";
    echo "<td>{$order['order_status']}</td>";
    echo "<td>{$order['order_date']}</td>";
    echo "<td>{$order['cancelable']}</td>";
    echo "<td>";
    // Add a form with a dropdown to change cancelable status
    echo "<form method='post' action='update_cancelable.php'>";
    echo "<input type='hidden' name='order_id' value='{$order['order_id']}'>";
    echo "<select name='cancelable_status'>";
    echo "<option value='1' " . ($order['cancelable'] == 1 ? 'selected' : '') . ">Yes</option>";
    echo "<option value='0' " . ($order['cancelable'] == 0 ? 'selected' : '') . ">No</option>";
    echo "</select>";
    echo "<button type='submit'>Update</button>";
    echo "</form>";

    // Add a button to change order status with JavaScript confirmation
    echo "<form method='post' action='update_status.php' onsubmit='return confirm(\"Are you sure it's delivered?\")'>";
    echo "<input type='hidden' name='order_id' value='{$order['order_id']}'>";
    echo "<input type='hidden' name='order_status' value='Delivered'>";
    echo "<button type='submit'>Delivered?</button>";
    echo "</form>";

    echo "</td>";
    echo "</tr>";
}

        ?>
    </tbody>
</table>



</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>

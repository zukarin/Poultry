<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="./admin.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
      <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>admin</title>
  </head>

  <body>		
<style>.welcome-message {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Full height */
    width: 100%; /* Full width */
    background-image: url("product_images/poultry.png");
    background-size: cover; /* Ensures the image covers the whole section */
    background-repeat: no-repeat;
    background-position: center center;
    color: white; /* Makes the text legible against the background */
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5); /* Add slight shadow to text for better visibility */
    padding: 20px;
    margin: 0; /* Removes unnecessary margins */
    box-sizing: border-box;
}

.welcome-message h1 {
  color: burlywood; /* Text color */
    background-color: rgba(0, 0, 0, 0.5); /* Transparent white background (50% opacity) */
    padding: 15px 30px; /* Add some padding to create the text box effect */
    display: inline-block; /* Make the background only cover the text */
    border-radius: 8px; /* Optional: adds rounded corners */
    font-weight: 800;
    font-size: 2rem;
    text-shadow: 0.5px 0.5px 5px rgba(0, 0, 0, 0.7); /* Shadow for readability */
    margin-top: 5px; /* Reduced margin to bring text closer */
    margin-bottom: 20px; /* Reduced margin to bring text closer */
    text-align: left;
  }


.welcome-message p {
    font-size: 1.2rem;
    line-height: 1.8;
    max-width: 800px;
    text-align: center;
}

</style>

    <section id="header">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo $_SERVER['PHP_SELF']; ?>">
  <i class="fa-solid fa-dove me-2" style="color: #f8f9fa;"></i> 
  Administrator
</a>
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
              <li class="nav-item dropdown mx-5">
                <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Product </a>
                <ul class="dropdown-menu" aria-labelledby="productDropdown">
                  <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?insert_product=true'; ?>">Insert Product</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?view_product=true'; ?>">View Product</a></li>
                </ul>
              </li>
              <li class="nav-item dropdown mx-5">
                <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Categories </a>
                <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                  <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?insert_category=true'; ?>">Insert Categories</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?view_categories=true'; ?>">View Categories</a></li>    
                </ul>
              </li>
              <li class="nav-item dropdown mx-5">
                <a class="nav-link dropdown-toggle" href="#" id="brandsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Breeds </a>
                <ul class="dropdown-menu" aria-labelledby="brandsDropdown">
                  <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?insert_brand=true'; ?>">Insert Breeds</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?view_brands=true'; ?>">View Breeds</a></li>
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
              <a class="nav-link d-flex align-items-center" href="login.php">
  <i class="fa-solid fa-user fa-lg me-2" style="color: #fafaf9;"></i>
  <span style="color: #fafaf9;">Logout</span>
</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </section>
<!-- Welcome Message -->
<div class="welcome-message">
    <h1>Welcome to the Poultry Admin Dashboard</h1>
    <p>
        Here you can efficiently oversee and manage all aspects of your poultry operations, 
        including orders, users, product inventory, categories, and more. Simplify your workflow 
        and ensure smooth management for a thriving poultry business.
    </p>
</div>

    <div class="container my-5">
      <?php 
        if (isset($_GET['insert_category'])){
          include ('./insert_categories.php');
        }
        if (isset($_GET['view_categories'])) {
          include ('./view_categories.php');
      }
      

        if (isset($_GET['insert_brand'])){
          include ('./insert_brands.php');
        }
        if (isset($_GET['view_brands'])){ 
          include ('./view_brands.php');
        }

        if (isset($_GET['insert_product'])){
          include ('./insert_product.php');
        }
        if (isset($_GET['view_product'])){
          include ('./view_product.php');
        }
        if (isset($_GET['users'])){ 
          include ('./users.php');
        }
       

      ?>
    </div>

    <footer id="footer" class="section-p1">
      <div class="copyright">
        <p>©2024, Website Project(4h) - HTML CSS PHP JS Ecommerce</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

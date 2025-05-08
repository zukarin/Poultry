<?php
include('../db_connection.php');
include('../functions/common_function.php');

?>

<!doctype html>
<html lang="en">
  <head>
   <link rel="stylesheet" href="shop.css">
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
   
    <title>welcome to our poultry farm!</title>
  </head>

  <body>		

  <section id="header">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand fw-bold" href="../flower/1.html">
  <i class="fa-solid fa-dove"></i> Fowlfarm
</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav m-auto mb-2 mb-lg-0">
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../homepage/homepage.php">Home</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="#">Shop</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../about/about.html">About</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../homepage/faq/faq.html">FAQ</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../contact/contact.html">Contact</a>
    </li>
    
    <li class="nav-item dropdown custom-account-dropdown nav-item mx-5"> <!-- Changed to mx-7 -->
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Account
  </a>
  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    <li><a class="dropdown-item" href="../login,signup/login_signup.php" target="_self">Login/Signup</a></li>
  </ul>
</li>
  </ul>
</div>      
</nav>   
</section>

<!-- filter products(brands, categories) -->
<section id="filters" class="section-p1">
    <h2>Filter Products</h2> <br>
    <!-- Brands filter -->
    <div class="filter-option">
        <label for="brand">Brands:</label>
        <select id="brand" name="brand" >
            <option value="all">All Brands</option>
            <!-- PHP start -->
            <?php
            $select_brands = "SELECT * FROM brands"; // Removed the incorrect WHERE clause
            $result_brands = mysqli_query($connection, $select_brands);

            while ($row_data = mysqli_fetch_assoc($result_brands)) {
                $brand_title = $row_data["brand_title"];
                $brand_id = $row_data["brand_id"];
                $selected = ($brand_id == $selectedBrand) ? "selected" : "";
                echo "<option value='$brand_id' $selected>$brand_title</option>";
            }
            ?>  
            <!-- PHP end -->
        </select>
    </div>

    <!-- Categories filter -->
    <div class="filter-option">
        <label for="category">Category:</label>
        <select id="category" name="category">
            <option value="all">All Categories</option>
            <!-- PHP start -->
            <?php
            $select_categories = "SELECT * FROM categories";
            $result_categories = mysqli_query($connection, $select_categories);

            while ($row_data = mysqli_fetch_assoc($result_categories)) {
                $category_title = $row_data["category_title"];
                $category_id = $row_data["category_id"];
                $selected = ($category_id == $selectedCategory) ? "selected" : "";
                echo "<option value='$category_id' $selected>$category_title</option>";
            }
            ?>
            <!-- PHP end -->
        </select>
    </div>

    <!-- Apply Filters button -->
    <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>

    <!-- Reset Filters button -->
    <button class="btn btn-secondary" onclick="resetFilters()">Reset Filters</button>

    <script>
    function applyFilters() {
        var selectedBrand = document.getElementById("brand").value;
        var selectedCategory = document.getElementById("category").value;
        window.location.href = "./shop.php?brand=" + selectedBrand + "&category=" + selectedCategory;    
    }

    function resetFilters() {
        // Reset both brand and category to 'all'
        document.getElementById("brand").value   = "all";
        document.getElementById("category").value = "all";

        // Apply the reset immediately
        applyFilters();
    }
</script>
</section>




<!-- product(it is random unless filtered), This includes a function -->
  <section id="two" class="section-p1 fixed-section">
      <h2>New Arrive Products</h2>
      <div class="pro-container">
          <?php
          get_products();
          ?>
      </div>
  </section>
  <script>
      function openProductDetails(productId) {
          // Redirect to the product details page with the product_id
          window.location.href = `./shop.php?product_id=${productId}`;
      }

      // Function to open the lightbox
      function openLightbox() {
          document.getElementById('product-lightbox').style.display = 'flex';
      }

      // Function to close the lightbox
      function closeLightbox() {
          document.getElementById('product-lightbox').style.display = 'none';
      }

      // Check if the product_id is present in the URL and open the lightbox accordingly
      window.addEventListener('DOMContentLoaded', function () {
          const queryString = window.location.search;
          const urlParams = new URLSearchParams(queryString);
          const productId = urlParams.get('product_id');
          if (productId) {
              openLightbox();
          }
      });
  </script>

<?php
product_directory();
?>



<section id="two" class="section-p1 fixed-section">
      <h2>New Arrive Products</h2>
      <div class="pro-container">
          <?php
          getproductsss();
          ?>
      </div>
  </section>

  <script>
    function addToCart(productTitle) {
        // Check if the user is logged in (you can replace this condition with your actual check)
        var isLoggedIn = false;

        if (!isLoggedIn) {
            alert('You must log in first to add products to your cart.');
            // You can redirect to the login page or perform any other action
        } else {
            // User is logged in, perform the desired action (e.g., add to cart)
            alert('Product added to cart: ' + productTitle);
            // Add logic to handle adding the product to the cart
            // You may want to use AJAX to send the product data to the server
        }
    }
</script>


<!-- products without filter -->











<footer id="footer" class="section-p1">
      <div class="col">
        <h4>Contact</h4>
        <p><strong>Adress:</strong> Monteverde corner Bruno Gempesaw Street, Quezon City, Metro Manila</p>
        <p><strong>Phone:</strong> +93 977 446 464 646  </p>
        <p><strong>Hours:</strong> 9:00 - 18:00, MON - Sat </p>
        <div class="Follow">
          <div class="icon"><strong>Follow us</strong></div>
          <i class="fab fa-facebook"></i>
          <i class="fab fa-twitter"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-pinterest-p"></i>
          <i class="fab fa-youtube"></i>
        </div>
      </div>
      
      <div class="col">
        <h4>About</h4>
        <a href="../about/about.html">About us</a>
        <a href="#">Delivery Information</a>
        <a href="#">Privacy policy</a>
        <a href="#">Terms & condition</a>
        <a href="../contact/contact.html">Contact us</a>
      </div>
      
      <div class="col">
        <h4>My account</h4>
        <a href="../login,signup/login_signup.php">Sign In</a>
        <a href="#">View cart</a>
        
        <a href="#">Track My Order</a>
        <a href="#">Help</a>
      </div>
      
      <div class="col install">
        <h4>Install App</h4>
        <p>Download from Appstore</p>
          <img src="../pictures/play.jpg"> 
         <p> Secured Payment Gateway</p>
         <img class="qw" src="../pictures/pay.png">  
      </div>
      
      <div class="copyright">
      <p> ©2024, Website Activity(3h) - HTML CSS PHP JS Ecommerce</p>
      </div>
  </footer>

 
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="./shop.js"></script>
<!-- <script src="./lightbox-plus-jquery.js"></script> -->
 </body>
</html>
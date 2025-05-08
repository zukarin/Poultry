<?php

// Sa taas ng website or the navigator
function generateNavbar() {
    echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="../flower/1.html">Furniture Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-5">
                        <a class="nav-link active" aria-current="page" href="../homepage/homepage.php">Home</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link active" aria-current="page" href="../Shop/shop.php">Shop</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link active" aria-current="page" href="../about/about.html">About</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link active" aria-current="page" href="../contact/contact.html">Contact</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fa-solid fa-user " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="foodingredients.html">Account information</a></li>
                            <li><a class="dropdown-item" href="foodsteps.html"> Cart <i class="fa-solid fa-cart-shopping"><sup>1</sup></i>  </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../login,signup/login_signup.php" target="_self">Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-item mx-5">
                    <a class="nav-link active" aria-current="page" href="../homepage/homepage.php">Welcome, User</a>
                    </li>    
                </ul>
            </div>
        </div>
    </nav>';
}


function generateHeaderNavbar() {
    session_start();

    if (isset($_SESSION['user_email'])) {
        $user_email = $_SESSION['user_email'];
        $username = $_SESSION['username'];
    } else {
        // Redirect to the login page if the user is not logged in
        header("Location: ../login,signup/login_signup.php");
        exit();
    }
?>
    <section id="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="../flower/1.html">Furniture Shop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        <li class="nav-item mx-5">
                            <a class="nav-link active" aria-current="page" href="../homepage/homepage.php">Home</a>
                        </li>
                        <li class="nav-item mx-5">
                            <a class="nav-link active" aria-current="page" href="../Shop/shop.php">Shop</a>
                        </li>
                        <li class="nav-item mx-5">
                            <a class="nav-link active" aria-current="page" href="../about/about.html">About</a>
                        </li>
                        <li class="nav-item mx-5">
                            <a class="nav-link active" aria-current="page" href="../contact/contact.html">Contact</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fa-solid fa-user" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">  Welcome,  <?php echo $username; ?></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="foodingredients.html">Account information</a></li>
                                <li><a class="dropdown-item" href="foodsteps.html"> Cart <i class="fa-solid fa-cart-shopping"><sup>1</sup></i>  </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../login,signup/login_signup.php" target="_self">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>
<?php
}





?>

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Car Rentals</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
   <body>
    <!-- Header/Navbar -->
        <header>
            <div class="navbar">
                <div class="navdiv">
                    <div class="logo"><a href="index.php">RENTAL</a></div>
                    <ul class="nav_links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="rent.php">Rent Date</a></li>
                        <li><a href="collection.php">Cars</a></li>
                        <li><a href="payment.php">Payment</a></li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li><a href="auth/logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="auth/login.php">Login</a></li>
                            <li><a href="auth/signup.php">Signup</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </header>
    <main>
        <section class="hero-section">
            <div class="video-background">
                <video autoplay muted loop playsinline>
                    <source src="assets/car vid.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="video-overlay"></div>
            <div class="hero-content">
                <h1>Welcome to Our Car Rentals</h1>
                <h3>Get the best car rental deals on the web</h3>
                <div class="about">
                    <p>We offer a wide range of vehicles, including luxury cars, sports cars, and economy cars.</p>
                </div>
                <a href="collection.html"><button class="cta-btn">Explore Cars</button></a>
            </div>
        </section>
    </main>
    
    <section class="contact" id="contact">
        <h2>Contact Us</h2>
        <div class="contact-info">
            <p><a href="mailto:nelderrick1@gmail.com"><i class="ri-mail-line"></i> nelderrick1@gmail.com</a></p>
            <p><i class="ri-phone-line"></i> +233 532-863-801 or +1</p>
        </div>
    </section>

    <footer class="footer">
        <div class="footer__content">
            <div class="footer__section">
                <h3>About Us</h3>
                <p>We provide the best car rental services.</p>
            </div>
            <div class="footer__section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="collection.html">Cars</a></li>
                    <li><a href="plans.html">Plans</a></li>
                </ul>
            </div>
            <div class="footer__section">
                <h3>Follow Us</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com/facebook/"><i class="ri-facebook-fill">facebook</i></a>
                    <a href="https://www.instagram.com/"><i class="ri-instagram-fill">instagram</i></a>
                    <a href="https://twitter.com/"><i class="ri-twitter-fill"></i>Twitter</a>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <p>&copy; 2025 My Car Rentals. We offer all kinds of cars.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>
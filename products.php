<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Grid</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1 class="logo">TechWORLD</h1>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li> 
                    <li><a href="about.html">About</a></li> 
                    <li><a href="courses.html">Courses</a></li> 
                    <li><a href="Products.php">Products</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="register.html">Register</a></li> 
                    <li><a href="cart.html" class="cart-link" id="cart-icon">
                        <i class="fas fa-shopping-cart"></i> 
                        <span id="cart-count">0</span>
                    </a></li>
                </ul>
            </nav>
        </div>
    </header>

    <br>

    <section class="courses">
        <h1>Products</h1>
        <div class="product-grid"> 
            <?php
            include 'config.php';
            
            // First three products
            $sql = "SELECT * FROM products LIMIT 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p>€<?php echo number_format($row['price'], 2); ?></p>
                        <button onclick="addToCart('<?php echo htmlspecialchars($row['name']); ?>', 
                                                  <?php echo $row['price']; ?>)">
                            Add to Cart
                        </button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>

        <div class="product-grid">
            <?php
            // Next three products
            $sql = "SELECT * FROM products LIMIT 3 OFFSET 3";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" 
                             alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p>€<?php echo number_format($row['price'], 2); ?></p>
                        <button onclick="addToCart('<?php echo htmlspecialchars($row['name']); ?>', 
                                                  <?php echo $row['price']; ?>)">
                            Add to Cart
                        </button>
                    </div>
                    <?php
                }
            }
            $conn->close();
            ?>
        </div>

        <div class="load-more-container">
            <button class="load-more">Load More</button>
        </div>
    </section>

    <br>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <footer>
        <div class="footer-container">
            <div class="footer-section social-section">
                <h3>TechWORLD</h3>
                <p>Connect with us on social media and stay updated with the latest news, tips, and updates!</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Ask Questions</a></li>
                    <li><a href="#">Send Feedback</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Newsletter</h4>
                <p>Subscribe for latest updates</p>
                <form action="#">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Created By <a href="#">Web Agullina/Vlora</a> | All Rights Reserved</p>
        </div>
    </footer>

    <script>
    function addToCart(productName, price) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({
            name: productName,
            price: price
        });
        localStorage.setItem('cart', JSON.stringify(cart));
        document.getElementById('cart-count').textContent = cart.length;
        window.location.href = 'cart.html';
    }
    
    window.onload = function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        document.getElementById('cart-count').textContent = cart.length;
    }

    function toggleMenu() {
        var nav = document.querySelector('nav');
        nav.classList.toggle('active');
    }
    </script>
</body>
</html>
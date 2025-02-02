<?php
session_start();
require_once 'Database.php';

$db = new Database();
$products = $db->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - TechWORLD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1 class="logo">TechWORLD</h1>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="courses.html">Courses</a></li>
                    <li><a href="products.php" class="active">Products</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['user_role'] == 'admin'): ?>
                            <li><a href="admin/dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                    <li>
                        <a href="cart.php" class="cart-link" id="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count">0</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="courses">
        <h1>Our Products</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <div class="product-grid">
            <?php if($products): ?>
                <?php foreach($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="price">€<?php echo number_format($product['price'], 2); ?></p>
                        <button onclick="addToCart(<?php echo $product['id']; ?>, 
                                '<?php echo htmlspecialchars($product['name']); ?>', 
                                <?php echo $product['price']; ?>)">
                            Add to Cart
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-products">No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-section social-section">
                <h3>TechWORLD</h3>
                <p>Connect with us on social media!</p>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="courses.html">Courses</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Ask Questions</a></li>
                    <li><a href="#">Send Feedback</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Newsletter</h4>
                <p>Subscribe for updates</p>
                <form action="#" method="POST" class="newsletter-form">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 TechWORLD. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function addToCart(id, name, price) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Check if product already exists in cart
            let existingProduct = cart.find(item => item.id === id);
            
            if (existingProduct) {
                existingProduct.quantity += 1;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    quantity: 1
                });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            
            // Show success message
            alert('Product added to cart successfully!');
        }

        function updateCartCount() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let totalItems = cart.reduce((total, item) => total + item.quantity, 0);
            document.getElementById('cart-count').textContent = totalItems;
        }

        // Update cart count when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });

        // Mobile menu toggle
        function toggleMenu() {
            document.querySelector('nav ul').classList.toggle('show');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const nav = document.querySelector('nav ul');
            const hamburger = document.querySelector('.hamburger');
            
            if (!nav.contains(event.target) && !hamburger.contains(event.target)) {
                nav.classList.remove('show');
            }
        });
    </script>
</body>
</html>
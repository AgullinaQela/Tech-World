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

    <section class="courses">
        <h1>Our Products</h1>
        <p>Discover our latest tech products</p>

        <div class="course-grid product-grid">
            <?php
            include 'config.php';
            
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="course-card">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                        <div class="course-info">
                            <h3><?php echo $row['name']; ?></h3>
                            <p class="price">€<?php echo number_format($row['price'], 2); ?></p>
                            <button class="enroll-btn" onclick='addToCart("<?php echo $row['name']; ?>", <?php echo $row['price']; ?>)'>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No products available at the moment.</p>";
            }
            ?>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <h3>TechWORLD</h3>
            <p>Join us in exploring the world of technology.</p>
            <ul class="socials">
                <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p>Created By <a href="#">Web Agullina/Vlora</a> | All Rights Reserved</p>
        </div>
    </footer>

    <script>
    function addToCart(productName, price) {
        // Ruaj produktin në localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({
            name: productName,
            price: price
        });
        localStorage.setItem('cart', JSON.stringify(cart));

        // Përditëso numëruesin e shportës
        document.getElementById('cart-count').textContent = cart.length;

        // Ridrejto tek faqja e shportës
        window.location.href = 'cart.html';
    }
    
    // Ngarko numëruesin e shportës kur faqja hapet
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
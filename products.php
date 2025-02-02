<?php
session_start();

require_once 'Database.php';
=======
include 'config.php';


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
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="contact.php">Contact</a></li>
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

                <li><a href="index.php">Home</a></li> 
                    <li><a href="about.php">About</a></li> 
                    <li><a href="courses.html">Courses</a></li> 
                    <li><a href="Products.php">Products</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li> 
                    <li><a href="cart.html" class="cart-link" id="cart-icon"><i class="fas fa-shopping-cart"></i> <span id="cart-count">0</span></a></li>

                </ul>
            </nav>
        </div>
    </header>

    <section class="courses">
        <h1>Products</h1>
        
        <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
            <div class="admin-controls">
                <a href="admin/add_product.php" class="btn-add">Add New Product</a>
            </div>
        <?php endif; ?>

        <div class="product-grid">
            <?php foreach($products as $product): ?>
                <div class="product-card">
                    <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">€<?php echo number_format($product['price'], 2); ?></p>
                    <p class="added-by">Added by: <?php echo htmlspecialchars($product['added_by']); ?></p>
                    
                    <button onclick="addToCart('<?php echo htmlspecialchars($product['name']); ?>', 
                                              <?php echo $product['price']; ?>)">
                        Add to Cart
                    </button>

                    <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                        <div class="admin-actions">
                            <a href="admin/edit_product.php?id=<?php echo $product['id']; ?>" 
                               class="btn-edit">Edit</a>
                            <a href="admin/delete_product.php?id=<?php echo $product['id']; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Are you sure you want to delete this product?')">
                                Delete
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <script>
    function addToCart(productName, price) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push({
            name: productName,
            price: price
        });
        localStorage.setItem('cart', JSON.stringify(cart));
        document.getElementById('cart-count').textContent = cart.length;
        window.location.href = 'cart.php';
    }

    window.onload = function() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        document.getElementById('cart-count').textContent = cart.length;
    }
    </script>
</body>
</html>
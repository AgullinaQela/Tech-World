<?php
session_start();
require_once 'Database.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="cart-container">
        <h1>Shopping Cart</h1>
        <div id="cart-items"></div>
        <div class="cart-total">
            <h3>Total: €<span id="total">0.00</span></h3>
            <button onclick="checkout()" class="checkout-btn">Checkout</button>
        </div>
    </div>

    <script>
        function loadCart() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let cartDiv = document.getElementById('cart-items');
            let total = 0;
            
            cartDiv.innerHTML = '';
            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                cartDiv.innerHTML += `
                    <div class="cart-item">
                        <h3>${item.name}</h3>
                        <p>€${item.price}</p>
                        <input type="number" value="${item.quantity}" min="1" 
                               onchange="updateQuantity(${index}, this.value)">
                        <button onclick="removeItem(${index})">Remove</button>
                    </div>
                `;
            });
            
            document.getElementById('total').textContent = total.toFixed(2);
        }

        function updateQuantity(index, quantity) {
            let cart = JSON.parse(localStorage.getItem('cart'));
            cart[index].quantity = parseInt(quantity);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function removeItem(index) {
            let cart = JSON.parse(localStorage.getItem('cart'));
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function checkout() {
            alert('Checkout functionality will be implemented soon!');
        }

        loadCart();
    </script>
</body>
</html>
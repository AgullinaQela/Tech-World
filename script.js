function toggleMenu() {
    document.querySelector("nav ul").classList.toggle("show");
}
const heroSection = document.querySelector('.hero');


const backgrounds = [
  'Images/pic1.jpg',
  'Images/pic27.jpg',
  'Images/pic25.jpg'
];

let currentIndex = 0;

function changeBackground() {
  heroSection.style.backgroundImage = `url('${backgrounds[currentIndex]}')`;
}

function nextBackground() {
  currentIndex = (currentIndex + 1) % backgrounds.length;
  changeBackground();
}

function prevBackground() {
  currentIndex = (currentIndex - 1 + backgrounds.length) % backgrounds.length;
  changeBackground();
}

document.querySelector('.next-btn').addEventListener('click', nextBackground);
document.querySelector('.prev-btn').addEventListener('click', prevBackground);

changeBackground();





document.addEventListener("DOMContentLoaded", function () {
  // Merr numrin e produkteve në shportë nga localStorage
  let cartCount = localStorage.getItem("cartCount") ? parseInt(localStorage.getItem("cartCount")) : 0;
  document.getElementById("cart-count").innerText = cartCount;

  // Shto event listener për butonat "Add to Cart"
  document.querySelectorAll(".add-to-cart").forEach(button => {
      button.addEventListener("click", function () {
          // Rrit numrin e produkteve në shportë
          cartCount++;
          localStorage.setItem("cartCount", cartCount);
          document.getElementById("cart-count").innerText = cartCount;

          // Ridrejto përdoruesin te shporta
          window.location.href = "cart.html";
      });
  });
});








document.addEventListener("DOMContentLoaded", function () {
    const productGrid = document.getElementById("product-grid");
    const cartCount = document.getElementById("cart-count");
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Funksion për të përditësuar numrin e produkteve në shportë
    function updateCartCount() {
        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
    }

    // Ngarkon produktet nga PHP
    fetch("products.php")
        .then(response => response.json())
        .then(products => {
            products.forEach(product => {
                const productCard = document.createElement("div");
                productCard.classList.add("product-card");
                productCard.innerHTML = `
                    <img src="${product.image}" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p>€${product.price}</p>
                    <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
                `;
                productGrid.appendChild(productCard);
            });

            // Shto event listener për çdo buton "Add to Cart"
            document.querySelectorAll(".add-to-cart").forEach(button => {
                button.addEventListener("click", function () {
                    let productId = parseInt(this.getAttribute("data-id"));
                    addToCart(productId);
                });
            });
        });

    // Funksion për të shtuar produktin në shportë
    function addToCart(productId) {
        let product = cart.find(item => item.id === productId);
        
        if (product) {
            product.quantity += 1; // Nëse ekziston, rrit sasinë
        } else {
            cart.push({ id: productId, quantity: 1 }); // Shto produktin e ri
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount();
        scrollToCart(); // Fokus te shporta
    }

    // Fokuson menynë e shportës kur shtohet produkti
    function scrollToCart() {
        let cartIcon = document.getElementById("cart-icon");
        cartIcon.classList.add("highlight");

        setTimeout(() => {
            cartIcon.classList.remove("highlight");
        }, 1000);
    }

    // Përditëson numrin e produkteve kur faqja ringarkohet
    updateCartCount();
});

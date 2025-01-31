<?php
session_start();
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechWorld</title>
    <link rel="stylesheet" href="style.css">          
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
                    <li><a href="Products.php">Products</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li> 
                </ul>
              </nav>
              </div>
            </header>
        
<div class="hero">
    <div class="content">
        <h2>The Best Courses You Will Find Here!</h2>
        <p>Start Learning Today and Unlock Your Full Potential!</p>
        <button class="btn-main">Get Started</button>
    </div>
    
</div>

<section class="top-subjects">
    <h2>Our Top Subjects</h2>
    <div class="subject-container">
        <div class="subject">
            <img src="Images/calculator_2344132.png" alt="subject1">
            <h3>Mathematics</h3>
        </div>
        <div class="subject">
            <img src="Images/microscope_947477.png" alt="subject2">
            <h3>Science</h3>
        </div>
        <div class="subject">
            <img src="Images/graphic-design_1882761.png"alt="subject3">
            <h3>Web Developer</h3>
        </div>
    </div>
  </section>

  <section class="top-courses">
    <h2>Our Top Courses</h2>
    <div class="courses-container">
        <div class="course">
            <img src="Images/pic2.svg" alt="Course 1">
            <h3>Javascript Frameworks</h3>
        </div>
        <div class="course">
            <img src="Images/pic3.svg" alt="Course 2">
            <h3>React</h3>
        </div>
        <div class="course">
            <img src="Images/pic4.svg" alt="Course 3">
            <h3>Web Development</h3>
        </div>
        <div class="course">
            <img src="Images/pic5.svg" alt="Course 4">
            <h3>Next.js</h3>
        </div>
        <div class="course">
            <img src="Images/pic6.svg" alt="Course 5">
            <h3>AI</h3>
            
        </div>
    </div>
  </section>

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

      
        // Auto change background every 5 seconds
        setInterval(nextBackground, 5000);

        // Initialize background
        changeBackground();
        </script>
</body>
</html>
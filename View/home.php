<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityWatch - Home</title>
    <link rel="stylesheet" href="home.css">
    <script src="../Controller/home.js" defer></script>
</head>
<body>

    <header>
        <div class="logo">
            <h1>CityWatch</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#about">About</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>

        <section id="hero">
            <h2>Welcome to CityWatch</h2>
            <p>Report Dhaka issues and help keep our Dhaka clean and safe.</p>
        </section>

        <section id="incidents">
            <h3>Recent Reports</h3>
            
            <div class="slider-wrapper">
                
                <button class="slider-btn prev" onclick="moveSlide(-1)">&#10094;</button>

                <div class="incident-container">
                    
                    <article class="incident-card">
                        <img src="images/image1.jpg" alt="Issue Image">
                        <div class="card-text">
                            <h4>Damaged Road</h4>
                            <p><strong>Location:</strong> Uttara main road</p>
                            <p>Broken and damaged steets</p>
                        </div>
                    </article>

                    <article class="incident-card">
                        <img src="images/image2.jpg" alt="Issue Image">
                        <div class="card-text">
                            <h4>Broken Streetlight</h4>
                            <p><strong>Location:</strong>Kuril</p>
                            <p>Lights are not working.</p>
                        </div>
                    </article>

                    <article class="incident-card">
                        <img src="images/image3.jpg" alt="Issue Image">
                        <div class="card-text">
                            <h4>Garbage Pileup</h4>
                            <p><strong>Location:</strong>Mirpur</p>
                            <p>Waste has not been collected.</p>
                        </div>
                    </article>

                </div>

                <button class="slider-btn next" onclick="moveSlide(1)">&#10095;</button>
            
            </div>
        </section>

        <section id="about">
            <h3>About CityWatch</h3>
            <p>CityWatch connects citizens with official authorities. We help you report problems like bad roads, waste, and safety issues quickly.</p>
        </section>

        <section id="contact">
            <h3>Contact Us</h3>
            <p>Email us at: <a href="mailto:info@citywatch.com">info@citywatch.com</a></p>
        </section>

    </main>

    <footer>
        <p>&copy; 2026 CityWatch - Smart Urban Reporting</p>
    </footer>

</body>
</html>
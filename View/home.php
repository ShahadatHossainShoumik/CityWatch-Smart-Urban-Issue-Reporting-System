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

    <?php
    require_once '../Model/IssueModel.php';

    // Collect up to 10 of the most recent incidents
    $incidents = [];
    $allIncidents = getAllIssues();

    if ($allIncidents && mysqli_num_rows($allIncidents) > 0) {
        $count = 0;
        $limit = 10;

        while ($count < $limit && ($row = mysqli_fetch_assoc($allIncidents))) {
            $incidents[] = $row;
            $count++;
        }
    }
    ?>

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
                    
                    <?php if (count($incidents) > 0): ?>
                        <?php foreach ($incidents as $incident): ?>
                            <article class="incident-card">
                                <?php if (!empty($incident['image'])): ?>
                                    <img src="../Images/<?php echo htmlspecialchars($incident['image']); ?>" alt="Issue Image">
                                <?php else: ?>
                                    <img src="images/placeholder.jpg" alt="No Image">
                                <?php endif; ?>
                                <div class="card-text">
                                    <h4><?php echo htmlspecialchars($incident['title']); ?></h4>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($incident['location']); ?></p>
                                    <p><?php echo htmlspecialchars(substr($incident['description'], 0, 100)); ?>...</p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <article class="incident-card">
                            <div class="card-text">
                                <h4>No Reports Yet</h4>
                                <p>Be the first to report an issue in your area!</p>
                            </div>
                        </article>
                    <?php endif; ?>

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
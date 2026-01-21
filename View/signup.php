<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityWatch - Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <script src="../Controller/signup.js"></script>
</head>

<body>

    <header>
        <div class="logo">
            <h1>CityWatch</h1>
        </div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="home.php#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="signup-section">
            <div class="container">
                <h2>Create Account</h2>

                <?php
                session_start();
                if (isset($_SESSION['msg'])) {
                    $msgType = $_SESSION['msg_type'] ?? 'error';
                    $bgColor = $msgType === 'error' ? '#ffcdd2' : '#c8e6c9';
                    $borderColor = $msgType === 'error' ? '#f44336' : '#4CAF50';
                    $textColor = $msgType === 'error' ? '#c62828' : '#2e7d32';
                    ?>
                    <div id="notification-message"
                        style="padding: 15px; margin-bottom: 20px; background: <?php echo $bgColor; ?>; border: 2px solid <?php echo $borderColor; ?>; border-radius: 8px; color: <?php echo $textColor; ?>; font-weight: 500; text-align: center; transition: opacity 0.5s ease-out;">
                        <?php echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                        unset($_SESSION['msg_type']); ?>
                    </div>
                    <script>
                        setTimeout(function() {
                            var notification = document.getElementById('notification-message');
                            if (notification) {
                                notification.style.opacity = '0';
                                setTimeout(function() {
                                    notification.style.display = 'none';
                                }, 500);
                            }
                        }, 5000);
                    </script>
                <?php } ?>

                <form class="signup-form" action="../Controller/AuthController.php" method="POST"
                    enctype="multipart/form-data" onsubmit="return validateForm()">

                    <input type="hidden" name="signup" value="1">

                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required
                        onkeyup="validateName()">
                    <span id="nameMessage"></span>

                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required onchange="validateAge()">
                    <span id="dobMessage"></span>

                    <label for="mobile">Mobile Number</label>
                    <input type="number" id="mobile" name="mobile" placeholder="Enter 11-digit mobile number" required
                        onkeyup="validateMobile()">
                    <span id="mobileMessage"></span>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>

                    <label for="nid">NID Number</label>
                    <input type="number" id="nid" name="nid" placeholder="Enter 10-digit NID" required
                        onkeyup="validateNid()">
                    <span id="nidMessage"></span>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required
                        onkeyup="validatePassword()">
                    <span id="passwordMessage"></span>

                    <label for="profile_image">Profile Image</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*">

                    <button type="submit" name="signup" class="signup-btn">Sign Up</button>

                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2026 CityWatch - Smart Urban Reporting</p>
    </footer>

</body>

</html>
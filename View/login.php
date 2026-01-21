
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CityWatch</title>
    <link rel="stylesheet" href="login.css">
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

    <main id="login-container">
        <h2>Login to CityWatch</h2>
        
        <form action="../Controller/AuthController.php" method="POST" class="login-form">
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Enter your email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password">

            <label for="role">Select Role</label>
            <select name="role" id="role" required>
                <option value="citizen">Citizen</option>
                <option value="authority">Authority</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" name="login">Login</button>

            <p> <a href="signup.php">Create an account</a></p>
        </form>
    </main>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
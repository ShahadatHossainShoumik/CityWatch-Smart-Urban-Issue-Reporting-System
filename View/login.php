<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CityWatch</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>

    <?php

    //  Handle user login with 2 methods
    // Saved cookies (remember me) - Auto-login on next visit
    // Form submission - Username/password login
    // Session-based auth, HttpOnly cookies, role-based redirects
    
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    require_once '../Model/UserModel.php';

    // Function: clearRememberCookies()
    // Removes all persistent login cookies
    // Called when: Remember-me login fails or user logs out
    function clearRememberCookies()
    {
        $expire = time() - 3600;
        setcookie('citywatch_user_id', '', $expire, '/', '', false, true);
        setcookie('citywatch_user_email', '', $expire, '/', '', false, true);
        setcookie('citywatch_user_role', '', $expire, '/', '', false, true);
        setcookie('citywatch_user_name', '', $expire, '/', '', false, true);
        setcookie('citywatch_remember', '', $expire, '/', '', false, true);
    }

    // Check if user has saved cookies for auto-login
    if (isset($_COOKIE['citywatch_remember']) && $_COOKIE['citywatch_remember'] === '1') {
        $user = getUserById($_COOKIE['citywatch_user_id']);
        if ($user && (!isset($user['is_blocked']) || $user['is_blocked'] != 1)) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to appropriate dashboard
            $role = $user['role'];
            if ($role === 'citizen') {
                header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/Citizen/citizen_dashboard.php");
            } elseif ($role === 'authority') {
                header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/Authority/authority_dashboard.php");
            } elseif ($role === 'admin') {
                header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/Admin/admin_dashboard.php");
            }
            exit();
        } else {
            clearRememberCookies();
            $_SESSION['msg'] = 'Your account is blocked. Please contact support.';
        }
    }
    ?>

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

        <?php if (isset($_SESSION['msg'])) {
            $isError = strpos($_SESSION['msg'], 'Invalid') !== false || strpos($_SESSION['msg'], 'not found') !== false;
            $bgColor = $isError ? '#ffcdd2' : '#c8e6c9';
            $borderColor = $isError ? '#f44336' : '#4CAF50';
            $textColor = $isError ? '#c62828' : '#2e7d32';
            ?>
            <div
                style="padding: 12px; margin-bottom: 15px; background: <?php echo $bgColor; ?>; border: 1px solid <?php echo $borderColor; ?>; border-radius: 5px; color: <?php echo $textColor; ?>;">
                <?php echo $_SESSION['msg'];
                unset($_SESSION['msg']); ?>
            </div>
        <?php } ?>

        <form action="/Projects/CityWatch-Smart-Urban-Issue-Reporting-System/Controller/AuthController.php"
            method="POST" class="login-form">

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

            <div style="display: flex; align-items: center; margin-bottom: 15px;">
                <input type="checkbox" id="remember" name="remember" value="1" style="margin-right: 10px;">
                <label for="remember" style="margin: 0;">Remember me for 7 days</label>
            </div>

            <button type="submit" name="login">Login</button>

            <p> <a href="signup.php">Create an account</a></p>
        </form>
    </main>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
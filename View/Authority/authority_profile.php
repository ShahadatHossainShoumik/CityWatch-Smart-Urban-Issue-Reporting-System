<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authority Profile - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="authority_profile.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="authority_dashboard.php">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php">New Announcement</a></li>
            <li><a href="all_announcements.php">All Announcements</a></li>
            <li><a href="authority_profile.php" class="active">Profile</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Authority Profile</h2>

        <div class="profile-card">
            <h3>Account Details</h3>
            <p><strong>Email:</strong></p>
            <p><strong>Department:</strong></p>
            <p><strong>Role:</strong></p>
        </div>

        <div class="card">
            <h3>Change Password</h3>
            <form action="#" method="POST" class="formGrid">
                <div class="field full">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="field full">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>
                    <small class="hint">Must contain atleast 8 characters along with numbers and special characters</small>
                </div>
                <div class="field full">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <div class="field full">
                    <button type="submit" class="primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>
</body>
</html>
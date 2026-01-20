<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_citizen.css"> 
    <link rel="stylesheet" href="update_admin.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="update_citizen.php">Update Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="update_authority.php">Update Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="update_admin.php" class="active">Update Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Update Admin</h2>
        <p class="subtitle">Search and update admin account details.</p>

        <form action="#" class="search-form">
            <input type="text" name="search" placeholder="Search by email..." required>
            <button type="submit">Search</button>
        </form>

        <form action="#" class="update-admin-form">
            <input type="hidden" name="update_admin_id" value="1">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="" placeholder="Type your email">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">

            <button type="submit">Update Admin</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
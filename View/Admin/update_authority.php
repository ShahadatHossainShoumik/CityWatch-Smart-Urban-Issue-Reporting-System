<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Authority - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_citizen.css"> 
    <link rel="stylesheet" href="update_authority.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="update_citizen.php">Update Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="update_authority.php" class="active">Update Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Update Authority</h2>
        <p class="subtitle">Search and modify authority account details.</p>

        <form action="#" class="search-form">
            <input type="text" name="search" placeholder="Search by email..." required>
            <button type="submit">Search</button>
        </form>

        <form action="#" class="update-authority-form">
            <input type="hidden" name="update_authority_id" value="1">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="" required>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" value="" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">

            <button type="submit">Update Authority</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
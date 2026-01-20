<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Announcement - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_citizen.css">
    <link rel="stylesheet" href="update_announcement.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="update_announcement.php" class="active">Update Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Update Announcement</h2>
        <p class="subtitle">Edit existing system announcements.</p>

        <form action="#" class="search-form">
            <input type="text" name="search" placeholder="Search by title..." required>
            <button type="submit">Search</button>
        </form>

        <form action="#" class="update-announcement-form">
            <input type="hidden" name="update_announcement_id" value="1">

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <button type="submit">Update Announcement</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
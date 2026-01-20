<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_announcement.css">
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
            <li><a href="manage_announcement.php" class="active">Manage Announcements</a></li>
            <li><a href="update_announcement.php">Update Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Announcements</h2>
        <p class="subtitle">View and search system-wide announcements.</p>

        <div class="top-bar">
            <form action="#" class="search-form">
                <input type="text" name="search" placeholder="Search by title">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="announcement-card">
            <h3>Problem 1</h3>
            <p><strong>Status:</strong> <span class="status-active">Active</span></p>
            <p><strong>Created at:</strong></p>
            <p class="desc"></p>
            
            <div class="card-actions">
                <button class="btn-edit">Edit</button>
                <button class="btn-delete">Delete</button>
            </div>
        </div>

        <div class="announcement-card">
            <h3>Problem 2</h3>
            <p><strong>Status:</strong> <span class="status-active">Active</span></p>
            <p><strong>Created at:</strong></p>
            <p class="desc"></p>
            
            <div class="card-actions">
                <button class="btn-edit">Edit</button>
                <button class="btn-delete">Delete</button>
            </div>
        </div>

        <div class="announcement-card">
            <h3>Problem 3</h3>
            <p><strong>Status:</strong> <span class="status-inactive">Inactive</span></p>
            <p><strong>Created at:</strong></p>
            <p class="desc"></p>
            
            <div class="card-actions">
                <button class="btn-edit">Edit</button>
                <button class="btn-delete">Delete</button>
            </div>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
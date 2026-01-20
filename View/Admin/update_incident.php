<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Incident - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_incidents.css">
    <link rel="stylesheet" href="manage_citizen.css">
    <link rel="stylesheet" href="update_incident.css">
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
            <li><a href="update_admin.php">Update Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="update_incident.php" class="active">Update Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Update Incident</h2>
        <p class="subtitle">Search and modify incident details.</p>

        <form action="#" class="search-form">
            <input type="text" name="search" placeholder="Search by title..." required>
            <button type="submit">Search</button>
        </form>

        <form action="#" class="update-incident-form" enctype="multipart/form-data">
            <input type="hidden" name="update_incident_id" value="101">

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="Damaged Road" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="Main Street, Sector 4" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required>There is a large pothole in the middle of the road causing traffic jams.</textarea>

            <label>Current Images:</label>
            <div class="incident-images-container">
                <img src="../../images/image1.jpg" class="incident-image" alt="Incident Image">
            </div>

            <label for="incident_image">Change/Add Image:</label>
            <input type="file" id="incident_image" name="incident_image" accept="image/*">

            <button type="submit">Update Incident</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
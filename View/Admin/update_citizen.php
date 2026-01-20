<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Citizen - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_citizen.css">
    <link rel="stylesheet" href="update_citizen.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="update_citizen.php" class="active">Update Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="update_authority.php">Update Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="update_admin.php">Update Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Update Citizen</h2>
        <p class="subtitle">Search and update registered citizen details.</p>

        <form action="#" class="search-form">
            <input type="text" name="search" placeholder="Search by email..." required>
            <button type="submit">Search</button>
        </form>

        <form action="#" enctype="multipart/form-data" class="update-citizen-form">
            <input type="hidden" name="update_citizen_id" value="1">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="" required>

            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile" value="" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="" required>

            <label for="nid">NID:</label>
            <input type="text" id="nid" name="nid" value="" required>

            <label>Current Profile Image:</label>
            <div class="profile-image-container">
                <img src="../images/default-profile.jpg" alt="Profile Image">
            </div>

            <label for="profile_image">Change Profile Image:</label>
            <input type="file" id="profile_image" name="profile_image"">

            <button type="submit">Update Citizen</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
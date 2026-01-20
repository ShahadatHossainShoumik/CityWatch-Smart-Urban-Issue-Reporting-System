<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Uploads - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_my_uploads.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="citizen_dashboard.php">Home</a></li>
            <li><a href="citizen_new_incident.php">New Incident</a></li>
            <li><a href="citizen_my_uploads.php" class="active">My Uploads</a></li>
            <li><a href="citizen_view_announcement.php">Announcement</a></li>
            <li><a href="citizen_profile.php">Profile</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>My Uploads</h2>

        <div class="status-message">
            <p style="color: #0277bd;">Manage your reported incidents below.</p>
        </div>

        <div class="incident-card">
            <h3>Edit Incident #101</h3>
            
            <form class="edit-form">
                <label for="title-1">Title:</label>
                <input type="text" id="title-1" name="title" value="">

                <label for="location-1">Location:</label>
                <input type="text" id="location-1" name="location" value="">

                <label for="description-1">Description:</label>
                <textarea id="description-1" name="description" rows="4"></textarea>

                <label>Current Images:</label>
                <div class="incident-images">
                    <img src="../images/image1.jpg" class="incident-image" alt="Incident Image">
                </div>

                <label for="incident_image-1">Change Image:</label>
                <input type="file" id="incident_image-1" name="incident_image" accept="image/*">

                <button type="submit" class="btn-submit">Save Changes</button>
            </form>

            <form class="delete-form">
                <button type="button" class="btn-delete">Delete Incident</button>
            </form>
        </div>

        <div class="incident-card">
            <h3>Edit Incident #102</h3>
            
            <form class="edit-form">
                <label for="title-2">Title:</label>
                <input type="text" id="title-2" name="title">

                <label for="location-2">Location:</label>
                <input type="text" id="location-2" name="location">

                <label for="description-2">Description:</label>
                <textarea id="description-2" name="description" rows="4"></textarea>

                <label>Current Images:</label>
                <div class="incident-images">
                    <img src="../images/image2.jpg" class="incident-image" alt="Incident Image">
                </div>

                <label for="incident_image-2">Change Image:</label>
                <input type="file" id="incident_image-2" name="incident_image">

                <button type="submit" class="btn-submit">Save Changes</button>
            </form>

            <form class="delete-form">
                <button type="button" class="btn-delete">Delete Incident</button>
            </form>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolved Incidents - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="authority_dashboard.css">
</head>

<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="authority_dashboard.php">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="resolved.php" class="active">Resolved Incidents</a></li>
            <li><a href="fake.php">Fake Incidents</a></li>
            <li><a href="new_announcement.php">New Announcement</a></li>
            <li><a href="all_announcements.php">All Announcements</a></li>
            <li><a href="authority_profile.php">Profile</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h3 class="page-title">Resolved Incidents</h3>

        <div class="incident-list">

            <div class="incident-card">
                <h4>Problem 1</h4>
                <p><strong>Location:</strong></p>
                <p><strong>Citizen Name:</strong></p>
                <p><strong>Description:</strong></p>
                <p><strong>Upvotes:</strong> | <strong>Downvotes:</strong> </p>

                <div class="incident-images">
                    <img src="../images/image1.jpg" class="incident-image" alt="Resolved Incident Image" />
                </div>

                <p style="color:green; font-weight: bold; margin-top: 10px;">Status: Resolved</p>
            </div>

            <div class="incident-card">
                <h4>Problem 2</h4>
                <p><strong>Location:</strong></p>
                <p><strong>Citizen Name:</strong></p>
                <p><strong>Description:</strong></p>
                <p><strong>Upvotes:</strong> | <strong>Downvotes:</strong> </p>

                <div class="incident-images">
                    <img src="../images/image2.jpg" class="incident-image" alt="Resolved Incident Image" />
                </div>

                <p style="color: green; font-weight: bold; margin-top: 10px;">Status: Resolved</p>
            </div>

        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
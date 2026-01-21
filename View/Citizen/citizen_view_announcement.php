<?php
session_start();

// Verify user is authenticated citizen BEFORE requiring models
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../login.php");
    exit();
}

require_once('../../Model/AnnouncementModel.php');

$announcements = getAllAnnouncements();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_view_announcement.css">
</head>

<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="citizen_dashboard.php">Home</a></li>
            <li><a href="citizen_new_incident.php">New Incident</a></li>
            <li><a href="citizen_my_uploads.php">My Uploads</a></li>
            <li><a href="citizen_view_announcement.php" class="active">Announcement</a></li>
            <li><a href="citizen_profile.php">Profile</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Active Announcements</h2>
        <p class="section-subtitle">Important updates from city administration.</p>

        <?php if (!empty($announcements)) { ?>
            <?php foreach ($announcements as $announcement) { ?>
                <div class="announcement-card">
                    <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($announcement['description'] ?? '')); ?></p>
                    <p class="created-at"><strong>Posted on:</strong>
                        <?php echo date('F j, Y \a\t g:i A', strtotime($announcement['created_at'])); ?></p>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="no-announcements">
                <p> No announcements available at this time. Check back later for updates from city authorities.</p>
            </div>
        <?php } ?>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
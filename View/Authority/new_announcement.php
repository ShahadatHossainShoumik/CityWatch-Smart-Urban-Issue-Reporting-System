<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Announcement - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="authority_new_announcement.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="authority_dashboard.php">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php" class="active">New Announcement</a></li>
            <li><a href="all_announcements.php">All Announcements</a></li>
            <li><a href="authority_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Create a New Announcement</h2>

        <?php session_start(); if(isset($_SESSION['msg'])){ ?>
            <div class="flash" style="padding: 12px 14px; background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 6px; margin-bottom: 15px; color: #2e7d32; font-weight: 600;">
                <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
            </div>
        <?php } ?>

        <form action="../../Controller/AnnouncementController.php" method="POST" class="announcement-form">
            <input type="hidden" name="create_announcement" value="1">
            
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" placeholder="e.g., Road Maintenance Notice" required maxlength="200">
            </div>

            <div class="form-group">
                <label for="description">Message</label>
                <textarea id="description" name="description" rows="5" placeholder="Enter full announcement details here..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Create Announcement</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
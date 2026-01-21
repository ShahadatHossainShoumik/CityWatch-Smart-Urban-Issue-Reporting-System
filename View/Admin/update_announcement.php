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

    <?php
    session_start();
    require_once '../../Model/AnnouncementModel.php';

    // Check admin
    if (! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../../View/login.php");
        exit();
    }

    $announcement = null;
    $searchTerm = '';

    // Get announcement by ID if provided
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $announcement = getAnnouncementById($id);
    } elseif(isset($_GET['search']) && !empty($_GET['search'])){
        $searchTerm = $_GET['search'];
        // Search by title
        $allAnnouncements = getAllAnnouncements();
        foreach($allAnnouncements as $a){
            if(stripos($a['title'], $searchTerm) !== false){
                $announcement = $a;
                break;
            }
        }
        if (! $announcement) {
            $noResult = "No announcement found with that title";
        }
    }
    ?>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Update Announcement</h2>
        <p class="subtitle">Edit existing system announcements.</p>

        <form action="update_announcement.php" method="GET" class="search-form" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Search by title..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
            <button type="submit">Search</button>
        </form>

        <?php if (isset($noResult)): ?>
            <div style="padding: 15px; margin-bottom: 20px; background-color: #ff9800; color: white; border-radius: 5px;">
                <?php echo $noResult; ?>
            </div>
        <?php endif; ?>

        <?php if ($announcement): ?>
            <form action="../../Controller/AdminController.php" method="POST" class="update-announcement-form" style="max-width: 600px; margin: 0 auto;">
                <input type="hidden" name="action" value="edit_announcement">
                <input type="hidden" name="id" value="<?php echo $announcement['id']; ?>">

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($announcement['title']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; font-family: Arial, sans-serif;"><?php echo htmlspecialchars($announcement['message']); ?></textarea>

                <button type="submit" style="padding: 10px 20px; background-color: #2196F3; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 14px;">Update Announcement</button>
                <a href="manage_announcement.php" style="display: inline-block; margin-left: 10px; padding: 10px 20px; background-color: #757575; color: white; text-decoration: none; border-radius: 3px;">Cancel</a>
            </form>
        <?php else: ?>
            <div style="padding: 20px; text-align: center; background-color: #f5f5f5; border-radius: 5px;">
                <p>Search for an announcement to update its details</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
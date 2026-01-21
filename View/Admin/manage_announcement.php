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

    <?php

    session_start();
    require_once '../../Model/AnnouncementModel.php';

    // Check admin
    if (! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }

    // Get all announcements
    $announcements = getAllAnnouncements();
    $searchTerm = '';
    if (isset($_GET['search']) && ! empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $announcements = array_filter($announcements, function($announcement) use ($searchTerm) {
            return stripos($announcement['title'], $searchTerm) !== false || stripos($announcement['description'] ?? '', $searchTerm) !== false;
        });
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
            <li><a href="manage_announcement.php" class="active">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Announcements</h2>
        <p class="subtitle">View and manage system-wide announcements.</p>

        <?php if(isset($_SESSION['msg'])): ?>
            <div class="alert alert-success" style="padding: 15px; margin-bottom: 20px; background-color: #4CAF50; color: white; border-radius: 5px;">
                <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="top-bar">
            <form action="manage_announcement.php" class="search-form" method="GET">
                <input type="text" name="search" placeholder="Search by title..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </form>
            <button onclick="toggleAddForm()" class="btn" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer; margin-left: 10px;">+ Add Announcement</button>
        </div>

        <div id="add-announcement-form" class="form-container" style="display:none; margin-top: 30px; padding: 20px; background-color: #f5f5f5; border-radius: 5px; max-width: 600px; margin-left: auto; margin-right: auto; margin-bottom: 20px;">
            <h3>Add New Announcement</h3>
            <form action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="add_announcement">
                
                <label for="add-title">Title:</label>
                <input type="text" id="add-title" name="title" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box;">

                <label for="add-message">Message:</label>
                <textarea id="add-message" name="message" rows="5" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box; font-family: Arial, sans-serif;"></textarea>

                <button type="submit" class="btn-submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer; margin-right: 10px;">Create Announcement</button>
                <button type="button" class="btn-cancel" onclick="closeAddForm()" style="padding: 10px 20px; background-color: #757575; color: white; border: none; border-radius: 3px; cursor: pointer;">Cancel</button>
            </form>
        </div>
        // Display announcements
        <?php if (count($announcements) > 0): ?>
            <?php foreach ($announcements as $announcement): ?>
                <div class="announcement-card" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px;">
                    <h3><?php echo htmlspecialchars($announcement['title']); ?></h3>
                    <p><strong>Created by:</strong> <?php echo htmlspecialchars($announcement['author_id']); ?></p>
                    <p><strong>Created at:</strong> <?php echo date('M d, Y - H:i', strtotime($announcement['created_at'] ?? 'now')); ?></p>
                    <p class="desc"><?php echo htmlspecialchars(substr($announcement['description'] ?? '', 0, 100)) . '...'; ?></p>
                    
                    <div class="card-actions" style="margin-top: 15px;">
                        <button class="btn btn-edit" onclick="editAnnouncement(<?php echo $announcement['id']; ?>, '<?php echo htmlspecialchars($announcement['title'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($announcement['description'] ?? '', ENT_QUOTES); ?>')">Edit</button>
                        <form action="../../Controller/AdminController.php" method="POST" style="display:inline;" onsubmit="return confirm('Delete this announcement?');">
                            <input type="hidden" name="action" value="delete_announcement">
                            <input type="hidden" name="id" value="<?php echo $announcement['id']; ?>">
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="padding: 20px; text-align: center; background-color: #f5f5f5; border-radius: 5px;">
                <p>No announcements found</p>
            </div>
        <?php endif; ?>
        // Edit announcement form
        <div id="edit-announcement-form" class="form-container" style="display:none; margin-top: 30px; padding: 20px; background-color: #f5f5f5; border-radius: 5px; max-width: 600px; margin-left: auto; margin-right: auto;">
            <h3>Edit Announcement</h3>
            <form action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="edit_announcement">
                <input type="hidden" name="id" id="edit-id">
                
                <label for="edit-title">Title:</label>
                <input type="text" id="edit-title" name="title" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box;">

                <label for="edit-message">Message:</label>
                <textarea id="edit-message" name="message" rows="5" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box; font-family: Arial, sans-serif;"></textarea>

                <button type="submit" class="btn-submit" style="padding: 10px 20px; background-color: #2196F3; color: white; border: none; border-radius: 3px; cursor: pointer; margin-right: 10px;">Update Announcement</button>
                <button type="button" class="btn-cancel" onclick="closeEditForm()" style="padding: 10px 20px; background-color: #757575; color: white; border: none; border-radius: 3px; cursor: pointer;">Cancel</button>
            </form>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        //add announcement form toggle
        function toggleAddForm(){
            const form = document.getElementById('add-announcement-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
        //disable add form
        function closeAddForm(){
            document.getElementById('add-announcement-form').style.display = 'none';
        }
        // edit announcement form
        function editAnnouncement(id, title, message){
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-message').value = message;
            document.getElementById('edit-announcement-form').style.display = 'block';
        }
        //close edit form
        function closeEditForm(){
            document.getElementById('edit-announcement-form').style.display = 'none';
        }
    </script>

</body>
</html>
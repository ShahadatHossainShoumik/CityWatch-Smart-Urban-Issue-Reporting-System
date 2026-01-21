<?php
session_start();

// Verify user is authenticated citizen BEFORE including models
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen' || !isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Now safe to require models and use $_SESSION
require_once('../../Model/IssueModel.php');
// Fetch user's uploaded issues
$user_id = $_SESSION['id'];
$issues = getIssuesByUser($user_id);
?>
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
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>My Uploads</h2>
        
        <?php if (isset($_SESSION['msg'])) { ?>
            <div class="flash"
                style="padding: 12px 14px; background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 6px; margin-bottom: 15px; color: #2e7d32; font-weight: 600;">
                <?php echo $_SESSION['msg'];
                unset($_SESSION['msg']); ?>
            </div>
        <?php } ?>
        
        <?php if ($issues && mysqli_num_rows($issues) > 0) { ?>
            <?php while ($issue = mysqli_fetch_assoc($issues)) { ?>
                <div class="incident-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3>#<?php echo $issue['id']; ?> - <?php echo htmlspecialchars($issue['title']); ?></h3>
                        <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold; 
                            <?php echo (empty($issue['status']) || $issue['status'] === 'reviewed' || $issue['status'] === 'resolved') ? 'background: #c8e6c9; color: #2e7d32;' :
                                (($issue['status'] === 'rejected') ? 'background: #ffcdd2; color: #c62828;' :
                                    'background: #fff3cd; color: #856404;'); ?>">
                            <?php
                            $statusDisplay = $issue['status'];
                            if (empty($issue['status'])) {
                                $statusDisplay = 'Approved';
                            } elseif ($issue['status'] === 'reviewed') {
                                $statusDisplay = 'Reviewed';
                            } elseif ($issue['status'] === 'resolved') {
                                $statusDisplay = 'Resolved';
                            } elseif ($issue['status'] === 'pending') {
                                $statusDisplay = 'Pending';
                            } else {
                                $statusDisplay = ucfirst($issue['status']);
                            }
                            echo $statusDisplay;
                            ?>
                        </span>
                    </div>
                    
                    <form class="edit-form" action="../../Controller/CitizenUploadsController.php" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="edit_issue" value="1">
                        <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">

                        <label for="title-<?php echo $issue['id']; ?>">Title:</label>
                        <input type="text" id="title-<?php echo $issue['id']; ?>" name="title"
                            value="<?php echo htmlspecialchars($issue['title']); ?>" required>

                        <label for="location-<?php echo $issue['id']; ?>">Location:</label>
                        <input type="text" id="location-<?php echo $issue['id']; ?>" name="location"
                            value="<?php echo htmlspecialchars($issue['location']); ?>" required>

                        <label for="description-<?php echo $issue['id']; ?>">Description:</label>
                        <textarea id="description-<?php echo $issue['id']; ?>" name="description" rows="4"
                            required><?php echo htmlspecialchars($issue['description']); ?></textarea>

                        <?php if (!empty($issue['image'])) { ?>
                            <label>Current Image:</label>
                            <div class="incident-images">
                                <img src="../../Images/<?php echo htmlspecialchars($issue['image']); ?>" class="incident-image"
                                    alt="Incident Image">
                            </div>
                        <?php } ?>

                        <label for="issue_image-<?php echo $issue['id']; ?>">Change Image (optional):</label>
                        <input type="file" id="issue_image-<?php echo $issue['id']; ?>" name="issue_image" accept="image/*">
                        <small style="color: #666;">JPG/PNG, max 5MB</small>

                        <button type="submit" class="btn-submit">Save Changes</button>
                    </form>

                    <form class="delete-form" action="../../Controller/CitizenUploadsController.php" method="POST"
                        style="display: inline;">
                        <input type="hidden" name="delete_issue" value="1">
                        <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                        <button type="submit" class="btn-delete" onclick="return confirm('Delete this incident?')">Delete
                            Incident</button>
                    </form>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="status-message"
                style="padding: 15px; background: #e3f2fd; border-radius: 6px; color: #0277bd; text-align: center;">
                <p>No incidents uploaded yet. <a href="citizen_new_incident.php"
                        style="color: #0277bd; font-weight: bold;">Submit your first incident</a></p>
            </div>
        <?php } ?>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
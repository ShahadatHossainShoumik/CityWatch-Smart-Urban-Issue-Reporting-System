<?php
session_start();
require_once('../../Model/IssueModel.php');

// Verify admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../View/login.php");
    exit();
}
// Fetch all issues
$issues = getAllIssuesForAdmin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Incidents - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_incidents.css">
</head>

<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php" class="active">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <?php if (isset($_SESSION['msg'])) { ?>
            <div style="padding: 15px; margin-bottom: 20px; background-color: #4CAF50; color: white; border-radius: 5px;">
                <?php echo $_SESSION['msg']; ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php } ?>

        <h2>Manage Incidents</h2>
        <button onclick="toggleAddForm()" class="btn"
            style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer; margin-bottom: 20px;">+
            Add Incident</button>

        <div id="add-incident-form" class="form-container"
            style="display:none; margin-bottom: 30px; padding: 20px; background-color: #f5f5f5; border-radius: 5px; max-width: 600px;">
            <h3>Add New Incident</h3>
            <form action="../../Controller/AdminController.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_incident">

                <label for="add-title">Title:</label>
                <input type="text" id="add-title" name="title" required
                    style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box;">

                <label for="add-location">Location:</label>
                <input type="text" id="add-location" name="location" required
                    style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box;">

                <label for="add-description">Description:</label>
                <textarea id="add-description" name="description" rows="5" required
                    style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box; font-family: Arial, sans-serif;"></textarea>

                <label for="add-image">Image (Optional):</label>
                <input type="file" id="add-image" name="issue_image" accept="image/*"
                    style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; box-sizing: border-box;">

                <button type="submit" class="btn-submit"
                    style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer; margin-right: 10px;">Create
                    Incident</button>
                <button type="button" class="btn-cancel" onclick="closeAddForm()"
                    style="padding: 10px 20px; background-color: #757575; color: white; border: none; border-radius: 3px; cursor: pointer;">Cancel</button>
            </form>
        </div>
        <!--table of incidents-->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Title</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Posted By</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Location</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Status</th>
                    <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($issues && mysqli_num_rows($issues) > 0) { ?>
                    <?php while ($row = mysqli_fetch_assoc($issues)) { ?>
                        <tr style="border: 1px solid #ddd;">
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                                <small><?php echo htmlspecialchars(substr($row['description'], 0, 50)) . '...'; ?></small>
                            </td>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <?php echo htmlspecialchars($row['location']); ?>
                            </td>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <form action="../../Controller/AdminController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="update_incident_status">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <select name="status" onchange="this.form.submit()"
                                        style="padding: 5px; border-radius: 3px;">
                                        <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>
                                            Pending</option>
                                        <option value="reviewed" <?php echo ($row['status'] == 'reviewed') ? 'selected' : ''; ?>>
                                            Reviewed</option>
                                        <option value="resolved" <?php echo ($row['status'] == 'resolved') ? 'selected' : ''; ?>>
                                            Resolved</option>
                                    </select>
                                </form>
                            </td>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <form action="../../Controller/AdminController.php" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Delete this incident?');">
                                    <input type="hidden" name="action" value="delete_incident">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn-delete"
                                        style="padding: 8px 12px; background-color: #f44336; color: white; border: none; border-radius: 3px; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" style="padding: 12px; text-align: center; border: 1px solid #ddd;">No incidents
                            found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        function toggleAddForm() {
            const form = document.getElementById('add-incident-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function closeAddForm() {
            document.getElementById('add-incident-form').style.display = 'none';
        }
    </script>

</body>

</html>
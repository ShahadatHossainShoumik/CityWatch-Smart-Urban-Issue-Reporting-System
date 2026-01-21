<?php
session_start();
require_once('../../Model/IssueModel.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

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
                                    <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 3px;">
                                        <option value="pending" <?php echo ($row['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                        <option value="reviewed" <?php echo ($row['status'] == 'reviewed') ? 'selected' : ''; ?>>Reviewed</option>
                                        <option value="resolved" <?php echo ($row['status'] == 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                                    </select>
                                </form>
                            </td>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                <form action="../../Controller/AdminController.php" method="POST" style="display:inline;" onsubmit="return confirm('Delete this incident?');">
                                    <input type="hidden" name="action" value="delete_incident">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn-delete" style="padding: 8px 12px; background-color: #f44336; color: white; border: none; border-radius: 3px; cursor: pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" style="padding: 12px; text-align: center; border: 1px solid #ddd;">No incidents found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
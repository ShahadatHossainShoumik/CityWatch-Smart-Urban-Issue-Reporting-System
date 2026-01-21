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
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Issues</h2>

        <?php if ($issues && mysqli_num_rows($issues) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($issues)) { ?>

                <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                    <h3>
                        <?php echo $row['title']; ?>
                    </h3>
                    <p><b>Posted by:</b>
                        <?php echo $row['name']; ?>
                    </p>
                    <p><b>Location:</b>
                        <?php echo $row['location']; ?>
                    </p>
                    <p>
                        <?php echo $row['description']; ?>
                    </p>
                    <p><b>Status:</b>
                        <?php echo $row['status']; ?>
                    </p>

                    <?php if (!empty($row['image'])) { ?>
                        <img src="../../Images/<?php echo $row['image']; ?>" width="200">
                    <?php } ?>

                    <br><br>

                    <?php if ($row['status'] === 'pending') { ?>
                        <a href="../../Controller/IssueController.php?issue_id=<?php echo $row['id']; ?>&action=approve">
                            Approve
                        </a>
                        |
                        <a href="../../Controller/IssueController.php?issue_id=<?php echo $row['id']; ?>&action=reject">
                            Reject
                        </a>
                    <?php } ?>
                </div>

            <?php } ?>
        <?php } else { ?>
            <p>No issues found</p>
        <?php } ?>


        <div class="incident-feed">

            <div class="incident-card">
                <h3>Damaged Road</h3>
                <p><strong>Posted by:</strong></p>
                <p><strong>Location:</strong>Kuril</p>
                <p></p>

                <p><strong>Review Status:</strong> <span class="status-pending"></span></p>

                <div class="incident-images">
                    <img src="../images/image1.jpg" class="incident-image" alt="Incident Image">
                </div>

                <button class="btn-delete" onclick="confirmDelete()">Delete Incident</button>
            </div>

            <div class="incident-card">
                <h3>Broken Streetlight</h3>
                <p><strong>Posted by:</strong></p>
                <p><strong>Location:</strong></p>
                <p></p>

                <p><strong>Review Status:</strong> <span class="status-reviewed"></span></p>

                <div class="incident-images">
                    <img src="../images/image2.jpg" class="incident-image" alt="Incident Image">
                </div>

                <button class="btn-delete" onclick="confirmDelete()">Delete Incident</button>
            </div>

        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        function confirmDelete() {
            // complete it
        }
    </script>

</body>

</html>
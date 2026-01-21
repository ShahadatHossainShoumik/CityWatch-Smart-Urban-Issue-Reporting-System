<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Incident - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_incidents.css">
    <link rel="stylesheet" href="manage_citizen.css">
    <link rel="stylesheet" href="update_incident.css">
</head>
<body>

    <?php
    session_start();
    require_once '../../Model/IssueModel.php';

    // Check admin
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header("Location: ../login.php");
        exit();
    }

    $incident = null;
    $searchTerm = '';

    // Get incident by ID if provided
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $incident = getIssueByIdForAdmin($id);
    } elseif(isset($_GET['search']) && !empty($_GET['search'])){
        $searchTerm = $_GET['search'];
        // Search by title
        $result = getAllIssuesForAdmin();
        $allIncidents = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach($allIncidents as $inc){
            if(stripos($inc['title'], $searchTerm) !== false){
                $incident = $inc;
                break;
            }
        }
        if(!$incident){
            $noResult = "No incident found with that title";
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
        <h2>Update Incident</h2>
        <p class="subtitle">Search and modify incident details.</p>

        <form action="update_incident.php" method="GET" class="search-form" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Search by title..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
            <button type="submit">Search</button>
        </form>

        <?php if(isset($noResult)): ?>
            <div style="padding: 15px; margin-bottom: 20px; background-color: #ff9800; color: white; border-radius: 5px;">
                <?php echo $noResult; ?>
            </div>
        <?php endif; ?>

        <?php if($incident): ?>
            <form action="../../Controller/AdminController.php" method="POST" class="update-incident-form" style="max-width: 600px; margin: 0 auto; enctype='multipart/form-data';">
                <input type="hidden" name="action" value="edit_incident">
                <input type="hidden" name="id" value="<?php echo $incident['id']; ?>">

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($incident['title']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($incident['location']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="5" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; font-family: Arial, sans-serif;"><?php echo htmlspecialchars($incident['description']); ?></textarea>

                <label for="status">Status:</label>
                <select id="status" name="status" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">
                    <option value="pending" <?php echo ($incident['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="reviewed" <?php echo ($incident['status'] == 'reviewed') ? 'selected' : ''; ?>>Reviewed</option>
                    <option value="resolved" <?php echo ($incident['status'] == 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                </select>

                <button type="submit" style="padding: 10px 20px; background-color: #2196F3; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 14px;">Update Incident</button>
                <a href="manage_incidents.php" style="display: inline-block; margin-left: 10px; padding: 10px 20px; background-color: #757575; color: white; text-decoration: none; border-radius: 3px;">Cancel</a>
            </form>
        <?php else: ?>
            <div style="padding: 20px; text-align: center; background-color: #f5f5f5; border-radius: 5px;">
                <p>Search for an incident to update its details</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
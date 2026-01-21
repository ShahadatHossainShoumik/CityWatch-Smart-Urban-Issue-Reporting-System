<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

    <?php
    session_start();
    require_once '../../Model/AdminModel.php';

    // Get dashboard statistics
    $stats = getDashboardStats();
    ?>

    <div class="logout-btn-container">
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="content">
        <h2>Welcome, Admin!</h2>

        <div class="dashboard-analytics">
            <div class="analytics-box">
                <h4>Total Users</h4>
                <p><?php echo $stats['totalUsers']; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Total Incidents</h4>
                <p><?php echo $stats['totalIncidents']; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Resolved Incidents</h4>
                <p><?php echo $stats['resolvedIncidents']; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Fake Incidents</h4>
                <p><?php echo $stats['fakeIncidents']; ?></p>
            </div>
            <div class="analytics-box">
                <h4>Active Announcements</h4>
                <p><?php echo $stats['activeAnnouncements']; ?></p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h4>Citizens</h4>
                <p><?php echo $stats['citizens']; ?></p>
            </div>
            <div class="stat-card">
                <h4>Authorities</h4>
                <p><?php echo $stats['authorities']; ?></p>
            </div>
            <div class="stat-card">
                <h4>Admins</h4>
                <p><?php echo $stats['admins']; ?></p>
            </div>
        </div>

        <div class="quick-actions">
            <h3>Quick Actions</h3>
            <div class="actions-grid">
                <a href="manage_citizen.php" class="btn-action"> Manage Citizens</a>
                <a href="manage_authority.php" class="btn-action">Manage Authority</a>
                <a href="manage_admin.php" class="btn-action"> Manage Admin </a>
                <a href="manage_incidents.php" class="btn-action">Manage Incidents</a>
                <a href="manage_announcement.php" class="btn-action">Manage Announcements</a>
                <a href="fake_reports.php" class="btn-action"> Fake Incident Management </a>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
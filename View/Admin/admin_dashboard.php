<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css?v=4">
</head>

<body>

    <?php
    session_start();
    require_once '../../Model/AdminModel.php';

    // Get dashboard statistics for display
    $stats = getDashboardStats();
    $resolvedRate = ($stats['totalIncidents'] > 0) ? round(($stats['resolvedIncidents'] / $stats['totalIncidents']) * 100) : 0;
    $fakeRate = ($stats['totalIncidents'] > 0) ? round(($stats['fakeIncidents'] / $stats['totalIncidents']) * 100) : 0;
    ?>

    <div class="layout">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">CW</div>
                <div>
                    <p class="brand-title">CityWatch</p>
                    <p class="brand-sub">Admin Console</p>
                </div>
            </div>
            <nav class="nav">
                <a href="admin_dashboard.php" class="nav-item active">Overview</a>
                <a href="manage_citizen.php" class="nav-item">Manage Citizens</a>
                <a href="manage_authority.php" class="nav-item">Manage Authorities</a>
                <a href="manage_admin.php" class="nav-item">Manage Admins</a>
                <a href="manage_incidents.php" class="nav-item">Manage Incidents</a>
                <a href="manage_announcement.php" class="nav-item">Manage Announcements</a>
                <a href="fake_reports.php" class="nav-item">Fake Reports</a>
                <a href="logout.php" class="nav-item danger">Logout</a>
            </nav>
        </aside>

        <main class="main">
            <header class="topbar">
                <div>
                    <h1>Welcome back, Admin</h1>
                </div>
                <div class="top-actions">
                    <a class="ghost" href="manage_incidents.php">View incidents</a>
                    <a class="primary" href="logout.php">Logout</a>
                </div>
            </header>

            <section class="kpi-grid">
                <div class="kpi-card">
                    <p class="label">Total Users</p>
                    <p class="value"><?php echo $stats['totalUsers']; ?></p>
                    <p class="hint">Citizens, authorities, and admins</p>
                </div>
                <div class="kpi-card">
                    <p class="label">Total Incidents</p>
                    <p class="value"><?php echo $stats['totalIncidents']; ?></p>
                    <p class="hint">Reported across the city</p>
                </div>
                <div class="kpi-card">
                    <p class="label">Resolved Incidents</p>
                    <p class="value"><?php echo $stats['resolvedIncidents']; ?></p>
                    <div class="progress"><span style="width: <?php echo $resolvedRate; ?>%"></span></div>
                    <p class="hint"><?php echo $resolvedRate; ?>% of total</p>
                </div>
                <div class="kpi-card alert">
                    <p class="label">Fake Incidents</p>
                    <p class="value"><?php echo $stats['fakeIncidents']; ?></p>
                    <div class="progress danger"><span style="width: <?php echo $fakeRate; ?>%"></span></div>
                    <p class="hint"><?php echo $fakeRate; ?>% of total</p>
                </div>
                <div class="kpi-card">
                    <p class="label">Active Announcements</p>
                    <p class="value"><?php echo $stats['activeAnnouncements']; ?></p>
                    <p class="hint">City-wide communications</p>
                </div>
            </section>

            <section class="roles-grid">
                <div class="role-card">
                    <p class="label">Citizens</p>
                    <p class="value"><?php echo $stats['citizens']; ?></p>
                    <p class="hint">Service recipients</p>
                </div>
                <div class="role-card">
                    <p class="label">Authorities</p>
                    <p class="value"><?php echo $stats['authorities']; ?></p>
                    <p class="hint">Issue handlers</p>
                </div>
                <div class="role-card">
                    <p class="label">Admins</p>
                    <p class="value"><?php echo $stats['admins']; ?></p>
                    <p class="hint">System stewards</p>
                </div>
            </section>

            <section class="actions-panel">
                <div class="panel-head">
                    <div>
                        <h3>Jump into key areas</h3>
                    </div>
                </div>
                <div class="actions-grid">
                    <a href="manage_citizen.php" class="action-card">
                        <div class="pill">People</div>
                        <h4>Manage Citizens</h4>
                        <p>Review, add, or update citizen records.</p>
                    </a>
                    <a href="manage_authority.php" class="action-card">
                        <div class="pill">Operations</div>
                        <h4>Manage Authorities</h4>
                        <p>Maintain responders and agency accounts.</p>
                    </a>
                    <a href="manage_admin.php" class="action-card">
                        <div class="pill">Access</div>
                        <h4>Manage Admins</h4>
                        <p>Control privileges and oversight roles.</p>
                    </a>
                    <a href="manage_incidents.php" class="action-card">
                        <div class="pill">Incidents</div>
                        <h4>Manage Incidents</h4>
                        <p>Track, resolve, and flag submissions.</p>
                    </a>
                    <a href="manage_announcement.php" class="action-card">
                        <div class="pill">Announcements</div>
                        <h4>Manage Announcements</h4>
                        <p>Publish updates across the city.</p>
                    </a>
                    <a href="fake_reports.php" class="action-card danger">
                        <div class="pill danger">Abuse</div>
                        <h4>Fake Reports</h4>
                        <p>Block repeat offenders and keep data clean.</p>
                    </a>
                </div>
            </section>
        </main>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
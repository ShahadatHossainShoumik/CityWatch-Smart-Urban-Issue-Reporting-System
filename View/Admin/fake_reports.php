<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fake Citizens - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="fake_reports.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php" class="active">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Fake Reports</h2>
        <p class="subtitle">Identify and block users submitting false incidents.</p>

        <div class="search-container">
            <form action="#" class="search-form">
                <input type="text" name="search" placeholder="Search by email..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>email1</td>
                    <td class="status active">Active</td>
                    <td>
                        <button class="btn btn-block"">Block</button>
                    </td>
                </tr>

                <tr>
                    <td>email2</td>
                    <td class="status blocked">Blocked</td>
                    <td>
                        <button class="btn btn-unblock">Unblock</button>
                    </td>
                </tr>

                <tr>
                    <td>email3</td>
                    <td class="status active">Active</td>
                    <td>
                        <button class="btn btn-block"">Block</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
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
        <h2>Manage Incidents</h2>
        <p class="subtitle">Review, monitor, and manage reported incidents.</p>

        <div class="top-bar">
            <form action="#" class="search-form">
                <input type="text" name="search" placeholder="Search by location or title...">
                <select name="filter">
                    <option value="latest">Latest</option>
                    <option value="upvotes">Most Upvoted</option>
                    <option value="downvotes">Most Downvoted</option>
                </select>
                <button type="submit">Apply</button>
            </form>
        </div>

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
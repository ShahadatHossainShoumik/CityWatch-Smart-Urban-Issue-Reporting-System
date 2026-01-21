<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Announcements - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="authority_all_announcement.css">
</head>

<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="authority_dashboard.php">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php">New Announcement</a></li>
            <li><a href="all_announcements.php" class="active">All Announcements</a></li>
            <li><a href="authority_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>All Announcements</h2>

        <form action="#" class="filter-form">
            <label for="filter">Filter by Status:</label>
            <select name="filter" id="filter">
                <option value="all">All</option>
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </form>

        <div class="announcement-list">

            <div class="announcement-card">
                <form action="#" class="announcement-form">
                    <input type="hidden" name="announcement_id" value="1">

                    <label for="title-1">Title:</label>
                    <input type="text" id="title-1" name="title" value="" required>

                    <label for="description-1">Description:</label>
                    <textarea id="description-1" name="description" rows="3" required></textarea>

                    <label for="status-1">Status:</label>
                    <select name="status" id="status-1">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <div class="button-group">
                        <button type="button" class="btn-save">Save Changes</button>
                        <button type="button" class="btn-delete">Delete</button>
                    </div>
                </form>
            </div>

            <div class="announcement-card">
                <form action="#" class="announcement-form">
                    <input type="hidden" name="announcement_id" value="2">

                    <label for="title-2">Title:</label>
                    <input type="text" id="title-2" name="title" value="" required>

                    <label for="description-2">Description:</label>
                    <textarea id="description-2" name="description" rows="3" required></textarea>

                    <label for="status-2">Status:</label>
                    <select name="status" id="status-2">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                    <div class="button-group">
                        <button type="button" class="btn-save">Save Changes</button>
                        <button type="button" class="btn-delete">Delete</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
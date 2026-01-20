<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_admin.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php" class="active">Manage Admin</a></li>
            <li><a href="update_admin.php">Update Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Admins</h2>
        <p class="subtitle">Add or remove administrative users.</p>

        <div class="search-container">
            <form action="#" class="search-form">
                <input type="text" name="search" placeholder="Search by email..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <button class="btn btn-add" id="add-admin-btn" onclick="toggleAddAdminForm()">+ Add New Admin</button>

        <div id="add-admin-form" class="form-container" style="display:none;">
            <h3>Register New Admin</h3>
            <form action="#">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="admin@citywatch.com" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="********" required>

                <button type="submit" class="btn-submit">Save Admin</button>
                <button type="button" class="btn-cancel" onclick="toggleAddAdminForm()">Cancel</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>shahadat_hossain@citywatch.com</td>
                    <td>
                        <span class="status-disabled">Cannot Delete</span>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button class="btn btn-delete" onclick="confirmDelete()">Delete</button>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <button class="btn btn-delete" onclick="confirmDelete()">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        // Toggle the add admin form
        function toggleAddAdminForm() {
            const form = document.getElementById('add-admin-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
        
        function confirmDelete() {
            if(confirm('Are you sure you want to delete this admin?')) {
                alert('Admin deleted successfully (Demo)');
            }
        }
    </script>

</body>
</html>
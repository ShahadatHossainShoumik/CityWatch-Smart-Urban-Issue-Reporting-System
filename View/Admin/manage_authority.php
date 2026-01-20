<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authority - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_citizen.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php" class="active">Manage Authority</a></li>
            <li><a href="update_authority.php">Update Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Authorities</h2>
        <p class="subtitle">Register and manage municipal authority accounts.</p>

        <div class="search-container">
            <form action="#" class="search-form">
                <input type="text" name="search" placeholder="Search by email..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <button class="btn btn-add" id="add-authority-btn" onclick="toggleAddAuthorityForm()">+ Add New Authority</button>

        <div id="add-authority-form" class="form-container" style="display:none;">
            <h3>Register New Authority</h3>
            <form action="#">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="authoity" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="********" required>
                
                <label for="department">Department:</label>
                <select id="department" name="department">
                    <option value="Roads">Roads & Highways</option>
                    <option value="Waste">Waste Management</option>
                    <option value="Water">Water Supply</option>
                    <option value="Electrical">Electrical Grid</option>
                </select>

                <button type="submit" class="btn-submit">Save Authority</button>
                <button type="button" class="btn-cancel" onclick="toggleAddAuthorityForm()">Cancel</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="btn btn-delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        // JavaScript function to toggle the add authority form
        function toggleAddAuthorityForm() {
            const form = document.getElementById('add-authority-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        
        function confirmDelete() {
            // finish it
        }
    </script>

</body>
</html>
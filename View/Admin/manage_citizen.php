<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Citizen - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css"> 
    <link rel="stylesheet" href="manage_citizen.css"> 
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php" class="active">Manage Citizen</a></li>
            <li><a href="update_citizen.php">Update Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Citizens</h2>
        <p class="subtitle">View, add, or remove registered citizens.</p>

        <div class="search-container">
            <form action="#" class="search-form">
                <input type="text" name="search" placeholder="Search by email or name..." required>
                <button type="submit">Search</button>
            </form>
        </div>

        <button class="btn btn-add" id="add-citizen-btn" onclick="toggleAddCitizenForm()">+ Add New Citizen</button>

        <div id="add-citizen-form" class="form-container" style="display:none;">
            <h3>Register New Citizen</h3>
            <form action="#">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Shahadat Hosain" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="mobile">Mobile:</label>
                <input type="text" id="mobile" name="mobile" placeholder="017xxxxxxxx" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="shahadat@example.com" required>

                <label for="nid">NID:</label>
                <input type="text" id="nid" name="nid" placeholder="National ID Number" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="********" required>

                <button type="submit" class="btn-submit">Save Citizen</button>
                <button type="button" class="btn-cancel" onclick="toggleAddCitizenForm()">Cancel</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>NID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="btn btn-delete" onclick="confirmDelete()">Delete</button>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="btn btn-delete" onclick="confirmDelete()">Delete</button>
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
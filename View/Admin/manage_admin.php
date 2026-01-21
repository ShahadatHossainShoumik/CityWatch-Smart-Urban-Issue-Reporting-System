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

    <?php
    session_start();
    require_once '../../Model/AdminModel.php';

    // Check admin
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        header("Location: ../login.php");
        exit();
    }

    // Get all admins
    $admins = getUsersByRole('admin');
    $searchTerm = '';
    if(isset($_GET['search']) && !empty($_GET['search'])){
        $searchTerm = $_GET['search'];
        $admins = array_filter($admins, function($admin) use ($searchTerm){
            return stripos($admin['email'], $searchTerm) !== false || stripos($admin['name'], $searchTerm) !== false;
        });
    }
    ?>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php" class="active">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Admins</h2>
        <p class="subtitle">Add or remove administrative users.</p>

        <?php if(isset($_SESSION['msg'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="search-container">
            <form action="manage_admin.php" class="search-form" method="GET">
                <input type="text" name="search" placeholder="Search by email or name..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <button class="btn btn-add" id="add-admin-btn" onclick="toggleAddAdminForm()">+ Add New Admin</button>

        <div id="add-admin-form" class="form-container" style="display:none;">
            <h3>Register New Admin</h3>
            <form action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="add_admin">
                
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Admin Name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="admin@example.com" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <button type="submit" class="btn-submit">Save Admin</button>
                <button type="button" class="btn-cancel" onclick="toggleAddAdminForm()">Cancel</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($admins) > 0): ?>
                    <?php foreach($admins as $admin): ?>
                        <tr data-id="<?php echo $admin['id']; ?>">
                            <td><?php echo htmlspecialchars($admin['name']); ?></td>
                            <td><?php echo htmlspecialchars($admin['email']); ?></td>
                            <td><?php echo htmlspecialchars($admin['role']); ?></td>
                            <td>
                                <button class="btn btn-edit" onclick="editAdmin(<?php echo $admin['id']; ?>, '<?php echo htmlspecialchars($admin['name']); ?>', '<?php echo htmlspecialchars($admin['email']); ?>', '<?php echo htmlspecialchars($admin['mobile'] ?? ''); ?>', '<?php echo htmlspecialchars($admin['dob'] ?? ''); ?>', '<?php echo htmlspecialchars($admin['nid'] ?? ''); ?>')">Edit</button>
                                <button class="btn btn-delete" onclick="ajaxDelete(<?php echo $admin['id']; ?>, 'delete_admin', '.content table')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No admins found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div id="edit-admin-form" class="form-container" style="display:none;">
            <h3>Edit Admin</h3>
            <form action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="edit_admin">
                <input type="hidden" name="id" id="edit-id">
                
                <label for="edit-name">Full Name:</label>
                <input type="text" id="edit-name" name="name" required>

                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email" name="email" required>

                <label for="edit-mobile">Mobile Number:</label>
                <input type="text" id="edit-mobile" name="mobile">

                <label for="edit-dob">Date of Birth:</label>
                <input type="date" id="edit-dob" name="dob">

                <label for="edit-nid">NID (National ID):</label>
                <input type="text" id="edit-nid" name="nid">

                <button type="submit" class="btn-submit">Update Admin</button>
                <button type="button" class="btn-cancel" onclick="closeEditForm()">Cancel</button>
            </form>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        function toggleAddAdminForm(){
            const form = document.getElementById('add-admin-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function editAdmin(id, name, email, mobile, dob, nid){
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-mobile').value = mobile;
            document.getElementById('edit-dob').value = dob;
            document.getElementById('edit-nid').value = nid;
            document.getElementById('edit-admin-form').style.display = 'block';
        }

        function closeEditForm(){
            document.getElementById('edit-admin-form').style.display = 'none';
        }

        // Handle edit form AJAX submission
        document.getElementById('edit-admin-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            ajaxSubmitEditForm('edit-admin-form', 'edit_admin');
        });

        // Handle add form AJAX submission
        document.getElementById('add-admin-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            ajaxSubmitAddForm('add-admin-form', 'add_admin');
        });
    </script>
    <script src="ajax-helper.js"></script>
    <script src="prefs-helper.js"></script>

</body>
</html>
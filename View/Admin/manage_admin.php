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
    if (! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../../View/login.php");
        exit();
    }

    // Get all admins
    $admins = getUsersByRole('admin');
    $searchTerm = '';
    if (isset($_GET['search']) && ! empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $admins = array_filter($admins, function($admin) use ($searchTerm) {
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
            <form id="add-admin-form-element" action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="add_admin">
                
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Admin Name" required onblur="validateAdminName()">
                <span id="adminNameMessage" style="color: red; font-size: 12px;"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="admin@example.com" required>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" placeholder="01XXXXXXXXX" onblur="validateAdminMobile()">
                <span id="adminMobileMessage" style="color: red; font-size: 12px;"></span>

                <label for="nid">NID (National ID):</label>
                <input type="text" id="nid" name="nid" placeholder="10-digit NID" onblur="validateAdminNid()">
                <span id="adminNidMessage" style="color: red; font-size: 12px;"></span>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required onkeyup="validateAdminPassword()">
                <span id="adminPasswordMessage" style="font-size: 12px;"></span>

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
                <?php if (count($admins) > 0): ?>
                    <?php foreach ($admins as $admin): ?>
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
            <form id="edit-admin-form-element" action="../../Controller/AdminController.php" method="POST">
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
        document.getElementById('edit-admin-form-element')?.addEventListener('submit', function(e) {
            e.preventDefault();
            ajaxSubmitEditForm('edit-admin-form-element', 'edit_admin');
        });

        // Handle add form AJAX submission with validation
        document.getElementById('add-admin-form-element')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const okName = validateAdminName();
            const okMobile = validateAdminMobile();
            const okNid = validateAdminNid();
            const okPass = validateAdminPassword();
            if (okName && okMobile && okNid && okPass) {
                ajaxSubmitAddForm('add-admin-form-element', 'add_admin');
            } else {
                showNotification('Please fix validation errors before submitting', 'error');
            }
        });

        // Validation helpers for admin add form
        function validateAdminName() {
            const name = document.getElementById('name').value;
            const message = document.getElementById('adminNameMessage');
            const regexName = /^[a-zA-Z\s]+$/;
            if (name && !regexName.test(name)) {
                message.innerHTML = 'Name should only contain letters and spaces.';
                return false;
            }
            message.innerHTML = '';
            return true;
        }

        function validateAdminMobile() {
            const mobile = document.getElementById('phone').value;
            const message = document.getElementById('adminMobileMessage');
            const regexMobile = /^\d{11}$/;
            if (mobile && !regexMobile.test(mobile)) {
                message.innerHTML = 'Mobile number must be exactly 11 digits.';
                return false;
            }
            message.innerHTML = '';
            return true;
        }

        function validateAdminNid() {
            const nid = document.getElementById('nid').value;
            const message = document.getElementById('adminNidMessage');
            const regexNid = /^\d{10}$/;
            if (nid && !regexNid.test(nid)) {
                message.innerHTML = 'NID must be exactly 10 digits.';
                return false;
            }
            message.innerHTML = '';
            return true;
        }

        function validateAdminPassword() {
            const password = document.getElementById('password').value;
            const message = document.getElementById('adminPasswordMessage');
            const regexWeak = /^[a-zA-Z0-9]{6,12}$/;
            const regexStrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/;
            if (password.match(regexStrong)) {
                message.innerHTML = 'Password is strong.';
                message.style.color = 'green';
                return true;
            } else if (password.match(regexWeak)) {
                message.innerHTML = 'Password is weak.';
                message.style.color = 'orange';
                return true;
            } else if (password) {
                message.innerHTML = 'Password should be 8-20 chars with upper, lower, and numbers.';
                message.style.color = 'red';
                return false;
            }
            message.innerHTML = '';
            return true;
        }
    </script>
    <script src="../../Controller/ajax.js"></script>

</body>
</html>
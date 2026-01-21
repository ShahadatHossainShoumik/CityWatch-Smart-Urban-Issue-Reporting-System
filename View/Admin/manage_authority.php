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

    <?php

    session_start();
    require_once '../../Model/AdminModel.php';

    // Check admin
    if (! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }

    // Get all authorities
    $authorities = getUsersByRole('authority');
    $searchTerm = '';
    if (isset($_GET['search']) && ! empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $authorities = array_filter($authorities, function($authority) use ($searchTerm) {
            return stripos($authority['email'], $searchTerm) !== false || stripos($authority['name'], $searchTerm) !== false;
        });
    }
    ?>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php" class="active">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Authorities</h2>
        <p class="subtitle">Register and manage municipal authority accounts.</p>
        
        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="search-container">
            <form action="manage_authority.php" class="search-form" method="GET">
                <input type="text" name="search" placeholder="Search by email or name..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <button class="btn btn-add" id="add-authority-btn" onclick="toggleAddAuthorityForm()">+ Add New Authority</button>

        <div id="add-authority-form" class="form-container" style="display:none;">
            <h3>Register New Authority</h3>
            <form id="add-authority-form-element" action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="add_authority">
                
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Authority Name" required onblur="validateAuthorityName()">
                <span id="authorityNameMessage" style="color: red; font-size: 12px;"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="authority@example.com" required>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" placeholder="01XXXXXXXXX" onblur="validateAuthorityMobile()">
                <span id="authorityMobileMessage" style="color: red; font-size: 12px;"></span>

                <label for="nid">NID (National ID):</label>
                <input type="text" id="nid" name="nid" placeholder="10-digit NID" onblur="validateAuthorityNid()">
                <span id="authorityNidMessage" style="color: red; font-size: 12px;"></span>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required onkeyup="validateAuthorityPassword()">
                <span id="authorityPasswordMessage" style="font-size: 12px;"></span>

                <button type="submit" class="btn-submit">Save Authority</button>
                <button type="button" class="btn-cancel" onclick="toggleAddAuthorityForm()">Cancel</button>
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
                //get authorities
                <?php if (count($authorities) > 0): ?>
                    <?php foreach ($authorities as $authority): ?>
                        <tr data-id="<?php echo $authority['id']; ?>">
                            <td><?php echo htmlspecialchars($authority['name']); ?></td>
                            <td><?php echo htmlspecialchars($authority['email']); ?></td>
                            <td><?php echo htmlspecialchars($authority['role']); ?></td>
                            <td>
                                <button class="btn btn-edit" onclick="editAuthority(<?php echo $authority['id']; ?>, '<?php echo htmlspecialchars($authority['name']); ?>', '<?php echo htmlspecialchars($authority['email']); ?>', '<?php echo htmlspecialchars($authority['mobile'] ?? ''); ?>', '<?php echo htmlspecialchars($authority['dob'] ?? ''); ?>', '<?php echo htmlspecialchars($authority['nid'] ?? ''); ?>')">Edit</button>
                                <button class="btn btn-delete" onclick="ajaxDelete(<?php echo $authority['id']; ?>, 'delete_authority', '.content table')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No authorities found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
         
        <div id="edit-authority-form" class="form-container" style="display:none;">
            <h3>Edit Authority</h3>
            <form id="edit-authority-form-element" action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="edit_authority">
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

                <button type="submit" class="btn-submit">Update Authority</button>
                <button type="button" class="btn-cancel" onclick="closeEditForm()">Cancel</button>
            </form>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        function toggleAddAuthorityForm(){
            const form = document.getElementById('add-authority-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function editAuthority(id, name, email, mobile, dob, nid){
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-mobile').value = mobile;
            document.getElementById('edit-dob').value = dob;
            document.getElementById('edit-nid').value = nid;
            document.getElementById('edit-authority-form').style.display = 'block';
        }

        function closeEditForm(){
            document.getElementById('edit-authority-form').style.display = 'none';
        }

        // Handle edit form AJAX submission
        document.getElementById('edit-authority-form-element')?.addEventListener('submit', function(e) {
            e.preventDefault();
            ajaxSubmitEditForm('edit-authority-form-element', 'edit_authority');
        });

        // Handle add form AJAX submission with validation
        document.getElementById('add-authority-form-element')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const okName = validateAuthorityName();
            const okMobile = validateAuthorityMobile();
            const okNid = validateAuthorityNid();
            const okPass = validateAuthorityPassword();
            if (okName && okMobile && okNid && okPass) {
                ajaxSubmitAddForm('add-authority-form-element', 'add_authority');
            } else {
                showNotification('Please fix validation errors before submitting', 'error');
            }
        });

        // Validation helpers for authority add form
        function validateAuthorityName() {
            const name = document.getElementById('name').value;
            const message = document.getElementById('authorityNameMessage');
            const regexName = /^[a-zA-Z\s]+$/;
            if (name && !regexName.test(name)) {
                message.innerHTML = 'Name should only contain letters and spaces.';
                return false;
            }
            message.innerHTML = '';
            return true;
        }

        function validateAuthorityMobile() {
            const mobile = document.getElementById('phone').value;
            const message = document.getElementById('authorityMobileMessage');
            const regexMobile = /^\d{11}$/;
            if (mobile && !regexMobile.test(mobile)) {
                message.innerHTML = 'Mobile number must be exactly 11 digits.';
                return false;
            }
            message.innerHTML = '';
            return true;
        }

        function validateAuthorityNid() {
            const nid = document.getElementById('nid').value;
            const message = document.getElementById('authorityNidMessage');
            const regexNid = /^\d{10}$/;
            if (nid && !regexNid.test(nid)) {
                message.innerHTML = 'NID must be exactly 10 digits.';
                return false;
            }
            message.innerHTML = '';
            return true;
        }

        function validateAuthorityPassword() {
            const password = document.getElementById('password').value;
            const message = document.getElementById('authorityPasswordMessage');
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
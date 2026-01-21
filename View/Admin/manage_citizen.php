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

    <?php
    session_start();
    require_once '../../Model/AdminModel.php';

    // Verify admin access
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../../View/login.php");
        exit();
    }

    // Get all citizens
    $citizens = getUsersByRole('citizen');
    $searchTerm = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $citizens = array_filter($citizens, function ($citizen) use ($searchTerm) {
            return stripos($citizen['email'], $searchTerm) !== false || stripos($citizen['name'], $searchTerm) !== false;
        });
    }
    ?>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php" class="active">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Citizens</h2>
        <p class="subtitle">View, add, or remove registered citizens.</p>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['msg'];
                unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="search-container">
            <form action="manage_citizen.php" class="search-form" method="GET">
                <input type="text" name="search" placeholder="Search by email or name..."
                    value="<?php echo htmlspecialchars($searchTerm); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <button class="btn btn-add" id="add-citizen-btn" onclick="toggleAddCitizenForm()">+ Add New Citizen</button>

        <div id="add-citizen-form" class="form-container" style="display:none;">
            <h3>Register New Citizen</h3>
            <form id="add-citizen-form-element" action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="add_citizen">

                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Full Name" required
                    onblur="validateCitizenName()">
                <span id="nameMessage" style="color: red; font-size: 12px;"></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="email@example.com" required>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" placeholder="01XXXXXXXXX" onblur="validateCitizenMobile()">
                <span id="mobileMessage" style="color: red; font-size: 12px;"></span>

                <label for="nid">NID (National ID):</label>
                <input type="text" id="nid" name="nid" placeholder="10-digit NID" onblur="validateCitizenNid()">
                <span id="nidMessage" style="color: red; font-size: 12px;"></span>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required
                    onkeyup="validateCitizenPassword()">
                <span id="passwordMessage" style="font-size: 12px;"></span>

                <button type="submit" class="btn-submit">Save Citizen</button>
                <button type="button" class="btn-cancel" onclick="toggleAddCitizenForm()">Cancel</button>
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
                <?php if (count($citizens) > 0): ?>
                    <?php foreach ($citizens as $citizen): ?>
                        <tr data-id="<?php echo $citizen['id']; ?>">
                            <td><?php echo htmlspecialchars($citizen['name']); ?></td>
                            <td><?php echo htmlspecialchars($citizen['email']); ?></td>
                            <td><?php echo htmlspecialchars($citizen['role']); ?></td>
                            <td>
                                <button class="btn btn-edit"
                                    onclick="editCitizen(<?php echo $citizen['id']; ?>, '<?php echo htmlspecialchars($citizen['name']); ?>', '<?php echo htmlspecialchars($citizen['email']); ?>', '<?php echo htmlspecialchars($citizen['mobile'] ?? ''); ?>', '<?php echo htmlspecialchars($citizen['dob'] ?? ''); ?>', '<?php echo htmlspecialchars($citizen['nid'] ?? ''); ?>')">Edit</button>
                                <button class="btn btn-delete"
                                    onclick="ajaxDelete(<?php echo $citizen['id']; ?>, 'delete_citizen', '.content table')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No citizens found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div id="edit-citizen-form" class="form-container" style="display:none;">
            <h3>Edit Citizen</h3>
            <form id="edit-citizen-form-element" action="../../Controller/AdminController.php" method="POST">
                <input type="hidden" name="action" value="edit_citizen">
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

                <button type="submit" class="btn-submit">Update Citizen</button>
                <button type="button" class="btn-cancel" onclick="closeEditForm()">Cancel</button>
            </form>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        function toggleAddCitizenForm() {
            const form = document.getElementById('add-citizen-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        // Validation functions for add citizen form
        function validateCitizenName() {
            var name = document.getElementById("name").value;
            var message = document.getElementById("nameMessage");
            var regexName = /^[a-zA-Z\s]+$/;

            if (name && !regexName.test(name)) {
                message.innerHTML = "Name should only contain letters and spaces.";
                message.style.color = "red";
                return false;
            } else {
                message.innerHTML = "";
                return true;
            }
        }

        function validateCitizenMobile() {
            var mobile = document.getElementById("phone").value;
            var message = document.getElementById("mobileMessage");
            var regexMobile = /^\d{11}$/;

            if (mobile && !regexMobile.test(mobile)) {
                message.innerHTML = "Mobile number must be exactly 11 digits.";
                message.style.color = "red";
                return false;
            } else {
                message.innerHTML = "";
                return true;
            }
        }

        function validateCitizenNid() {
            var nid = document.getElementById("nid").value;
            var message = document.getElementById("nidMessage");
            var regexNid = /^\d{10}$/;

            if (nid && !regexNid.test(nid)) {
                message.innerHTML = "NID must be exactly 10 digits.";
                message.style.color = "red";
                return false;
            } else {
                message.innerHTML = "";
                return true;
            }
        }

        function validateCitizenPassword() {
            var password = document.getElementById("password").value;
            var message = document.getElementById("passwordMessage");
            var regexWeak = /^[a-zA-Z0-9]{6,12}$/;
            var regexStrong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,20}$/;

            if (password.match(regexStrong)) {
                message.innerHTML = "Password is strong.";
                message.style.color = "green";
                return true;
            } else if (password.match(regexWeak)) {
                message.innerHTML = "Password is weak.";
                message.style.color = "orange";
                return true;
            } else if (password) {
                message.innerHTML = "Password should be 8-20 characters with uppercase, lowercase, and numbers.";
                message.style.color = "red";
                return false;
            } else {
                message.innerHTML = "";
                return true;
            }
        }

        function validateAddCitizenForm() {
            var isNameValid = validateCitizenName();
            var isMobileValid = validateCitizenMobile();
            var isNidValid = validateCitizenNid();
            var isPasswordValid = validateCitizenPassword();

            return isNameValid && isMobileValid && isNidValid && isPasswordValid;
        }

        function editCitizen(id, name, email, mobile, dob, nid) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-mobile').value = mobile;
            document.getElementById('edit-dob').value = dob;
            document.getElementById('edit-nid').value = nid;
            document.getElementById('edit-citizen-form').style.display = 'block';
        }

        function closeEditForm() {
            document.getElementById('edit-citizen-form').style.display = 'none';
        }

        // Handle edit form AJAX submission
        document.getElementById('edit-citizen-form-element')?.addEventListener('submit', function (e) {
            e.preventDefault();
            ajaxSubmitEditForm('edit-citizen-form-element', 'edit_citizen');
        });

        // Handle add form AJAX submission with validation
        document.getElementById('add-citizen-form-element')?.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validate form first
            var isNameValid = validateCitizenName();
            var isMobileValid = validateCitizenMobile();
            var isNidValid = validateCitizenNid();
            var isPasswordValid = validateCitizenPassword();

            if (isNameValid && isMobileValid && isNidValid && isPasswordValid) {
                ajaxSubmitAddForm('add-citizen-form-element', 'add_citizen');
            } else {
                showNotification('Please fix validation errors before submitting', 'error');
            }
        });
    </script>
    <script src="../../Controller/ajax.js"></script>

</body>

</html>
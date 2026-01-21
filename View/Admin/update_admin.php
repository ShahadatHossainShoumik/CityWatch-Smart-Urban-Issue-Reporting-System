<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="manage_citizen.css"> 
    <link rel="stylesheet" href="update_admin.css">
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

    $admin = null;
    $searchTerm = '';

    // Get admin by ID if provided
    if(isset($_GET['id'])){
        $id = intval($_GET['id']);
        $admin = getUserById($id);
    } elseif(isset($_GET['search']) && !empty($_GET['search'])){
        $searchTerm = $_GET['search'];
        // Search by email
        $allAdmins = getUsersByRole('admin');
        foreach($allAdmins as $a){
            if(stripos($a['email'], $searchTerm) !== false || stripos($a['name'], $searchTerm) !== false){
                $admin = $a;
                break;
            }
        }
        if(!$admin){
            $noResult = "No admin found with that email or name";
        }
    }
    ?>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="manage_citizen.php">Manage Citizen</a></li>
            <li><a href="manage_authority.php">Manage Authority</a></li>
            <li><a href="manage_admin.php">Manage Admin</a></li>
            <li><a href="manage_incidents.php">Manage Incidents</a></li>
            <li><a href="manage_announcement.php">Manage Announcements</a></li>
            <li><a href="fake_reports.php">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Update Admin</h2>
        <p class="subtitle">Search and modify admin account details.</p>

        <form action="update_admin.php" method="GET" class="search-form" style="margin-bottom: 20px;">
            <input type="text" name="search" placeholder="Search by email or name..." value="<?php echo htmlspecialchars($searchTerm); ?>" required>
            <button type="submit">Search</button>
        </form>

        <?php if(isset($noResult)): ?>
            <div style="padding: 15px; margin-bottom: 20px; background-color: #ff9800; color: white; border-radius: 5px;">
                <?php echo $noResult; ?>
            </div>
        <?php endif; ?>

        <?php if($admin): ?>
            <form action="../../Controller/AdminController.php" method="POST" class="update-admin-form" style="max-width: 600px; margin: 0 auto;">
                <input type="hidden" name="action" value="edit_admin">
                <input type="hidden" name="id" value="<?php echo $admin['id']; ?>">

                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="mobile">Mobile Number:</label>
                <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($admin['mobile'] ?? ''); ?>" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($admin['dob'] ?? ''); ?>" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="nid">NID (National ID):</label>
                <input type="text" id="nid" name="nid" value="<?php echo htmlspecialchars($admin['nid'] ?? ''); ?>" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px;">

                <label for="role">Role:</label>
                <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($admin['role']); ?>" disabled style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 3px; background-color: #f5f5f5;">

                <button type="submit" style="padding: 10px 20px; background-color: #2196F3; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 14px;">Update Admin</button>
                <a href="manage_admin.php" style="display: inline-block; margin-left: 10px; padding: 10px 20px; background-color: #757575; color: white; text-decoration: none; border-radius: 3px;">Cancel</a>
            </form>
        <?php else: ?>
            <div style="padding: 20px; text-align: center; background-color: #f5f5f5; border-radius: 5px;">
                <p>Search for an admin to update their details</p>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
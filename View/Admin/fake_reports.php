<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fake Reports - CityWatch</title>
    <link rel="stylesheet" href="admin_dashboard.css">
    <link rel="stylesheet" href="fake_reports.css">
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

    // Get all users with their block status
    $users = getAllUsersWithStatus();
    $searchTerm = '';
    
    if(isset($_GET['search']) && !empty($_GET['search'])){
        $searchTerm = $_GET['search'];
        $users = array_filter($users, function($user) use ($searchTerm){
            return stripos($user['email'], $searchTerm) !== false || stripos($user['name'], $searchTerm) !== false;
        });
    }

    // Filter by status if provided
    $filterStatus = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    if($filterStatus === 'blocked'){
        $users = array_filter($users, function($user){
            return $user['is_blocked'] == 1;
        });
    } elseif($filterStatus === 'active'){
        $users = array_filter($users, function($user){
            return $user['is_blocked'] == 0;
        });
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
            <li><a href="fake_reports.php" class="active">Fake Reports</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Manage Fake Reports</h2>
        <p class="subtitle">Identify and block users submitting false incidents.</p>

        <?php if(isset($_SESSION['msg'])): ?>
            <div style="padding: 15px; margin-bottom: 20px; background-color: #4CAF50; color: white; border-radius: 5px;">
                <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
            </div>
        <?php endif; ?>

        <div class="search-container">
            <form action="fake_reports.php" class="search-form" method="GET">
                <input type="text" name="search" placeholder="Search by email or name..." value="<?php echo htmlspecialchars($searchTerm); ?>">
                <select name="filter" onchange="this.form.submit()" style="padding: 10px; border-radius: 3px;">
                    <option value="all" <?php echo ($filterStatus === 'all') ? 'selected' : ''; ?>>All Users</option>
                    <option value="active" <?php echo ($filterStatus === 'active') ? 'selected' : ''; ?>>Active Users</option>
                    <option value="blocked" <?php echo ($filterStatus === 'blocked') ? 'selected' : ''; ?>>Blocked Users</option>
                </select>
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($users) > 0): ?>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <?php if($user['is_blocked'] == 1): ?>
                                    <span class="status blocked" style="color: #f44336; font-weight: bold;">Blocked</span>
                                <?php else: ?>
                                    <span class="status active" style="color: #4CAF50; font-weight: bold;">Active</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($user['is_blocked'] == 1): ?>
                                    <form action="../../Controller/AdminController.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="unblock_user">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-unblock" style="padding: 8px 12px; background-color: #4CAF50; color: white; border: none; border-radius: 3px; cursor: pointer;">Unblock</button>
                                    </form>
                                <?php else: ?>
                                    <form action="../../Controller/AdminController.php" method="POST" style="display:inline;" onsubmit="return confirm('Block this user?');">
                                        <input type="hidden" name="action" value="block_user">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-block" style="padding: 8px 12px; background-color: #f44336; color: white; border: none; border-radius: 3px; cursor: pointer;">Block</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
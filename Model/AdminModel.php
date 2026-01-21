<?php
require_once 'db.php';

// Get all users
function getAllUsers()
{
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users";
    $result = mysqli_query($conn, $query);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    mysqli_close($conn);
    return $users;
}

// Get users by role
function getUsersByRole($role)
{
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users WHERE role = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $users;
}


// Create new user
function createUser($name, $email, $phone, $password, $role, $address, $nid = '')
{
    $conn = dbConnect();
    $query = "INSERT INTO users (name, email, mobile, nid, password, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssss', $name, $email, $phone, $nid, $password, $role);

    if (mysqli_stmt_execute($stmt)) {
        $id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $id;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return false;
}

// Update user
function updateUser($id, $name, $email, $mobile, $dob, $nid, $role)
{
    $conn = dbConnect();
    $query = "UPDATE users SET name = ?, email = ?, mobile = ?, dob = ?, nid = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssi', $name, $email, $mobile, $dob, $nid, $role, $id);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}

// Delete user
function deleteUser($id)
{
    $conn = dbConnect();
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}

// Get total users count
function getTotalUsersCount()
{
    $conn = dbConnect();
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['count'];
}

// Get total incidents count
function getTotalIncidentsCount()
{
    $conn = dbConnect();
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM issues");
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['count'];
}

// Get resolved incidents count
function getResolvedIncidentsCount()
{
    $conn = dbConnect();
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM issues WHERE status = 'resolved'");
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['count'];
}

// Get fake incidents count (marked with low votes)
function getFakeIncidentsCount()
{
    // Placeholder - fake column not in schema yet
    return 0;
}

// Get active announcements count
function getActiveAnnouncementsCount()
{
    $conn = dbConnect();
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM announcements");
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['count'];
}

// Get users count by role
function getUsersCountByRole($role)
{
    $conn = dbConnect();
    $query = "SELECT COUNT(*) as count FROM users WHERE role = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $role);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $row['count'];
}

// Get dashboard statistics
function getDashboardStats()
{
    return [
        'totalUsers' => getTotalUsersCount(),
        'totalIncidents' => getTotalIncidentsCount(),
        'resolvedIncidents' => getResolvedIncidentsCount(),
        'fakeIncidents' => getFakeIncidentsCount(),
        'activeAnnouncements' => getActiveAnnouncementsCount(),
        'citizens' => getUsersCountByRole('citizen'),
        'authorities' => getUsersCountByRole('authority'),
        'admins' => getUsersCountByRole('admin')
    ];
}

// Get blocked users
function getBlockedUsers()
{
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users WHERE is_blocked = 1";
    $result = mysqli_query($conn, $query);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    mysqli_close($conn);
    return $users;
}

// Get active users
function getActiveUsers()
{
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users WHERE is_blocked = 0 OR is_blocked IS NULL";
    $result = mysqli_query($conn, $query);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    mysqli_close($conn);
    return $users;
}

// Get all users with real block status
function getAllUsersWithStatus()
{
    $conn = dbConnect();
    $query = "SELECT id, name, email, role, COALESCE(is_blocked, 0) as is_blocked FROM users";
    $result = mysqli_query($conn, $query);

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    mysqli_close($conn);
    return $users;
}

// Block a user
function blockUser($id)
{
    $conn = dbConnect();
    $query = "UPDATE users SET is_blocked = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}

// Unblock a user
function unblockUser($id)
{
    $conn = dbConnect();
    $query = "UPDATE users SET is_blocked = 0 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}


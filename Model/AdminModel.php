<?php

require_once 'db.php';

// Get all users
function getAllUsers(){
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users";
    $result = $conn->query($query);
    
    $users = [];
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    
    return $users;
}

// Get users by role
function getUsersByRole($role){
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users WHERE role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $role);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $users = [];
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    
    return $users;
}

// Get user by ID
function getUserById($id){
    $conn = dbConnect();
    $query = "SELECT id, name, email, mobile, dob, nid, role FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        return $result->fetch_assoc();
    }
    
    return false;
}

// Create new user
function createUser($name, $email, $phone, $password, $role, $address){
    $conn = dbConnect();
    $query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $name, $email, $password, $role);
    
    if($stmt->execute()){
        return $conn->insert_id;
    }
    
    return false;
}

// Update user
function updateUser($id, $name, $email, $mobile, $dob, $nid, $role){
    $conn = dbConnect();
    $query = "UPDATE users SET name = ?, email = ?, mobile = ?, dob = ?, nid = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $name, $email, $mobile, $dob, $nid, $role, $id);
    
    return $stmt->execute();
}

// Delete user
function deleteUser($id){
    $conn = dbConnect();
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    
    return $stmt->execute();
}

// Get total users count
function getTotalUsersCount(){
    $conn = dbConnect();
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Get total incidents count
function getTotalIncidentsCount(){
    $conn = dbConnect();
    $result = $conn->query("SELECT COUNT(*) as count FROM issues");
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Get resolved incidents count
function getResolvedIncidentsCount(){
    $conn = dbConnect();
    $result = $conn->query("SELECT COUNT(*) as count FROM issues WHERE status = 'resolved'");
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Get fake incidents count (marked with low votes)
function getFakeIncidentsCount(){
    // Placeholder - fake column not in schema yet
    return 0;
}

// Get active announcements count
function getActiveAnnouncementsCount(){
    $conn = dbConnect();
    $result = $conn->query("SELECT COUNT(*) as count FROM announcements");
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Get users count by role
function getUsersCountByRole($role){
    $conn = dbConnect();
    $query = "SELECT COUNT(*) as count FROM users WHERE role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $role);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Get dashboard statistics
function getDashboardStats(){
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
function getBlockedUsers(){
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users WHERE is_blocked = 1";
    $result = $conn->query($query);
    
    $users = [];
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    
    return $users;
}

// Get active users
function getActiveUsers(){
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users WHERE is_blocked = 0 OR is_blocked IS NULL";
    $result = $conn->query($query);
    
    $users = [];
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    
    return $users;
}

// Get all users (without block status - column doesn't exist yet)
function getAllUsersWithStatus(){
    $conn = dbConnect();
    $query = "SELECT id, name, email, role FROM users";
    $result = $conn->query($query);
    
    $users = [];
    while($row = $result->fetch_assoc()){
        // Add a placeholder is_blocked status (always 0 for now)
        $row['is_blocked'] = 0;
        $users[] = $row;
    }
    
    return $users;
}

// Block a user
function blockUser($id){
    $conn = dbConnect();
    $query = "UPDATE users SET is_blocked = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}

// Unblock a user
function unblockUser($id){
    $conn = dbConnect();
    $query = "UPDATE users SET is_blocked = 0 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    return $stmt->execute();
}


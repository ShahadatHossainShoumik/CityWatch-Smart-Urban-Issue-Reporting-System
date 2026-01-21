<?php
require_once('db.php');

// Get all active announcements for citizens
function getAllAnnouncements(){
    $conn = dbConnect();
    
    $sql = "SELECT id, title, message as description, created_by as author_id, created_at FROM announcements ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    if(!$result){
        die("Query failed: " . $conn->error);
    }
    
    $announcements = [];
    while($row = $result->fetch_assoc()){
        $announcements[] = $row;
    }
    
    return $announcements;
}

// Get single announcement by ID
function getAnnouncementById($announcement_id){
    $conn = dbConnect();
    
    $sql = "SELECT id, title, message as description, created_by as author_id, created_at FROM announcements WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0){
        return $result->fetch_assoc();
    }
    
    return null;
}

// Create announcement (for admin/authority)
function createAnnouncement($title, $description, $author_id){
    $conn = dbConnect();
    
    $title = trim($title);
    $description = trim($description);
    
    if(empty($title) || empty($description)){
        return false;
    }
    
    $sql = "INSERT INTO announcements (title, message, created_by, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssi", $title, $description, $author_id);
    
    if($stmt->execute()){
        return $conn->insert_id;
    }
    
    return false;
}

// Update announcement (for admin/authority)
function updateAnnouncement($announcement_id, $author_id, $title, $description){
    $conn = dbConnect();
    
    $title = trim($title);
    $description = trim($description);
    
    if(empty($title) || empty($description)){
        return false;
    }
    
    // Verify ownership
    $sql = "SELECT id FROM announcements WHERE id = ? AND created_by = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $announcement_id, $author_id);
    $stmt->execute();
    
    if($stmt->get_result()->num_rows === 0){
        return false;
    }
    
    $sql = "UPDATE announcements SET title = ?, message = ? WHERE id = ? AND created_by = ?";
    $stmt = $conn->prepare($sql);
    
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssii", $title, $description, $announcement_id, $author_id);
    
    return $stmt->execute();
}

// Delete announcement (for admin)
function deleteAnnouncement($announcement_id){
    $conn = dbConnect();
    
    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("i", $announcement_id);
    
    return $stmt->execute();
}

?>

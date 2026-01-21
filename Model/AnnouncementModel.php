<?php
require_once('db.php');

// Get all announcements
function getAllAnnouncements()
{
    $conn = dbConnect();

    $sql = "SELECT id, title, message as description, created_by as author_id, created_at FROM announcements ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $announcements = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $announcements[] = $row;
    }

    mysqli_close($conn);
    return $announcements;
}

// Get single announcement by ID
function getAnnouncementById($announcement_id)
{
    $conn = dbConnect();

    $sql = "SELECT id, title, message as description, created_by as author_id, created_at FROM announcements WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $announcement_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $announcement = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $announcement;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return null;
}

// Create announcement (for admin/authority)
function createAnnouncement($title, $description, $author_id)
{
    $conn = dbConnect();

    $title = trim($title);
    $description = trim($description);

    if (empty($title) || empty($description)) {
        mysqli_close($conn);
        return false;
    }

    $sql = "INSERT INTO announcements (title, message, created_by, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $author_id);

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

// Update announcement (admin can edit any)
function updateAnnouncement($announcement_id, $author_id, $title, $description)
{
    $conn = dbConnect();

    $title = trim($title);
    $description = trim($description);

    if (empty($title) || empty($description)) {
        mysqli_close($conn);
        return false;
    }

    // Allow admin to edit any announcement regardless of creator
    $sql = "UPDATE announcements SET title = ?, message = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $announcement_id);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}

// Delete announcement (for admin)
function deleteAnnouncement($announcement_id)
{
    $conn = dbConnect();

    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $announcement_id);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $result;
}

?>
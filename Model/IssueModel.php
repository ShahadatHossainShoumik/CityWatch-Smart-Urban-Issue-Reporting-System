<?php
require_once('db.php');

//insert new issue
function insertIssue($user_id, $title, $description, $location, $image)
{
    $conn = dbConnect();
    
    $query = "INSERT INTO issues
              (user_id, title, description, location, image, status)
              VALUES
              (?, ?, ?, ?, ?, 'pending')";
    
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "issss", $user_id, $title, $description, $location, $image);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    } else {
        mysqli_close($conn);
        return false;
    }
}

//get all approved issues (shows reviewed and resolved issues)
function getAllIssues()
{
    $conn = dbConnect();
    
    // Get issues that have been reviewed or resolved, plus issues with empty/NULL status (legacy/approved)
    $query = "SELECT i.*, u.name
              FROM issues i
              LEFT JOIN users u ON i.user_id = u.id
              WHERE i.status IN ('reviewed', 'resolved') OR i.status = '' OR i.status IS NULL
              ORDER BY i.id DESC";

    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        // Log error for debugging
        error_log("getAllIssues query failed: " . mysqli_error($conn));
        return false;
    }
    
    // Note: Don't close connection here as the result needs to be fetched in the view
    return $result;
}

//get all issues with search and filter
function getAllIssuesWithFilter($search = '', $filter = 'latest')
{
    $conn = dbConnect();
    
    // Base query
    $query = "SELECT i.*, u.name,
              (SELECT COUNT(*) FROM votes WHERE issue_id = i.id AND vote = 'up') as upvotes,
              (SELECT COUNT(*) FROM votes WHERE issue_id = i.id AND vote = 'down') as downvotes
              FROM issues i
              LEFT JOIN users u ON i.user_id = u.id
              WHERE (i.status IN ('reviewed', 'resolved') OR i.status = '' OR i.status IS NULL)";
    
    // Add search condition if provided
    if(!empty($search)){
        $search = mysqli_real_escape_string($conn, $search);
        $query .= " AND (i.location LIKE '%$search%' OR i.title LIKE '%$search%' OR i.description LIKE '%$search%')";
    }
    
    // Add ordering based on filter
    switch($filter){
        case 'upvotes':
            $query .= " ORDER BY upvotes DESC, i.id DESC";
            break;
        case 'downvotes':
            $query .= " ORDER BY downvotes DESC, i.id DESC";
            break;
        case 'latest':
        default:
            $query .= " ORDER BY i.id DESC";
            break;
    }
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        error_log("getAllIssuesWithFilter query failed: " . mysqli_error($conn));
        return false;
    }
    
    return $result;
}

//get all issues by user id
function getIssuesByUser($user_id)
{
    $conn = dbConnect();
    $query = "SELECT i.*, u.name
              FROM issues i
              LEFT JOIN users u ON i.user_id = u.id
              WHERE i.user_id = ?
              ORDER BY i.id DESC";

    $stmt = mysqli_prepare($conn, $query);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"i",$user_id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }
    return false;
}

//update issue (edit by citizen)
function updateIssue($issue_id, $user_id, $title, $description, $location, $image = null)
{
    $conn = dbConnect();

    if($image){
        // update with new image
        $query = "UPDATE issues SET title=?, description=?, location=?, image=? WHERE id=? AND user_id=?";
        $stmt = mysqli_prepare($conn, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"ssssii",$title,$description,$location,$image,$issue_id,$user_id);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $result;
        }
    } else {
        // update without image
        $query = "UPDATE issues SET title=?, description=?, location=? WHERE id=? AND user_id=?";
        $stmt = mysqli_prepare($conn, $query);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"sssii",$title,$description,$location,$issue_id,$user_id);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $result;
        }
    }
    mysqli_close($conn);
    return false;
}

//delete issue (citizen can only delete their own)
function deleteIssue($issue_id, $user_id)
{
    $conn = dbConnect();
    $query = "DELETE FROM issues WHERE id=? AND user_id=?";
    $stmt = mysqli_prepare($conn, $query);

    if($stmt){
        mysqli_stmt_bind_param($stmt,"ii",$issue_id,$user_id);
        $result = mysqli_stmt_execute($stmt);
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $affected > 0;
    }
    mysqli_close($conn);
    return false;
}

//get single issue by id and user id
function getIssueById($issue_id, $user_id)
{
    $conn = dbConnect();
    $query = "SELECT * FROM issues WHERE id=? AND user_id=?";
    $stmt = mysqli_prepare($conn, $query);

    if($stmt){
        mysqli_stmt_bind_param($stmt,"ii",$issue_id,$user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
            $issue = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $issue;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    return false;
}

//admin get all issues
function getAllIssuesForAdmin()
{
    $query = "SELECT i.*, u.name
              FROM issues i
              LEFT JOIN users u ON i.user_id = u.id
              ORDER BY i.id DESC";

    $conn = dbConnect();
    return mysqli_query($conn, $query);
}

//admin update issue status
function updateIssueStatus($issue_id, $status)
{
    $conn = dbConnect();

    // Normalize inputs - map to valid database enum values
    $cleanStatus = strtolower(trim($status)); 
    
    // Map common status names to database enum values
    $statusMap = [
        'approved' => 'reviewed',
        'reviewed' => 'reviewed',
        'resolved' => 'resolved',
        'rejected' => 'resolved',
        'pending' => 'pending'
    ];
    
    // Use mapped status if it exists, otherwise keep original
    $dbStatus = isset($statusMap[$cleanStatus]) ? $statusMap[$cleanStatus] : $cleanStatus;
    
    $cleanId = (int)$issue_id;
    
    // Use prepared statement to prevent SQL injection
    $query = "UPDATE issues SET status=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $dbStatus, $cleanId);
        $result = mysqli_stmt_execute($stmt);
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Return true only if a row was actually updated
        return $result && $affected > 0;
    } else {
        mysqli_close($conn);
        return false;
    }
}

// Admin update issue (no user_id restriction)
function updateIssueForAdmin($issue_id, $title, $description, $location)
{
    $conn = dbConnect();
    $query = "UPDATE issues SET title=?, description=?, location=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    
    if($stmt){
        mysqli_stmt_bind_param($stmt,"sssi",$title,$description,$location,$issue_id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}

// Admin delete issue (no user_id restriction)
function deleteIssueForAdmin($issue_id)
{
    $conn = dbConnect();
    $query = "DELETE FROM issues WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    
    if($stmt){
        mysqli_stmt_bind_param($stmt,"i",$issue_id);
        $result = mysqli_stmt_execute($stmt);
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $affected > 0;
    }
    mysqli_close($conn);
    return false;
}

// Admin get issue by ID without user_id restriction
function getIssueByIdForAdmin($issue_id)
{
    $conn = dbConnect();
    $query = "SELECT i.*, u.name as posted_by FROM issues i LEFT JOIN users u ON i.user_id = u.id WHERE i.id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if($stmt){
        mysqli_stmt_bind_param($stmt,"i",$issue_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
            $issue = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $issue;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    return false;
}
?>



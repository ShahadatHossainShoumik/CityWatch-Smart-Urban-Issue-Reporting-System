<?php
require_once('db.php');

//insert new issue
function insertIssue($user_id, $title, $description, $location, $image)
{
    $query = "INSERT INTO issues
              (user_id, title, description, location, image, status)
              VALUES
              ('$user_id', '$title', '$description', '$location', '$image', 'pending')";

    $conn = dbConnect();
    return mysqli_query($conn, $query);
}

//get all approved issues
function getAllIssues()
{
    $query = "SELECT i.*, u.name
              FROM issues i
              LEFT JOIN users u ON i.user_id = u.id
              WHERE i.status = 'approved'
              ORDER BY i.id DESC";

    $conn = dbConnect();
    return mysqli_query($conn, $query);
}

//get issues by specific user
function getIssuesByUser($user_id)
{
    $query = "SELECT i.*, u.name
              FROM issues i
              LEFT JOIN users u ON i.user_id = u.id
              WHERE i.user_id = '$user_id'
              ORDER BY i.id DESC";

    $conn = dbConnect();
    return mysqli_query($conn, $query);
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
    $query = "UPDATE issues SET status='$status' WHERE id='$issue_id'";
    $conn = dbConnect();
    return mysqli_query($conn, $query);
}
?>

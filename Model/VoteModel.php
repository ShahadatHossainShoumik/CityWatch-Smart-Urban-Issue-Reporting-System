<?php
require_once('db.php');
// for fetching vote by issue_id and user_id
function getVote($issue_id, $user_id)
{
    $conn = dbConnect();
    $query = "SELECT * FROM votes WHERE issue_id=? AND user_id=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $issue_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $vote = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $vote;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    return false;
}

// for inserting vote
function insertVote($issue_id, $user_id, $vote)
{
    $conn = dbConnect();
    $query = "INSERT INTO votes (issue_id, user_id, vote)
              VALUES (?,?,?)";

    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iis", $issue_id, $user_id, $vote);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}

// for updating vote
function updateVote($issue_id, $user_id, $vote)
{
    $conn = dbConnect();
    $query = "UPDATE votes
              SET vote=?
              WHERE issue_id=? AND user_id=?";

    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sii", $vote, $issue_id, $user_id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}

// for counting votes
function countVotes($issue_id, $type)
{
    $conn = dbConnect();
    $query = "SELECT COUNT(*) AS total
              FROM votes
              WHERE issue_id=? AND vote=?";

    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $issue_id, $type);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $row['total'];
    }
    mysqli_close($conn);
    return 0;
}
?>
<?php
require_once('db.php');
///for fetching vote by issue id and user id
function getVote($issue_id, $user_id)
{

    $query = "SELECT * FROM votes WHERE issue_id='$issue_id' AND user_id='$user_id'";
    $conn = dbConnect();
    $data = mysqli_query($conn, $query);

    if (mysqli_num_rows($data) > 0) {
        return mysqli_fetch_assoc($data);
    }
    return false;
}

//for inserting vote
function insertVote($issue_id, $user_id, $vote)
{

    $query = "INSERT INTO votes (issue_id, user_id, vote)
              VALUES ('$issue_id','$user_id','$vote')";

    $conn = dbConnect();
    return mysqli_query($conn, $query);
}

//for updating vote
function updateVote($issue_id, $user_id, $vote)
{

    $query = "UPDATE votes
              SET vote='$vote'
              WHERE issue_id='$issue_id' AND user_id='$user_id'";

    $conn = dbConnect();
    return mysqli_query($conn, $query);
}

//for counting votes
function countVotes($issue_id, $type)
{

    $query = "SELECT COUNT(*) AS total
              FROM votes
              WHERE issue_id='$issue_id' AND vote='$type'";

    $conn = dbConnect();
    $data = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($data);

    return $row['total'];
}
?>
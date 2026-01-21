<?php
session_start();
require_once('../Model/VoteModel.php');

// Vote Controller - Handle both AJAX and traditional requests
if (!isset($_SESSION['id'])) {
    if (isset($_POST['issue_id'])) {
        // AJAX request
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Not logged in']);
    } else {
        // request via redirect
        header("Location: ../View/login.php");
    }
    exit();
}

$user_id = $_SESSION['id'];

// Handle vote submission via AJAX (POST)
if (isset($_POST['issue_id']) && isset($_POST['vote'])) {

    $issue_id = (int) ($_POST['issue_id'] ?? 0);
    $vote = trim($_POST['vote'] ?? '');

    // Validate inputs
    if ($issue_id === 0 || !in_array($vote, ['up', 'down'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit();
    }

    // Check if user already voted
    $existing_vote = getVote($issue_id, $user_id);

    if ($existing_vote) {
        // Update existing vote
        if ($existing_vote['vote'] === $vote) {
            // Same vote - remove it (toggle)
            $conn = mysqli_connect("localhost", "root", "", "citywatch", 3306);
            $query = "DELETE FROM votes WHERE issue_id=? AND user_id=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ii", $issue_id, $user_id);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            $up_votes = countVotes($issue_id, 'up');
            $down_votes = countVotes($issue_id, 'down');

            echo json_encode([
                'success' => true,
                'message' => 'Vote removed',
                'user_vote' => null,
                'up_votes' => $up_votes,
                'down_votes' => $down_votes
            ]);
        } else {
            // Different vote - update it
            updateVote($issue_id, $user_id, $vote);

            $up_votes = countVotes($issue_id, 'up');
            $down_votes = countVotes($issue_id, 'down');

            echo json_encode([
                'success' => true,
                'message' => 'Vote updated',
                'user_vote' => $vote,
                'up_votes' => $up_votes,
                'down_votes' => $down_votes
            ]);
        }
    } else {
        // Insert new vote
        insertVote($issue_id, $user_id, $vote);

        $up_votes = countVotes($issue_id, 'up');
        $down_votes = countVotes($issue_id, 'down');

        echo json_encode([
            'success' => true,
            'message' => 'Vote recorded',
            'user_vote' => $vote,
            'up_votes' => $up_votes,
            'down_votes' => $down_votes
        ]);
    }
    exit();
}

// Handle vote submission via GET (for redirects)
if (isset($_GET['issue_id']) && isset($_GET['vote'])) {

    $issue_id = (int) $_GET['issue_id'];
    $vote = trim($_GET['vote']);
    // validate inputs
    if ($issue_id > 0 && in_array($vote, ['up', 'down'])) {
        $existingVote = getVote($issue_id, $user_id);

        if ($existingVote) {
            updateVote($issue_id, $user_id, $vote);
        } else {
            insertVote($issue_id, $user_id, $vote);
        }
    }

    header("Location: ../View/Citizen/citizen_dashboard.php");
    exit();
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit();

?>
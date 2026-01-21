<?php
session_start();
require_once('../Model/VoteModel.php');
// Vote Controller
if(!isset($_SESSION['id'])){
    header("Location: ../View/login.php");
    exit();
}
// Handle vote submission
if(isset($_GET['issue_id']) && isset($_GET['vote'])){

    $issue_id = $_GET['issue_id'];
    $vote     = $_GET['vote'];      
    $user_id  = $_SESSION['id'];

    $existingVote = getVote($issue_id, $user_id);

    if($existingVote){
        updateVote($issue_id, $user_id, $vote);
    } else {
        insertVote($issue_id, $user_id, $vote);
    }

    header("Location: ../View/citizen/citizen_dashboard.php");
    exit();
}
?>

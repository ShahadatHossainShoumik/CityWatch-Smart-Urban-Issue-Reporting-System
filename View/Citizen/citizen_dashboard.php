<?php
session_start();

require_once('../../Model/IssueModel.php');
require_once('../../Model/VoteModel.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../login.php");
    exit();
}

$issues = getAllIssues();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Dashboard - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_dashboard.css">
</head>

<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="citizen_dashboard.php" class="active">Home</a></li>
            <li><a href="citizen_new_incident.php">New Incident</a></li>
            <li><a href="citizen_my_uploads.php">My Uploads</a></li>
            <li><a href="citizen_view_announcement.php">Announcement</a></li>
            <li><a href="citizen_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">

        <div class="top-bar">
            <form class="search-form">
                <input type="text" name="search" placeholder="Search by location...">
                <select name="filter">
                    <option value="latest">Latest</option>
                    <option value="upvotes">Most Upvoted</option>
                    <option value="downvotes">Most Downvoted</option>
                </select>
                <button type="submit">Apply</button>
            </form>
        </div>

        <h2>Incidents Feed</h2>

        <?php
        if ($issues && mysqli_num_rows($issues) > 0) {
            while ($row = mysqli_fetch_assoc($issues)) {
                ?>
                <div class="incident-card">

                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>

                    <p><b>Posted by:</b> <?php echo htmlspecialchars($row['name']); ?></p>
                    <p><b>Location:</b> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>

                    <?php if (!empty($row['image'])) { ?>
                        <img src="../../Images/<?php echo htmlspecialchars($row['image']); ?>" width="200">
                    <?php } ?>

                    <br><br>

                    <a href="../../Controller/VoteController.php?issue_id=<?php echo $row['id']; ?>&vote=up">
                        Upvote (<?php echo countVotes($row['id'], 'up'); ?>)
                    </a>

                    &nbsp;&nbsp;

                    <a href="../../Controller/VoteController.php?issue_id=<?php echo $row['id']; ?>&vote=down">
                        Downvote (<?php echo countVotes($row['id'], 'down'); ?>)
                    </a>

                </div>
                <?php
            }
        } else {
            echo "<p>No issues found</p>";
        }
        ?>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>

</html>
<?php
session_start();

require_once('../../Model/IssueModel.php');
require_once('../../Model/VoteModel.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../login.php");
    exit();
}

// Get search and filter parameters
$search = trim($_GET['search'] ?? '');
$filter = trim($_GET['filter'] ?? 'latest');

// Validate filter value
if(!in_array($filter, ['latest', 'upvotes', 'downvotes'])){
    $filter = 'latest';
}

// Get filtered issues
$issues = getAllIssuesWithFilter($search, $filter);
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

        <?php if (isset($_SESSION['msg'])) { ?>
            <div style="padding: 15px; margin-bottom: 20px; background-color: #4CAF50; color: white; border-radius: 5px;">
                <?php echo $_SESSION['msg']; ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php } ?>

        <div class="top-bar">
            <form class="search-form" method="GET" action="">
                <input type="text" name="search" placeholder="Search by location, title, or description..." value="<?php echo htmlspecialchars($search); ?>">
                <select name="filter">
                    <option value="latest" <?php echo $filter === 'latest' ? 'selected' : ''; ?>>Latest</option>
                    <option value="upvotes" <?php echo $filter === 'upvotes' ? 'selected' : ''; ?>>Most Upvoted</option>
                    <option value="downvotes" <?php echo $filter === 'downvotes' ? 'selected' : ''; ?>>Most Downvoted</option>
                </select>
                <button type="submit">Apply</button>
                <?php if(!empty($search) || $filter !== 'latest'){ ?>
                    <a href="citizen_dashboard.php" style="padding: 8px 15px; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; color: #666;">Clear</a>
                <?php } ?>
            </form>
        </div>

        <h2>Incidents Feed</h2>
        
        <?php if(!empty($search)){ ?>
            <p style="padding: 10px; background: #e3f2fd; border-radius: 5px; color: #0277bd;">
                Showing results for: <strong><?php echo htmlspecialchars($search); ?></strong>
            </p>
        <?php } ?>

        <?php
        // Check if query executed and display results
        if ($issues === false) {
            echo "<p style='color: red; padding: 15px; background: #ffebee; border-radius: 5px;'>Database query failed. Please check database connection.</p>";
        } elseif (mysqli_num_rows($issues) === 0) {
            echo "<p style='padding: 15px; background: #fff3cd; border-radius: 5px; color: #856404;'> No approved issues found yet. Issues must be approved by admin before they appear here.</p>";
            echo "<p style='padding: 10px; background: #e3f2fd; border-radius: 5px;'> <strong>Tip:</strong> <a href='citizen_new_incident.php'>Submit a new incident</a> and wait for admin approval.</p>";
        } else {
            // Display all approved issues
            while ($row = mysqli_fetch_assoc($issues)) {
                $issue_upvotes = $row['upvotes'] ?? countVotes($row['id'], 'up');
                $issue_downvotes = $row['downvotes'] ?? countVotes($row['id'], 'down');
                ?>
                <div class="incident-card">

                    <h3><a href="citizen_incident_details.php?id=<?php echo $row['id']; ?>" style="color: #0277bd; text-decoration: none;"><?php echo htmlspecialchars($row['title']); ?></a></h3>

                    <p><b>Posted by:</b> <?php echo htmlspecialchars($row['name']); ?></p>
                    <p><b>Location:</b> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><?php echo htmlspecialchars(substr($row['description'], 0, 150)); ?><?php echo strlen($row['description']) > 150 ? '...' : ''; ?></p>

                    <?php if (!empty($row['image'])) { ?>
                        <img src="../../Images/<?php echo htmlspecialchars($row['image']); ?>" width="200">
                    <?php } ?>

                    <div class="vote-section" id="vote-<?php echo $row['id']; ?>" style="margin-top: 15px; display: flex; gap: 20px; align-items: center;">
                        <button class="vote-btn upvote-btn" data-issue="<?php echo $row['id']; ?>" data-vote="up" style="padding: 8px 12px; border: 1px solid #4CAF50; background: #f0f0f0; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                            👍 <span class="upvote-count"><?php echo $issue_upvotes; ?></span>
                        </button>
                        <button class="vote-btn downvote-btn" data-issue="<?php echo $row['id']; ?>" data-vote="down" style="padding: 8px 12px; border: 1px solid #f44336; background: #f0f0f0; border-radius: 5px; cursor: pointer; transition: all 0.3s;">
                            👎 <span class="downvote-count"><?php echo $issue_downvotes; ?></span>
                        </button>
                        <span id="vote-message-<?php echo $row['id']; ?>" style="font-size: 0.9rem; color: #666;"></span>
                    </div>

                </div>
                <?php
            }
        }
        ?>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
    // Handle vote button clicks
    document.querySelectorAll('.vote-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const issueId = this.dataset.issue;
            const voteType = this.dataset.vote;
            
            // AJAX request to vote
            const formData = new FormData();
            formData.append('issue_id', issueId);
            formData.append('vote', voteType);
            
            fetch('../../Controller/VoteController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Update vote counts
                    document.querySelector(`#vote-${issueId} .upvote-count`).textContent = data.up_votes;
                    document.querySelector(`#vote-${issueId} .downvote-count`).textContent = data.down_votes;
                    
                    // Update button styling based on user vote
                    const upBtn = document.querySelector(`#vote-${issueId} .upvote-btn`);
                    const downBtn = document.querySelector(`#vote-${issueId} .downvote-btn`);
                    
                    upBtn.style.background = data.user_vote === 'up' ? '#c8e6c9' : '#f0f0f0';
                    downBtn.style.background = data.user_vote === 'down' ? '#ffcdd2' : '#f0f0f0';
                    
                    // Show feedback message
                    document.querySelector(`#vote-message-${issueId}`).textContent = data.message;
                    setTimeout(() => {
                        document.querySelector(`#vote-message-${issueId}`).textContent = '';
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.querySelector(`#vote-message-${issueId}`).textContent = 'Error voting';
            });
        });
    });
    </script>

</body>

</html>
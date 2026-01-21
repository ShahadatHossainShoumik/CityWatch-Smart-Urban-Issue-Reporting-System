<?php
session_start();

// Verify user is authenticated citizen BEFORE requiring models
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen' || !isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

require_once('../../Model/IssueModel.php');
require_once('../../Model/VoteModel.php');

$issue_id = (int) ($_GET['id'] ?? 0);

if ($issue_id === 0) {
    header("Location: citizen_dashboard.php");
    exit();
}

// Get issue details - need a new function
$conn = mysqli_connect("localhost", "root", "", "citywatch", 3306);
$query = "SELECT i.*, u.name, u.profile_image 
          FROM issues i 
          LEFT JOIN users u ON i.user_id = u.id 
          WHERE i.id = ? 
          LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $issue_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    mysqli_close($conn);
    header("Location: citizen_dashboard.php");
    exit();
}

$issue = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
mysqli_close($conn);

$user_id = $_SESSION['id'];
$user_vote = getVote($issue_id, $user_id);
$up_votes = countVotes($issue_id, 'up');
$down_votes = countVotes($issue_id, 'down');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($issue['title']); ?> - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_dashboard.css">
    <style>
        .detail-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .detail-header {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .detail-header h1 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 1.8rem;
        }

        .meta-info {
            display: flex;
            gap: 20px;
            color: #666;
            font-size: 0.9rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }

        .status-approved {
            background: #c8e6c9;
            color: #2e7d32;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-resolved {
            background: #c8e6c9;
            color: #2e7d32;
        }

        .status-reviewed {
            background: #bbdefb;
            color: #0277bd;
        }

        .detail-body {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .detail-body h2 {
            margin-top: 0;
            color: #0277bd;
            font-size: 1.3rem;
        }

        .detail-body p {
            line-height: 1.6;
            color: #444;
        }

        .detail-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }

        .vote-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .vote-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .vote-btn {
            padding: 12px 24px;
            border: 2px solid #ddd;
            background: #f5f5f5;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .vote-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .vote-btn.active-up {
            background: #c8e6c9;
            border-color: #4CAF50;
        }

        .vote-btn.active-down {
            background: #ffcdd2;
            border-color: #f44336;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #0277bd;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
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
        <a href="citizen_dashboard.php" class="back-link">← Back to Incidents Feed</a>

        <div class="detail-container">
            <div class="detail-header">
                <h1><?php echo htmlspecialchars($issue['title']); ?></h1>
                <div class="meta-info">
                    <div class="meta-item">
                        <strong>Posted by:</strong> <?php echo htmlspecialchars($issue['name']); ?>
                    </div>
                    <div class="meta-item">
                        <strong>Location:</strong> <?php echo htmlspecialchars($issue['location']); ?>
                    </div>
                    <div class="meta-item">
                        <strong>Date:</strong> <?php echo date('F j, Y', strtotime($issue['created_at'])); ?>
                    </div>
                    <div class="meta-item">
                        <?php
                        $statusClass = 'status-pending';
                        $statusText = 'Pending';
                        if (empty($issue['status'])) {
                            $statusClass = 'status-approved';
                            $statusText = 'Approved';
                        } elseif ($issue['status'] === 'reviewed') {
                            $statusClass = 'status-reviewed';
                            $statusText = 'Reviewed';
                        } elseif ($issue['status'] === 'resolved') {
                            $statusClass = 'status-resolved';
                            $statusText = 'Resolved';
                        }
                        ?>
                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                    </div>
                </div>
            </div>

            <div class="detail-body">
                <h2>Description</h2>
                <p><?php echo nl2br(htmlspecialchars($issue['description'])); ?></p>

                <?php if (!empty($issue['image'])) { ?>
                    <img src="../../Images/<?php echo htmlspecialchars($issue['image']); ?>" class="detail-image"
                        alt="Incident Image">
                <?php } ?>
            </div>

            <div class="vote-section">
                <h2 style="margin-top: 0; color: #0277bd;">Community Response</h2>
                <div class="vote-buttons">
                    <button
                        class="vote-btn upvote-btn <?php echo ($user_vote && $user_vote['vote'] === 'up') ? 'active-up' : ''; ?>"
                        data-vote="up">
                        Upvote <span class="upvote-count"><?php echo $up_votes; ?></span>
                    </button>
                    <button
                        class="vote-btn downvote-btn <?php echo ($user_vote && $user_vote['vote'] === 'down') ? 'active-down' : ''; ?>"
                        data-vote="down">
                        Downvote <span class="downvote-count"><?php echo $down_votes; ?></span>
                    </button>
                    <span id="vote-message" style="color: #666; font-size: 0.95rem;"></span>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        const issueId = <?php echo $issue_id; ?>;

        document.querySelectorAll('.vote-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const voteType = this.dataset.vote;

                const formData = new FormData();
                formData.append('issue_id', issueId);
                formData.append('vote', voteType);

                fetch('../../Controller/VoteController.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update counts
                            document.querySelector('.upvote-count').textContent = data.up_votes;
                            document.querySelector('.downvote-count').textContent = data.down_votes;

                            // Update button states
                            document.querySelector('.upvote-btn').classList.remove('active-up');
                            document.querySelector('.downvote-btn').classList.remove('active-down');

                            if (data.user_vote === 'up') {
                                document.querySelector('.upvote-btn').classList.add('active-up');
                            } else if (data.user_vote === 'down') {
                                document.querySelector('.downvote-btn').classList.add('active-down');
                            }

                            // Show message
                            document.getElementById('vote-message').textContent = data.message;
                            setTimeout(() => {
                                document.getElementById('vote-message').textContent = '';
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('vote-message').textContent = 'Error voting';
                    });
            });
        });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Incident - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_new_incident.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="citizen_dashboard.php">Home</a></li>
            <li><a href="citizen_new_incident.php" class="active">New Incident</a></li>
            <li><a href="citizen_my_uploads.php">My Uploads</a></li>
            <li><a href="citizen_view_announcement.php">Announcement</a></li>
            <li><a href="citizen_profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <?php
        session_start();
        if (isset($_SESSION['msg'])) { ?>
            <div style="padding: 15px; margin-bottom: 20px; background-color: #f44336; color: white; border-radius: 5px;">
                <?php echo $_SESSION['msg']; ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php } ?>

        <div class="form-card">
            <h2>Report a New Incident</h2>
            <p class="subtitle">Fill in the details below to report an issue to authorities.</p>

            <form class="incident-form" action="../../Controller/IssueController.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="title">Incident Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter a short title (e.g., Damaged Road)" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter incident location" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="5" placeholder="Describe what happened..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="issue_image">Upload Photos</label>
                    <input type="file" id="issue_image" name="issue_image" accept="image/*" onchange="previewImages(event)">
                    
                    <div id="previewArea"></div>
                </div>

                <button type="submit" class="submit_issue">Submit Incident</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        // Simple JS to show image previews before uploading
        function previewImages(event) {
            let previewArea = document.getElementById('previewArea');
            previewArea.innerHTML = ""; // Clear previous previews
            let files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                let img = document.createElement("img");
                img.src = URL.createObjectURL(files[i]);
                img.classList.add("preview-img");
                previewArea.appendChild(img);
            }
        }
    </script>
</body>
</html>
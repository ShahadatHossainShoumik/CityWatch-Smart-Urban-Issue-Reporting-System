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
            <li><a href="../login.php">Logout</a></li>
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

        <div class="incident-card" id="incident_1">
            <h3>Damaged Road</h3>
            <p><strong>Posted by:</strong>Shahadat Hossain</p> 
            <p><strong>Location:</strong>Kuril</p>
            <p>Road Damaged</p>
        
            <div class="incident-images">
                <img src="../Images/image1.jpg" class="incident-image" alt="Damaged Road">
            </div>
        
            <div class="incident-actions">
                <button class="btn upvote">Upvote (<span>12</span>)</button>
                <button class="btn downvote">Downvote (<span>2</span>)</button>
            </div>
        </div>

        <div class="incident-card" id="incident_2">
            <h3>Broken Streetlight</h3>
            <p><strong>Posted by:</strong>Mehedi Hasan Shuvo </p> 
            <p><strong>Location:</strong> Gulshan Park</p>
            <p>The streetlight is broken</p>
        
            <div class="incident-images">
                <img src="../../images/image2.jpg" class="incident-image" alt="Broken Streetlight">
            </div>
        
            <div class="incident-actions">
                <button class="btn upvote">Upvote (<span>5</span>)</button>
                <button class="btn downvote">Downvote (<span>0</span>)</button>
            </div>
        </div>

    </div>
    
    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>
</body>
</html>
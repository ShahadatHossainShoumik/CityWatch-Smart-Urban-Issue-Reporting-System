<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authority Dashboard - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="authority_dashboard.css">
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="authority_dashboard.php" class="active">All Incidents</a></li>
            <li><a href="reviewed_incidents.php">Reviewed Incidents</a></li>
            <li><a href="new_announcement.php">New Announcement</a></li>
            <li><a href="all_announcements.php">All Announcements</a></li>
            <li><a href="authority_profile.php">Profile</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h3 class="page-title">All Incidents</h3>
        
        <form action="#" method="GET" class="filter-form">
            <label>Filter:</label>
            <select name="filter" onchange="this.form.submit()">
                <option value="latest">Latest</option>
                <option value="upvotes">Most Upvoted</option>
                <option value="downvotes">Most Downvoted</option>
            </select>
        </form>

        <div class="incident-list">

            <div class="incident-card">
                <h4>Problem 1</h4>
                <p><strong>Location:</strong></p>
                <p><strong>Description:</strong></p>
                <p><strong>Upvotes:</strong> | <strong>Downvotes:</strong> </p>

                <div class="incident-images">
                    <img src="../images/image1.jpg" class="incident-image" alt="Incident Image" />
                </div>

                <form action="#" method="POST" class="resource-form">
                    <input type="hidden" name="incident_id" value="101">
                    
                    <label class="resource-label">Select Resource to Deploy:</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="resource[]" value="Fire Service"> Fire Service</label>
                        <label><input type="checkbox" name="resource[]" value="Ambulance"> Ambulance</label>
                        <label><input type="checkbox" name="resource[]" value="Police"> Police</label>
                        <label><input type="checkbox" name="resource[]" value="Army"> Army</label>
                    </div>

                    <button type="submit" class="btn">Add Resource</button>
                </form>
            </div>

            <div class="incident-card">
                <h4>Problem 2</h4>
                <p><strong>Location:</strong></p>
                <p><strong>Description:</strong></p>
                <p><strong>Upvotes:</strong> | <strong>Downvotes:</strong></p>

                <div class="incident-images">
                    <img src="../../images/image2.jpg" class="incident-image" alt="Incident Image" />
                </div>

                <form action="#" method="POST" class="resource-form">
                    <input type="hidden" name="incident_id" value="102">
                    
                    <label class="resource-label">Select Resource to Deploy:</label>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="resource[]" value="Fire Service"> Fire Service</label>
                        <label><input type="checkbox" name="resource[]" value="Ambulance"> Ambulance</label>
                        <label><input type="checkbox" name="resource[]" value="Police"> Police</label>
                        <label><input type="checkbox" name="resource[]" value="Army"> Army</label>
                    </div>

                    <button type="submit" class="btn">Add Resource</button>
                </form>
            </div>

        </div>

    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
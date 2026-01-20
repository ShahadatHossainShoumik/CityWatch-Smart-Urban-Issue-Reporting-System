<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - CityWatch</title>
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="citizen_profile.css">
    
    <script src="../../Controller/Citizen/citizen_profile.js"></script>
</head>
<body>

    <div class="sidebar">
        <h3>CityWatch</h3>
        <ul>
            <li><a href="citizen_dashboard.php">Home</a></li>
            <li><a href="citizen_new_incident.php">New Incident</a></li>
            <li><a href="citizen_my_uploads.php">My Uploads</a></li>
            <li><a href="citizen_view_announcement.php">Announcement</a></li>
            <li><a href="citizen_profile.php" class="active">Profile</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="container">
            <h2>My Profile</h2>

            <div class="profileCard">
                <div class="avatarCol">
                    <img class="avatar" src="../images/default-profile.jpg" alt="Profile Image">
                    
                    <label class="uploadBtn">
                        Change photo
                        <input type="file" id="profile_image" name="profile_image" form="editForm" accept="image/*">
                    </label>
                    <img id="preview" class="avatarPreview" alt="Preview">
                </div>

                <div class="infoCol">
                    <div class="infoRow"><span>Name:</span></div>
                    <div class="infoRow"><span>Email:</span></div>
                    <div class="infoRow"><span>Mobile:</span></div>
                    <div class="infoRow"><span>Date of Birth:</span></div>
                    <div class="infoRow"><span>NID:</span></div>
                    <div class="infoRow"><span>Role:</span></div>
                </div>
            </div>

            <div class="card">
                <h3>Edit Profile Details</h3>
                <form id="editForm" action="#" method="POST" class="formGrid">
                    <div class="field full">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="" required>
                    </div>
                    <div class="field">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="" required>
                    </div>
                    <div class="field">
                        <label for="mobile">Mobile (11 digits)</label>
                        <input type="text" id="mobile" name="mobile" value="" required>
                        <small class="hint">Exactly 11 digits</small>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="" readonly class="readonly-field">
                    </div>
                    <div class="field">
                        <label for="nid">NID (10 digits)</label>
                        <input type="text" id="nid" name="nid" value="" readonly class="readonly-field">
                    </div>
                    
                    <div class="field full">
                        <button type="submit" class="primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <h3>Change Password</h3>
                <form id="passwordForm" action="#" method="POST" class="formGrid">
                    <div class="field full">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="field full">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <small class="hint">Must contain at least 8 charecters, with symbols and numbers combined</small>
                    </div>
                    <div class="field full">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="field full">
                        <button type="submit" class="primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

</body>
</html>
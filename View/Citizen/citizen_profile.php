<?php
session_start();
require_once('../../Model/UserModel.php');

if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../login.php");
    exit();
}

$user = getUserById($_SESSION['id']);
if (!$user) {
    header("Location: ../login.php");
    exit();
}

$profileRel = "../../Images/default-profile.jpg";

// default fallback if not present
if (!file_exists(dirname(__DIR__, 2) . "/Images/default-profile.jpg")) {
    $profileRel = "https://via.placeholder.com/200";
}

if (!empty($user['profile_image'])) {
    // normalize stored path like 'profiles/xxx.jpg' or 'Images/profiles/xxx.jpg'
    $img = ltrim($user['profile_image'], '/');
    $img = preg_replace('/^(images|Images)\//', '', $img);

    $candidateRel = "../../Images/" . $img;
    $candidateAbs = dirname(__DIR__, 2) . "/Images/" . $img;

    if (!file_exists($candidateAbs)) {
        $candidateRel = "../../images/" . $img;
        $candidateAbs = dirname(__DIR__, 2) . "/images/" . $img;
    }

    if (file_exists($candidateAbs)) {
        $profileRel = $candidateRel;
    }
}
?>
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

            <?php if (isset($_SESSION['msg'])) { ?>
                <div class="flash">
                    <?php echo $_SESSION['msg'];
                    unset($_SESSION['msg']); ?>
                </div>
            <?php } ?>

            <div class="profileCard">
                <div class="avatarCol">
                    <img class="avatar" src="<?php echo $profileRel; ?>" alt="Profile Image">

                    <label class="uploadBtn">
                        Change photo
                        <input type="file" id="profile_image" name="profile_image" form="editForm" accept="image/*">
                    </label>
                    <img id="preview" class="avatarPreview" alt="Preview">
                </div>

                <div class="infoCol">
                    <div class="infoRow">
                        <span class="label">Name</span>
                        <span class="value"><?php echo htmlspecialchars($user['name']); ?></span>
                    </div>
                    <div class="infoRow">
                        <span class="label">Email</span>
                        <span class="value"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    <div class="infoRow">
                        <span class="label">Mobile</span>
                        <span class="value"><?php echo htmlspecialchars($user['mobile']); ?></span>
                    </div>
                    <div class="infoRow">
                        <span class="label">Date of Birth</span>
                        <span class="value"><?php echo htmlspecialchars($user['dob']); ?></span>
                    </div>
                    <div class="infoRow">
                        <span class="label">NID</span>
                        <span class="value"><?php echo htmlspecialchars($user['nid']); ?></span>
                    </div>
                    <div class="infoRow">
                        <span class="label">Role</span>
                        <span class="value"><?php echo htmlspecialchars($user['role']); ?></span>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3>Edit Profile Details</h3>
                <form id="editForm" action="../../Controller/CitizenProfileController.php" method="POST"
                    class="formGrid" enctype="multipart/form-data">
                    <div class="field full">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>"
                            required>
                    </div>
                    <div class="field">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>"
                            required>
                    </div>
                    <div class="field">
                        <label for="mobile">Mobile (11 digits)</label>
                        <input type="text" id="mobile" name="mobile"
                            value="<?php echo htmlspecialchars($user['mobile']); ?>" required>
                        <small class="hint">Exactly 11 digits</small>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            value="<?php echo htmlspecialchars($user['email']); ?>" readonly class="readonly-field">
                    </div>
                    <div class="field">
                        <label for="nid">NID (10 digits)</label>
                        <input type="text" id="nid" name="nid" value="<?php echo htmlspecialchars($user['nid']); ?>"
                            readonly class="readonly-field">
                    </div>

                    <div class="field full">
                        <button type="submit" name="update_profile" value="1" class="primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <h3>Change Password</h3>
                <form id="passwordForm" action="../../Controller/CitizenProfileController.php" method="POST"
                    class="formGrid">
                    <div class="field full">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="field full">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required>
                        <small class="hint">Must contain at least 8 charecters, with symbols and numbers
                            combined</small>
                    </div>
                    <div class="field full">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="field full">
                        <button type="submit" name="change_password" value="1" class="primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 CityWatch. All Rights Reserved.</p>
    </footer>

    <script>
        // image preview on file select
        document.getElementById('profile_image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const preview = document.getElementById('preview');
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>
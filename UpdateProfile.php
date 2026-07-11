<?php
session_start();

$conn = new mysqli("localhost", "root", "", "startit");
if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}

if (isset($_SESSION['username'])) {
    $username = $conn->real_escape_string($_SESSION['username']);
    $sql = "SELECT * FROM applicant WHERE username = '$username'";
} else {
    $applicant_id = $conn->real_escape_string($_SESSION['applicant_id'] ?? $_SESSION['user_id'] ?? '');
    $sql = "SELECT * FROM applicant WHERE applicant_id = '$applicant_id'";
}

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['applicant_id'] = $user['applicant_id']; 
} else {
    die("Error: Applicant record details could not be found for your active logged-in session. Please log out and log in again.");
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Update Profile</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #F8F9FA; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #2D2D2D;
        }

        .nav-header {
            background-color: #4A0E4E; 
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .toggle-menu-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 6px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-menu-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.02);
        }

        .nav-logo-img {
            width: 32px;
            height: 32px;
            display: block;
            object-fit: cover;
            border-radius: 50%;
        }

        .header-title {
            color: white;
            font-size: 1.4rem;
            font-weight: 600;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .sidebar-menu {
            position: absolute;
            top: 70px;
            left: -260px; 
            width: 240px;
            background-color: #4A0E4E;
            box-shadow: 4px 8px 25px rgba(0, 0, 0, 0.15);
            border-bottom-right-radius: 12px;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            transition: left 0.3s ease;
            z-index: 20;
        }

        .sidebar-menu.active {
            left: 0;
        }

        .sidebar-menu a {
            color: #FFFFFF;
            padding: 16px 25px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-left 0.2s;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu a.active-view {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #FFFFFF;
            font-weight: bold;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.15);
            margin: 10px 25px;
        }
        
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .profile-container {
            background-color: #FFFFFF;
            width: 100%;
            max-width: 950px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #EAEAEA;
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }
    
        .avatar-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #4A5568;
            font-size: 16px;
            font-weight: 600;
            width: 160px;
        }

        .avatar-container {
            position: relative;
            width: 140px;
            height: 140px;
            margin-bottom: 15px;
        }

        .avatar-container img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #F3E8FF; 
            background-color: #F8F9FA;
        }

        .file-input-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            opacity: 0;
            cursor: pointer;
        }

        .edit-label {
            cursor: pointer;
            color: #6B21A8;
            transition: color 0.2s;
        }

        .edit-label:hover {
            color: #4A0E4E;
            text-decoration: underline;
        }
      
        .form-section {
            flex: 1;
            display: grid;
            grid-template-columns: 130px 1fr 130px 1fr; 
            gap: 15px 20px;
            align-items: center;
        }

        .form-section label {
            color: #4A5568;
            font-weight: 700;
            font-size: 14px;
            white-space: nowrap;
        }

        .form-section input[type="text"],
        .form-section input[type="email"],
        .form-section input[type="password"],
        .form-section input[type="date"] {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            background-color: #F8F9FA;
            color: #2D2D2D;
            font-size: 14px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s, background-color 0.2s;
        }

        .form-section input:focus {
            border-color: #4A0E4E;
            background-color: #FFFFFF;
        }

        .full-width-row {
            grid-column: span 3; 
        }

        .clear-row {
            grid-column-start: 1;
        }

        .radio-group {
            display: flex;
            align-items: center;
            gap: 20px;
            color: #4A5568;
            font-size: 14px;
            font-weight: 600;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .radio-group input[type="radio"] {
            margin: 0;
            accent-color: #4A0E4E;
            width: 16px;
            height: 16px;
        }

        .button-section {
            grid-column: span 4;
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-update {
            background-color: #4A0E4E; 
            color: white;
            font-weight: bold;
            font-size: 16px;
            padding: 12px 45px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(74, 14, 78, 0.2);
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-update:hover {
            background-color: #350A38;
            transform: translateY(-1px);
        }

        @media (max-width: 850px) {
            .profile-container {
                flex-direction: column;
                align-items: center;
            }
            .form-section {
                grid-template-columns: 1fr;
                width: 100%;
            }
            .full-width-row, .button-section, .clear-row {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>

<div class="nav-header">
    <button class="toggle-menu-btn" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT" class="nav-logo-img">
    </button>
    <div class="header-title">Update Profile</div>
    <div></div>
</div>

<div class="sidebar-menu" id="panelSidebar">
    <a href="updateprofile.php" class="active-view">Update Profile</a>
    <a href="jobSearching.php">Job Vacancy</a>
    <a href="applicationStatus.php">Application Status</a>
    <div class="sidebar-divider"></div>
    <a href="login.php" style="color: #FF8A8A; font-size: 0.95rem;">Log Out</a>
</div>
	
<div class="main-content">
    <form method="POST" action="updateprofileprocess.php" enctype="multipart/form-data" style="width: 100%; max-width: 950px;">
        <div class="profile-container">
            
            <div class="avatar-section">
                <label for="profile_picture" class="avatar-container" style="display: block; margin-bottom: 15px;">
                    <?php 
                        $image_src = (!empty($user['profile_picture'])) ? $user['profile_picture'] : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
                    ?>
                    <img id="avatarPreview" src="<?php echo htmlspecialchars($image_src); ?>" alt="Profile Picture" style="cursor: pointer;">
                    <input type="file" id="profile_picture" name="profile_picture" class="file-input-wrapper" accept="image/*"> 
                </label>
                <label for="profile_picture" class="edit-label">Edit</label>
            </div>
	
            <div class="form-section">

                <label>Full Name:</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? ''); ?>">

                <label>Education Level:</label>
                <input type="text" name="education_level" value="<?= htmlspecialchars($user['education_level'] ?? ''); ?>">

                <label>IC Number:</label>
                <input type="text" name="icnumber" value="<?= htmlspecialchars($user['icnumber'] ?? ''); ?>">

                <label>Skills:</label>
                <input type="text" name="skills" value="<?= htmlspecialchars($user['skills'] ?? ''); ?>">

                <label>Date of Birth:</label>
                <input type="date" name="date_of_birth" value="<?= htmlspecialchars($user['date_of_birth'] ?? ''); ?>">

                <label>Experience years:</label>
                <input type="text" name="experience_years" value="<?= htmlspecialchars($user['experience_years'] ?? ''); ?>">

                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? ''); ?>">

                <label>Username:</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? ''); ?>">

                <label>Phone Number:</label>
                <input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number'] ?? ''); ?>">

                <label>Password:</label>
                <input type="password" name="password" placeholder="Leave blank if no change">

                <label>Gender:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="Male" <?= (($user['gender'] ?? '') == 'Male') ? 'checked' : ''; ?>> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="Female" <?= (($user['gender'] ?? '') == 'Female') ? 'checked' : ''; ?>> Female
                    </label>
                </div>

                <label class="clear-row">Address:</label>
                <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? ''); ?>" class="full-width-row">

                <label>State:</label>
                <input type="text" name="state" value="<?= htmlspecialchars($user['state'] ?? ''); ?>">

                <label>City:</label>
                <input type="text" name="city" value="<?= htmlspecialchars($user['city'] ?? ''); ?>">

                <label>Postcode:</label>
                <input type="text" name="postcode" value="<?= htmlspecialchars($user['postcode'] ?? ''); ?>">

                <div class="button-section">
                    <input type="submit" name="update" value="Update" class="btn-update">
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    const logoToggle = document.getElementById('logoToggle');
    const panelSidebar = document.getElementById('panelSidebar');

    logoToggle.addEventListener('click', function(event) {
        event.stopPropagation();
        panelSidebar.classList.toggle('active');
    });

    document.addEventListener('click', function(event) {
        if (!panelSidebar.contains(event.target) && !logoToggle.contains(event.target)) {
            panelSidebar.classList.remove('active');
        }
    });

    document.getElementById('profile_picture').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>

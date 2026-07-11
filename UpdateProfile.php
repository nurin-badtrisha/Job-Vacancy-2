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
            background-color: #b4bcf4; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; 
            min-height: 100vh;
        }

        
        .nav-header {
            background-color: #4f0f69; 
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        
        .logo-trigger-box {
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .logo-trigger-box:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-logo-img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: contain;
        }

        .header-title {
            color: white;
            font-size: 1.4rem;
            font-weight: 500;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
		
		
        .sidebar-menu {
            position: absolute;
            top: 70px;
            left: -260px; 
            width: 240px;
            background-color: #4A154B;
            box-shadow: 4px 8px 25px rgba(0, 0, 0, 0.3);
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
            font-size: 1rem;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-left 0.2s;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu a.active-view {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #B4A4EB;
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
            background-color: #512b7c;
            width: 100%;
            max-width: 900px;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
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
            color: white;
            font-size: 18px;
            font-weight: 500;
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
            border: 3px solid #ff99bb; 
            background-color: #ffccd5;
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
            transition: color 0.2s;
        }

        .edit-label:hover {
            color: #ff99bb;
        }
      
        .form-section {
            flex: 1;
            display: grid;
            grid-template-columns: 120px 1fr 120px 1fr; 
            gap: 15px 15px;
            align-items: center;
        }

        .form-section label {
            color: white;
            font-weight: bold;
            font-size: 13px;
            white-space: nowrap;
        }

        .form-section input[type="text"],
        .form-section input[type="email"],
        .form-section input[type="password"],
        .form-section input[type="date"],
        .form-section select {
            width: 100%;
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            background-color: white;
            color: #333;
            font-size: 13px;
            box-sizing: border-box;
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
            gap: 15px;
            color: white;
            font-size: 13px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .radio-group input[type="radio"] {
            margin: 0;
            accent-color: #ff99bb;
        }

        .button-section {
            grid-column: span 4;
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .btn-update {
            background-color: #6320a0; 
            color: white;
            font-weight: bold;
            font-size: 14px;
            padding: 10px 40px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-update:hover {
            background-color: #7b2cb7;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

<div class="nav-header">
    <div class="logo-trigger-box" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    </div>
    <div class="header-title">Update Profile</div>
    <div></div> </div>

<div class="sidebar-menu" id="panelSidebar">
	<a href="updateprofile.php" class="active-view">Update Profile</a>
	<a href="jobSearching.php">Job Vacancy</a>
	<a href="applicationStatus.php">Application Status</a>
	<div class="sidebar-divider"></div>
	<a href="login.php" style="color: #FF8A8A; font-size: 0.95rem;">Log Out</a>
</div>
	
<div class="main-content">
    <form method="POST" action="updateprofileprocess.php" enctype="multipart/form-data" style="width: 100%; max-width: 900px;">
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
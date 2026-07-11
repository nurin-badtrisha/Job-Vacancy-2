<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Applicant</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", sans-serif;
    }

    body {
        background-color: #b9acf3;
    }

    
    .top-bar {
        background-color: #5a2d82;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 40px;
        color: white;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        max-height: 45px;
        width: auto;
    }

    .about {
        font-size: 16px;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.15);
        padding: 6px 15px;
        border-radius: 20px;
        cursor: pointer;
    }

   
    .page-title {
        max-width: 85%;
        margin: 40px auto 15px auto;
        font-size: 36px;
        color: white;
        font-weight: bold;
    }

    /* Error Banner Style */
    .error-alert {
        background-color: #f8d7da;
        color: #721c24;
        border: 3px solid #721c24;
        padding: 15px;
        width: 85%;
        max-width: 1100px;
        margin: 0 auto 20px auto;
        border-radius: 15px;
        font-weight: bold;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

   
    .form-container {
        background-color: #512b7c;
        width: 85%;
        max-width: 1100px;
        margin: 0 auto 50px auto;
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.3);
        color: white;
    }

   
    .form-flex-wrapper {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

   
    .profile-upload-side {
        width: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding-top: 20px;
    }

    .avatar-wrapper {
        width: 170px;
        height: 170px;
        background: #dfe2e6;
        border-radius: 50%;
        border: 4px solid #b9acf3;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }

    .avatar-wrapper:hover {
        transform: scale(1.03);
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .upload-hint {
        margin-top: 15px;
        font-size: 16px;
        font-weight: bold;
        color: #e2d5f3;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 15px;
        border-radius: 20px;
        transition: background 0.2s;
    }

    .upload-hint:hover {
        background: rgba(255, 255, 255, 0.2);
    }

  
    .form-grid {
        flex-grow: 1;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 30px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

   
    .form-group.full-width {
        grid-column: span 2;
    }

   
    .form-group.three-columns {
        grid-column: span 2;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    label {
        display: block;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #e2d5f3;
    }

    input, select {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 2px solid transparent;
        outline: none;
        background-color: #ffffff;
        color: #2d2525;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    input:focus, select:focus {
        border-color: #b9acf3;
        box-shadow: 0 0 10px rgba(185, 172, 243, 0.5);
    }

   
    .radio-container {
        display: flex;
        align-items: center;
        height: 100%;
        padding-top: 10px;
        font-size: 16px;
        font-weight: 600;
        gap: 30px;
    }

    .radio-container input[type="radio"] {
        width: auto;
        margin-right: 8px;
        margin-left: 15px;
        cursor: pointer;
        transform: scale(1.2);
    }
    
    .radio-container input[type="radio"]:first-child {
        margin-left: 0;
    }

   
    .action-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 35px;
    }

    .submit-btn {
        background-color: #3b145a;
        color: white;
        border: 2px solid #6a3fa0;
        padding: 12px 50px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #6a3fa0;
        border-color: #b9acf3;
        transform: translateY(-2px);
    }

    
    @media (max-width: 900px) {
        .form-flex-wrapper {
            flex-direction: column;
            align-items: center;
        }
        .profile-upload-side {
            width: 100%;
            margin-bottom: 20px;
        }
        .form-grid {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width, 
        .form-group.three-columns {
            grid-column: span 1;
        }
        .form-group.three-columns {
            grid-template-columns: 1fr;
        }
        .page-title, .form-container {
            width: 90%;
            padding: 25px;
        }
    }
</style>
</head>

<body>

<div class="top-bar">
    <div class="logo">
        <img src="startIt.png" alt="StartIT Logo">
    </div>
</div>

<div class="page-title">Register</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error-alert">
        ⚠️ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form class="form-container" action="registerUserProcess.php" method="POST" enctype="multipart/form-data">

    <div class="form-flex-wrapper">
        
        <div class="profile-upload-side">
            <label for="profileImageInput" class="avatar-wrapper">
                <img id="avatarPreview" src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile Preview">
            </label>
            <label for="profileImageInput" class="upload-hint">Add Picture</label>
            <input type="file" id="profileImageInput" name="profile_picture" accept="image/*" style="display: none;">
        </div>

        <div class="form-grid">
            
            <div class="form-group full-width">
                <label>Full Name:</label>
                <input type="text" name="fullname" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label>IC Number:</label>
                <input type="text" name="icnumber" placeholder="e.g. 04XXXX-XX-XXXX" required>
            </div>

            <div class="form-group">
                <label>Education Level:</label>
                <select name="education" required>
                    <option value="">-- Select Education Level --</option>
                    <option value="SPM">SPM</option>
                    <option value="DIPLOMA">DIPLOMA</option>
                    <option value="DEGREE">DEGREE</option>
                    <option value="MASTER">MASTER</option>
                    <option value="PHD">PHD</option>
                </select>
            </div>

            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" required>
            </div>

            <div class="form-group">
                <label>Skills:</label>
                <input type="text" name="skills" placeholder="e.g. PHP, HTML, CSS, Java" required>
            </div>

            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="email" placeholder="name@example.com" required>
            </div>

            <div class="form-group">
                <label>Years of Experience:</label>
                <input type="number" name="experience" min="0" placeholder="e.g. 2" required>
            </div>

            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="phone" placeholder="e.g. 0123456789" required>
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" placeholder="Choose a unique username" required>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <div class="radio-container">
                    <label><input type="radio" name="gender" value="Female" required> Female</label>
                    <label><input type="radio" name="gender" value="Male"> Male</label>
                </div>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="form-group full-width">
                <label>Home Address:</label>
                <input type="text" name="address" placeholder="Unit, Street name, Neighborhood area" required>
            </div>

            <div class="form-group three-columns">
                <div>
                    <label>State:</label>
                    <select name="state" required>
                        <option value="">-- Select State --</option>
                        <option value="JOHOR">JOHOR</option>
                        <option value="KEDAH">KEDAH</option>
                        <option value="KELANTAN">KELANTAN</option>
                        <option value="MELAKA">MELAKA</option>
                        <option value="NEGERI SEMBILAN">NEGERI SEMBILAN</option>
                        <option value="PAHANG">PAHANG</option>
                        <option value="PENANG">PENANG</option>
                        <option value="PERAK">PERAK</option>
                        <option value="PERLIS">PERLIS</option>
                        <option value="TERENGGANU">TERENGGANU</option>
                        <option value="SELANGOR">SELANGOR</option>
                        <option value="SABAH">SABAH</option>
                        <option value="SARAWAK">SARAWAK</option>
                        <option value="KUALA LUMPUR">KUALA LUMPUR</option>
                        <option value="LABUAN">LABUAN</option>
                        <option value="PUTRAJAYA">PUTRAJAYA</option>
                    </select>
                </div>
                
                <div>
                    <label>City:</label>
                    <input type="text" name="city" placeholder="e.g. Cheras" required>
                </div>

                <div>
                    <label>Postcode:</label>
                    <input type="text" name="postcode" placeholder="e.g. 43200" inputmode="numeric" pattern="[0-9]{5}" minlength="5" maxlength="5" required>
                </div>
            </div>
            
        </div>
    </div>

    <div class="action-container">
        <button type="submit" name="Submit" class="submit-btn">Submit</button>
    </div>

</form>

<script>
const fileInput = document.getElementById('profileImageInput');
const avatarPreview = document.getElementById('avatarPreview');
const registrationForm = document.querySelector('.form-container');

fileInput.addEventListener('change', function() {
    const chosenFile = this.files[0];
    if (chosenFile) {
        const reader = new FileReader();
        reader.onload = function(e) {
            avatarPreview.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(chosenFile);
    }
});

registrationForm.addEventListener('submit', function(e) {
    if (fileInput.files.length === 0) {
        e.preventDefault();
        alert('Please attach a profile picture before submitting your registration!');
        
        const avatarWrapper = document.querySelector('.avatar-wrapper');
        avatarWrapper.style.borderColor = '#721c24';
        avatarWrapper.style.backgroundColor = '#f8d7da';
    }
});
</script>

</body>
</html>
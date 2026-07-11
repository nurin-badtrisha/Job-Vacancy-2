<?php 
session_start();
include("dbconn.php");

if(isset($_POST['Submit'])){

    // Sanitize user inputs to protect the query format
    $full_name        = mysqli_real_escape_string($dbconn, $_POST['fullname']);
    $icnumber         = mysqli_real_escape_string($dbconn, $_POST['icnumber']);
    $education_level  = mysqli_real_escape_string($dbconn, $_POST['education']);
    $date_of_birth    = mysqli_real_escape_string($dbconn, $_POST['dob']);
    $skills           = mysqli_real_escape_string($dbconn, $_POST['skills']);
    $email            = mysqli_real_escape_string($dbconn, $_POST['email']);
    $experience_years = mysqli_real_escape_string($dbconn, $_POST['experience']);
    $phone_number     = mysqli_real_escape_string($dbconn, $_POST['phone']);
    $username         = mysqli_real_escape_string($dbconn, $_POST['username']);
    $gender           = mysqli_real_escape_string($dbconn, $_POST['gender']);
    $password         = mysqli_real_escape_string($dbconn, $_POST['password']); 
    $address          = mysqli_real_escape_string($dbconn, $_POST['address']);
    $state            = mysqli_real_escape_string($dbconn, $_POST['state']);
    $city             = mysqli_real_escape_string($dbconn, $_POST['city']);
    $postcode         = mysqli_real_escape_string($dbconn, $_POST['postcode']);
	
    // === NEW: 5-Digit Postcode Validation ===
    // Remove extra spaces if any exist
    $clean_postcode = trim($postcode); 
    if (strlen($clean_postcode) !== 5 || !is_numeric($clean_postcode)) {
        $_SESSION['error'] = "Invalid postcode length";
        header("Location: registeruser.php");
        exit(); 
    }
    // =======================================

    // 1. Check if the username already exists in the applicant table
    $check_user_sql = "SELECT username FROM applicant WHERE username = '$username'";
    $check_user_result = mysqli_query($dbconn, $check_user_sql);

    if(mysqli_num_rows($check_user_result) > 0) {
        // Username is taken -> Alert and go back immediately
        echo "<script>
                alert('This username was taken, please choose another username');
                window.history.back();
              </script>";
        exit(); // Terminates the script immediately so no file is uploaded or account created
    }

    // 2. Process file upload only if username is verified unique
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $imageName = $_FILES['profile_picture']['name'];
        $tmpName   = $_FILES['profile_picture']['tmp_name'];

        $uniqueImageName = time() . "_" . $imageName;
        $target_dir = "profile_pics/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $folder = $target_dir . $uniqueImageName;
        move_uploaded_file($tmpName, $folder);
    } else {
        $folder = NULL; 
    }
	
    // 3. Insert new user registration details
    $sql = "INSERT INTO applicant
    (full_name, icnumber, education_level, date_of_birth, skills, 
    email, experience_years, phone_number, username, gender, 
    password, address, state, city, postcode, profile_picture) 
    VALUES
    ('$full_name', '$icnumber', '$education_level', '$date_of_birth', '$skills',
    '$email', '$experience_years', '$phone_number', '$username', '$gender',
    '$password', '$address', '$state', '$city', '$clean_postcode', '$folder')";
	
    $query = mysqli_query($dbconn, $sql);
	
    if($query) {
        // Clear any old errors upon successful sign-up
        unset($_SESSION['error']);
        echo "<script>
                alert('Registration Successfully! You can start log in.');
                window.location.href = 'Login.php';
              </script>";
    } else {
        echo 'Database Error: ' . mysqli_error($dbconn);
    }
}

mysqli_close($dbconn);
?>
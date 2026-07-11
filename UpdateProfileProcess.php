<?php
session_start();
include('dbconn.php'); 

if (!isset($conn) && isset($dbconn)) {
    $conn = $dbconn;
}

$applicant_id = $_SESSION['applicant_id'] ?? '';

if (empty($applicant_id)) {
    die("Error: Session expired or invalid. Please log in again.");
}

if (isset($_POST['update'])) {
    
    $full_name        = $conn->real_escape_string(trim($_POST['full_name']));
    $phone_number     = $conn->real_escape_string(trim($_POST['phone_number']));
    $date_of_birth    = $conn->real_escape_string(trim($_POST['date_of_birth']));
    $gender           = $conn->real_escape_string(trim($_POST['gender']));
    $education_level  = $conn->real_escape_string(trim($_POST['education_level']));
    $experience_years = $conn->real_escape_string(trim($_POST['experience_years']));
    $address          = $conn->real_escape_string(trim($_POST['address']));
    $username         = $conn->real_escape_string(trim($_POST['username']));
    $email            = $conn->real_escape_string(trim($_POST['email']));
    $icnumber         = $conn->real_escape_string(trim($_POST['icnumber']));
    $skills           = $conn->real_escape_string(trim($_POST['skills']));
    $state            = $conn->real_escape_string(trim($_POST['state']));
    $city             = $conn->real_escape_string(trim($_POST['city']));
    $postcode         = $conn->real_escape_string(trim($_POST['postcode']));
    
    $image_query = "";

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "profile_pics/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name   = time() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $image_query = ", profile_picture = '$target_file'";
            }
        }
    }

   
    $password_query = "";
    if (!empty($_POST['password'])) {
        $plain_password = $conn->real_escape_string($_POST['password']);
        $password_query = ", password = '$plain_password'";
    }

    $sql = "UPDATE applicant SET 
            username = '$username',
            full_name = '$full_name',
            phone_number = '$phone_number',
            date_of_birth = '$date_of_birth',
            gender = '$gender',
            education_level = '$education_level',
            experience_years = '$experience_years',
            address = '$address',
            email = '$email',
            icnumber = '$icnumber',
            skills = '$skills',
            state = '$state',
            city = '$city',
            postcode = '$postcode'
            $image_query
            $password_query
            WHERE applicant_id = '$applicant_id'";

    if ($conn->query($sql)) {
        $_SESSION['username'] = $username;
        echo "<script>alert('PROFILE UPDATED SUCCESSFULLY !!'); window.location='updateprofile.php';</script>";
        exit();
    } else {
        echo "<script>alert('ERROR DETECTED !! " . $conn->real_escape_string($conn->error) . "'); window.location='updateprofile.php';</script>";
        exit();
    }
} else {
    header("Location: updateprofile.php");
    exit();
}
?>
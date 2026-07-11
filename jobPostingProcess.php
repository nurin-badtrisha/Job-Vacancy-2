<?php
session_start();
include "dbconn.php";

if (!isset($_SESSION['username'])) {
    die("Error: Please log in first.");
}

if (isset($_POST['submit'])) {
    $required_fields = [
        'job_position', 'job_description', 'experience', 'education', 
        'salary_range', 'job_location', 'language', 'working_days', 'company_name'
    ];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === "") {
            $_SESSION['error'] = "All fields are required. Please fill out the entire form.";
            header("Location: jobposting.php");
            exit();
        }
    }

    if (!isset($_FILES['job_image']) || $_FILES['job_image']['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['error'] = "Please upload a company logo or job banner image.";
        header("Location: jobposting.php");
        exit();
    }

    if ($_FILES['job_image']['error'] !== 0) {
        if ($_FILES['job_image']['error'] === UPLOAD_ERR_INI_SIZE) {
            $_SESSION['error'] = "The uploaded file exceeds the maximum file size permitted by the server configuration.";
        } else {
            $_SESSION['error'] = "There was an error uploading your image. Please try another file.";
        }
        header("Location: jobposting.php");
        exit();
    }

    $imageName = $_FILES['job_image']['name'];
    $tmpName   = $_FILES['job_image']['tmp_name'];
    $fileExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($fileExt, $allowedExtensions)) {
        $_SESSION['error'] = "Invalid image type. Only JPG, JPEG, PNG, GIF, and WEBP formats are allowed.";
        header("Location: jobposting.php");
        exit();
    }

    $username = $_SESSION['username'];
    $id_lookup_query = "SELECT pic_id FROM person_in_charge WHERE username = ?";
    $stmt_lookup = mysqli_prepare($dbconn, $id_lookup_query);
    mysqli_stmt_bind_param($stmt_lookup, "s", $username);
    mysqli_stmt_execute($stmt_lookup);
    $result = mysqli_stmt_get_result($stmt_lookup);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $pic_id = $row['pic_id']; 
    } else {
        die("Error: Logged in user does not exist in the Person in Charge table.");
    }
    mysqli_stmt_close($stmt_lookup);

    $job_position        = trim($_POST['job_position']);
    $job_description     = trim($_POST['job_description']);
    $experience          = trim($_POST['experience']);
    $education           = trim($_POST['education']);
    $salary_range        = trim($_POST['salary_range']);
    $job_location        = trim($_POST['job_location']);
    $language_preference = trim($_POST['language']); 
    $working_days        = trim($_POST['working_days']);
    $company_name        = trim($_POST['company_name']);
    $unique_image_name = uniqid() . "_" . $imageName;
    $folder            = "jobImages/" . $unique_image_name;

    if (!is_dir('jobImages/')) {
        mkdir('jobImages/', 0755, true);
    }

    if (move_uploaded_file($tmpName, $folder)) {
        $sql = "INSERT INTO job_posting 
                (pic_id, job_position, job_description, experience, education, salary_range, job_location, language_preference, working_days, company_name, job_image)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($dbconn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt, 
                "issssssssss", 
                $pic_id, 
                $job_position, 
                $job_description, 
                $experience, 
                $education, 
                $salary_range, 
                $job_location, 
                $language_preference, 
                $working_days, 
                $company_name, 
                $folder
            );

            $query = mysqli_stmt_execute($stmt);
        
            if ($query) {
                unset($_SESSION['error']);
                echo "<script>
                        alert('Job posting Successful');
                        window.location.href = 'pic.php';
                      </script>";
            } else {
                die("Database Error: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        } else {
            die("Preparation Error: " . mysqli_error($dbconn));
        }
    } else {
        $_SESSION['error'] = "Failed to save the uploaded image files securely to server file paths.";
        header("Location: jobposting.php");
        exit();
    }
}

mysqli_close($dbconn);
?>
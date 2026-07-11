<?php
session_start();

$host       = "localhost";
$db_user    = "root";         
$db_pass    = "";             
$db_name    = "startit"; 

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Failed Database Connection !! : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_user  = trim($_POST['username']);
$password    = trim($_POST['password']);
$chosen_role = trim($_POST['user_role']);

if ($chosen_role == "admin") {

    $sql = "SELECT * FROM admin
            WHERE username='$input_user'
            AND password='$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['admin_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = "admin";

        header("Location: adminReport.php");
        exit();
    }
}

elseif ($chosen_role == "applicant") {

    $sql = "SELECT * FROM applicant
            WHERE username='$input_user'
            AND password='$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['applicant_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = "applicant";

        header("Location: jobSearching.php");
        exit();
    }
}

elseif ($chosen_role == "person_in_charge") {

    $sql = "SELECT * FROM person_in_charge
            WHERE username='$input_user'
            AND password='$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['pic_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = "person_in_charge";

        header("Location: pic.php");
        exit();
    }
}

header("Location: Login.php?error=Wrong username, password or role");
exit();
}
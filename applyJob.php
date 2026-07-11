<?php
session_start();
include("dbconn.php");

if (isset($_GET['id'])) {
    $job_id = mysqli_real_escape_string($dbconn, $_GET['id']);
} else {
    die("Error: No job ID provided.");
}

$sql = "SELECT * FROM job_posting WHERE job_id = '$job_id'";
$query = mysqli_query($dbconn, $sql);

if (!$query) {
    die("Database Error: " . mysqli_error($dbconn));
}

if (mysqli_num_rows($query) == 0) {
    die("Error: Job vacancy not found.");
}

$row = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Apply Job</title>
<style>
    body {
        background-color: #F8F9FA;
        font-family: "Segoe UI", sans-serif;
        color: #2D2D2D;
        min-height: 100vh;
        padding: 20px 0;
    }

    .container {
        width: 90%;
        max-width: 850px;
        margin: 40px auto;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #EAEAEA;
    }

    img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #F0F0F0;
    }

    h1 {
        margin-top: 25px;
        color: #4A0E4E;
        font-size: 2rem;
        font-weight: 700;
    }

    .detail {
        margin-top: 15px;
        font-size: 16px;
        color: #4A5568;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .description-text {
        margin-top: 12px;
        font-size: 15px;
        line-height: 1.7; 
        color: #4A5568;
        background: #F8F9FA;
        padding: 25px;
        border-radius: 12px;
        border-left: 5px solid #4A0E4E;
        white-space: pre-line; 
    }

    .resume-box {
        margin-top: 35px;
        border-top: 1px solid #E2E8F0;
        padding-top: 25px;
    }

    .resume-box label {
        font-size: 16px;
        font-weight: 700;
        color: #4A0E4E;
        display: block;
        margin-bottom: 12px;
    }

    .resume-box input[type="file"] {
        font-size: 14px;
        color: #4A5568;
    }

    .form-actions-row {
        display: flex;
        align-items: center;
        gap: 15px; 
        margin-top: 30px;
    }

    .send-btn {
        background: #4A0E4E;
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(74, 14, 78, 0.2);
        transition: background-color 0.2s, transform 0.1s;
    }

    .send-btn:hover {
        background: #350A38;
        transform: translateY(-1px);
    }

    .back-btn {
        background: none;
        color: #4A0E4E;
        border: 1px solid #4A0E4E;
        padding: 12px 40px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 25px;
        cursor: pointer;
        transition: background-color 0.2s, transform 0.1s;
    }

    .back-btn:hover {
        background: rgba(74, 14, 78, 0.05);
        transform: translateY(-1px);
    }
</style>
</head>
<body>

<div class="container">

    <img src="<?php echo htmlspecialchars(!empty($row['job_image']) ? $row['job_image'] : 'https://cdn-icons-png.flaticon.com/512/685/685655.png'); ?>" alt="Job Image">

    <h1>
        <?php echo htmlspecialchars($row['job_position']); ?>
    </h1>

    <div class="detail">
        📍 <strong>Location:</strong> <?php echo htmlspecialchars($row['job_location']); ?>
    </div>

    <div class="detail">
        💰 <strong>Salary:</strong> RM <?php echo htmlspecialchars($row['salary_range']); ?>
    </div>

    <div class="detail">
        🗣 <strong>Language:</strong> <?php echo htmlspecialchars($row['language_preference']); ?>
    </div>

    <div class="detail">
        🎓 <strong>Education:</strong> <?php echo htmlspecialchars($row['education']); ?>
    </div>

    <div class="detail">
        💼 <strong>Experience:</strong> <?php echo htmlspecialchars($row['experience']); ?>
    </div>

    <div class="detail">
        📅 <strong>Working Days:</strong> <?php echo htmlspecialchars($row['working_days']); ?>
    </div>

    <div class="detail" style="margin-top: 25px; display: block;">
        📝 <strong>Description:</strong>
        <div class="description-text">
            <?php echo nl2br(htmlspecialchars($row['job_description'])); ?>
        </div>
    </div>

    <form action="sendApplication.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($row['job_id']); ?>">

        <div class="resume-box">
            <label>Upload Resume:</label>
            <input type="file" name="resume" required>
        </div>

        <div class="form-actions-row">
            <button type="submit" class="send-btn">SEND</button>
            <button type="button" class="back-btn" onclick="window.location.href='jobSearching.php'">BACK</button>
        </div>

    </form>

</div>

</body>
</html>

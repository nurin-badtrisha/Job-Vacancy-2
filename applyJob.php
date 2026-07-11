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
body{
    background:#b7a9f0;
    font-family:"Segoe UI", sans-serif;
}

.container{
    width:70%;
    max-width: 850px;
    margin:40px auto;
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

img{
    width:100%;
    height:300px;
    object-fit:cover;
    border-radius:15px;
}

h1{
    margin-top:20px;
    color: #2d2525;
}

.detail{
    margin-top:15px;
    font-size:18px;
    color: #333;
}


.description-text {
    margin-top: 10px;
    font-size: 16px;
    line-height: 1.7; 
    color: #444;
    background: #fdfbff;
    padding: 20px;
    border-radius: 12px;
    border-left: 5px solid #5a2d82;
    white-space: pre-line; 
}

.resume-box{
    margin-top:30px;
    border-top: 1px solid #ddd;
    padding-top: 20px;
}

.resume-box label {
    font-size: 18px;
    font-weight: bold;
    color: #2d2525;
}


.form-actions-row {
    display: flex;
    align-items: center;
    gap: 15px; /* Adds space separating the side-by-side buttons */
    margin-top: 20px;
}

.send-btn{
    background:#5a2d82;
    color:white;
    border:none;
    padding:12px 40px;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
    font-weight: bold;
    transition: 0.2s ease;
}

.send-btn:hover{
    background:#6a3fa0;
    transform: translateY(-2px);
}


.back-btn {
    background: #d1c6ec;
    color: #2d2525;
    border: 2px solid #2d2525;
    padding: 12px 35px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s ease;
}

.back-btn:hover {
    background: #b7a9f0;
    transform: translateY(-2px);
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

    <div class="detail" style="margin-top: 25px;">
        📝 <strong>Description:</strong>
        <div class="description-text">
            <?php echo nl2br(htmlspecialchars($row['job_description'])); ?>
        </div>
    </div>

    <form action="sendApplication.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($row['job_id']); ?>">

        <div class="resume-box">
            <label>Upload Resume:</label>
            <br><br>
            <input type="file" name="resume" required>
        </div>

        <div class="form-actions-row">
            <button type="submit" class="send-btn">
                SEND
            </button>

            <button type="button" class="back-btn" onclick="window.location.href='jobSearching.php'">
                BACK
            </button>
        </div>

    </form>

</div>

</body>
</html>
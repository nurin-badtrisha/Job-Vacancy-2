<?php
session_start();
$servername = "localhost";
$username   = "root"; 
$password   = "";      
$dbname     = "startit"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection to database failed: " . $conn->connect_error);
}


if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

$session_username = $_SESSION['username'];


$safe_username = $conn->real_escape_string($session_username);
$pic_query = "SELECT pic_id FROM person_in_charge WHERE username = '$safe_username'";
$pic_result = $conn->query($pic_query);

if ($pic_result && $pic_result->num_rows > 0) {
    $pic_row = $pic_result->fetch_assoc();
    $current_pic_id = $pic_row['pic_id'];
} else {
    die("Error: Person In Charge identity could not be verified in the registry.");
}


if (isset($_POST['delete_job_id'])) {
    $delete_id = intval($_POST['delete_job_id']);
    
    
    $delete_sql = "DELETE FROM job_posting WHERE job_id = ? AND pic_id = ?";
    $stmt = $conn->prepare($delete_sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $delete_id, $current_pic_id);
        if ($stmt->execute()) {
            echo "<script>alert('Job post removed successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        } else {
            echo "<script>alert('Error executing post removal: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIC Dashboard</title>
    <link rel="stylesheet" href="dashboard-style.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body, html {
            height: 100%;
            background-color: #f7f5f0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        
        .left-col {
            width: 50%;
            background-color: #FAF6F0; 
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .header-logo { 
            display: flex;          
            align-items: center;
            gap: 12px;
        }

        .header-logo img {
            width: 45px;
            max-height: 45px;
        }

        .logo-text {
            font-family: serif;
            font-size: 20px;
            font-weight: bold;
            color: #111;
        }

        .left-content {
            margin-top: 15%;
            max-width: 450px;
            z-index: 2;
        }

        .left-content h1 {
            font-size: 3.2rem;
            color: #584137; 
            line-height: 1.15;
            margin-bottom: 25px;
        }

        .left-content .subtitle {
            color: #72625A;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .building-bg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80%;
            height: 40%;
            background: linear-gradient(135deg, #e3d5ca 0%, #d5bdaf 100%);
            border-top-right-radius: 12px;
            opacity: 0.6;
            z-index: 1;
        }

        
        .right-col {
            width: 50%;
            background-color: #B4A4EB; 
            padding: 40px 60px;
            display: flex; 
            flex-direction: column;
            align-items: flex-end;
        }

        .top-nav {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-bottom: 50px;
        }

        .btn {
            display: inline-block;
            padding: 12px 28px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 6px;
            letter-spacing: 0.5px;
            cursor: pointer;
            border: none;
            transition: transform 0.2s, opacity 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-primary {
            background-color: #4A154B; 
            color: white;
        }

        .btn-secondary {
            background-color: #4A154B;
            color: white;
        }

        .feed-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 500px;
            width: 100%;
        }

        .section-title {
            color: #4A154B;
            font-size: 1.6rem;
            margin-bottom: 10px;
            align-self: flex-start;
        }

        .job-card {
            background-color: #FFFDF9;
            border-radius: 12px;
            padding: 20px 25px; 
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            transition: transform 0.2s;
            width: 100%;
        }

        .job-card:hover {
            transform: scale(1.02);
        }

        .card-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 6px;
        }

        .badge {
            align-self: flex-start;
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
        }

        .badge-orange {
            background-color: #FFEEDB;
            color: #D48C46;
        }

        .card-details h3 {
            font-size: 1.3rem;
            color: #222;
            font-weight: bold;
            margin-top: 2px;
        }

        .location {
            color: #666;
            font-size: 0.9rem;
        }

        .card-meta {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
            text-align: right;
        }

        .time-stamp {
            color: #b0b0b0;
            font-size: 0.85rem;
        }

        .btn-card-delete {
            background: none;
            border: none;
            color: #c62828;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            margin-top: 4px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .btn-card-delete:hover {
            color: #b71c1c;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <div class="left-col" id="leftColumn">
            <div class="header-logo">
                <img src="startIt logo.jpg" alt="Logo">
                <span class="logo-text">Person In Charge</span>
            </div>

            <div class="left-content">
                <h1>Post Your Job<br>Vacancy Here!</h1>
                <p class="subtitle">
                    Start IT is the platform to all company posted and review the applicant in IT field easily.
                </p>
            </div>
            
            <div class="building-bg"></div>
        </div>

        <div class="right-col" id="rightColumn">
            
            <div class="top-nav">
                <a href="jobPosting.php" class="btn btn-primary">JOB POST</a>
                <a href="applicantStatus.php" class="btn btn-secondary">APPLICANT</a>
                <a href="Login.php" class="btn btn-secondary">LOG OUT</a>
            </div>

            <div class="feed-section">
                <h2 class="section-title">History Post</h2>

                <?php
                
                $query = "SELECT * FROM job_posting WHERE pic_id = '$current_pic_id' ORDER BY job_id DESC"; 
                $result = $conn->query($query); 

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { 
                        
                        $time_display = "";
                        if (!empty($row['posted_date'])) {
                            $time_posted = strtotime($row['posted_date']);
                            $time_diff = time() - $time_posted;
                            
                            if ($time_diff < 60) {
                                $time_display = "Just now";
                            } elseif ($time_diff < 3600) {
                                $time_display = round($time_diff / 60) . " min ago";
                            } elseif ($time_diff < 86400) {
                                $time_display = round($time_diff / 3600) . " hour ago";
                            } else {
                                $time_display = round($time_diff / 86400) . " day ago";
                            }
                        }
                        ?>
                        
                        <div class="job-card">
                            <div class="card-details">
                                <span class="badge badge-orange"><?php echo htmlspecialchars($row['job_position']); ?></span>
                                <h3><?php echo htmlspecialchars($row['company_name']); ?></h3>
                                <p class="location"><?php echo htmlspecialchars($row['job_location']); ?></p>
                            </div>
                            
                            <div class="card-meta">
                                <span class="time-stamp"><?php echo $time_display; ?></span>
                                
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this job post?');">
                                    <input type="hidden" name="delete_job_id" value="<?php echo $row['job_id']; ?>">
                                    <button type="submit" class="btn-card-delete">Delete</button>
                                </form>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p style='color: white; font-style: italic;'>You haven't posted any job vacancies yet.</p>";
                }
                $conn->close();
                ?>

            </div>

        </div>

    </div>

</body>
</html>
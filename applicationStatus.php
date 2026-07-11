<?php

session_start();

include("dbconn.php");



if (!isset($_SESSION['username'])) {

    die("Error: Please log in as an applicant first to view your application progress.");

}



$username = $_SESSION['username'];



$id_query = "SELECT applicant_id FROM applicant WHERE username = '$username'";

$id_result = mysqli_query($dbconn, $id_query);



if ($user_row = mysqli_fetch_assoc($id_result)) {

    $applicant_id = $user_row['applicant_id'];

} else {

    die("Error: Applicant account not found in the database registry.");

}



if (isset($_POST['cancel_application_id'])) {

    $job_id_to_cancel = intval($_POST['cancel_application_id']);

    

    $delete_sql = "DELETE FROM apply_job WHERE applicant_id = ? AND job_id = ?";

    $stmt = mysqli_prepare($dbconn, $delete_sql);

    

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "ii", $applicant_id, $job_id_to_cancel);

        if (mysqli_stmt_execute($stmt)) {

            echo "<script>alert('Application deleted successfully.'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";

        } else {

            echo "<script>alert('Error deleting application: " . mysqli_error($dbconn) . "');</script>";

        }

        mysqli_stmt_close($stmt);

    }

}



$sql = "SELECT aj.applicant_status AS status, jp.job_id, jp.job_position, jp.company_name 

        FROM apply_job aj

        JOIN job_posting jp ON aj.job_id = jp.job_id

        WHERE aj.applicant_id = '$applicant_id'

        ORDER BY aj.applied_date DESC";



$query_result = mysqli_query($dbconn, $sql);



$applications = [];

if ($query_result) {

    while ($row = mysqli_fetch_assoc($query_result)) {

        $applications[] = [

            'job_id'    => $row['job_id'],

            'job_title' => $row['job_position'],

            'company'   => $row['company_name'],

            'status'    => $row['status']

        ];

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Application Status</title>

    <style>

        * {

            box-sizing: border-box;

            margin: 0;

            padding: 0;

            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }



        body {

            background-color: #B4A4EB;

            min-height: 100vh;

            display: flex;

            flex-direction: column;

            align-items: center;

        }



        /* Navigation Header */

        .nav-header {

            background-color: #4F0F69; 

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



        .header-title {

            color: #FFFFFF;

            font-size: 1.4rem;

            font-weight: 500;

            position: absolute;

            left: 50%;

            transform: translateX(-50%);

        }



        /* Logo Box Toggle Trigger */

        .logo-trigger-box {

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 6px;

            border-radius: 8px;

            transition: background-color 0.2s, transform 0.1s;

        }



        .logo-trigger-box:hover {

            background-color: rgba(255, 255, 255, 0.15);

            transform: scale(1.03);

        }



        .nav-logo-img {

            width: 45px;

            height: 45px;

            display: block;

            object-fit: contain;

        }



        /* Sidebar Menu Navigation */

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

            z-index: 5;

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

            border-left: 4px solid #B4A4EB;

            font-weight: bold;

        }



        .sidebar-divider {

            height: 1px;

            background-color: rgba(255, 255, 255, 0.15);

            margin: 10px 25px;

        }



        /* Main Content Layout Frame */

        .laptop-mockup-frame {

            width: 100%;

            max-width: 1100px;

            padding: 45px 20px;

        }



        .status-canvas {

            background-color: #FFFDF9;

            border-radius: 35px;

            padding: 50px 45px;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);

        }



        /* Application Grid Layout */

        .status-grid {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 30px;

            margin-bottom: 40px;

        }



        /* Individual Card Component */

        .status-box {

            background-color: #ECEAFB; 

            border-radius: 12px;

            padding: 35px 20px;

            text-align: center;

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 12px;

            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);

            justify-content: space-between; 

        }



        .company-name {

            font-size: 1.15rem;

            font-weight: 700;

            color: #2D2D2D;

        }



        .badge {

            font-size: 0.75rem;

            font-weight: 700;

            padding: 4px 14px;

            border-radius: 20px;

            letter-spacing: 0.5px;

            text-transform: uppercase;

            display: inline-block;

            margin: 5px 0;

        }



        .badge-applied {

            background-color: #F5C2ED;

            color: #A34E97;

        }



        .job-title {

            font-size: 0.95rem;

            color: #555555;

            font-weight: 500;

            margin-top: 4px;

        }



        .process-text {

            font-size: 0.8rem;

            font-weight: bold;

            letter-spacing: 0.5px;

            margin-top: 5px;

            text-transform: uppercase;

        }



        .interview-note {

            font-size: 0.8rem;

            color: #2A9D8F;

            font-weight: 500;

            margin-top: 8px;

            line-height: 1.4;

            font-style: italic;

        }



        /* Card Interactive Button */

        .btn-card-delete {

            background: none;

            border: none;

            color: #C62828;

            font-size: 0.85rem;

            font-weight: 600;

            cursor: pointer;

            padding: 5px 0;

            margin-top: 4px;

            text-decoration: none;

            transition: color 0.2s;

        }



        .btn-card-delete:hover {

            color: #B71C1C;

            text-decoration: underline;

        }



        /* Color Coding Systems for Dynamic Statuses */

        .status-in-progress { color: #A0A0A0; }

        .status-rejected { color: #E76F51; }

        .status-approve { color: #2A9D8F; }



        .no-data-msg {

            grid-column: span 3;

            text-align: center;

            color: #777777;

            font-size: 1.1rem;

            padding: 40px 0;

        }



        /* Footer Navigation Row */

        .action-row {

            display: flex;

            justify-content: flex-end;

        }



        .back-btn {

            background-color: #4A154B;

            color: #FFFFFF;

            border: none;

            padding: 12px 40px;

            font-size: 1rem;

            font-weight: bold;

            border-radius: 8px;

            cursor: pointer;

            transition: opacity 0.2s;

        }



        .back-btn:hover {

            opacity: 0.9;

        }



        /* Media Queries for Viewport Responsiveness */

        @media (max-width: 900px) {

            .status-grid { grid-template-columns: repeat(2, 1fr); }

            .no-data-msg { grid-column: span 2; }

        }

        

        @media (max-width: 600px) {

            .status-grid { grid-template-columns: 1fr; }

            .no-data-msg { grid-column: span 1; }

        }

    </style>

</head>

<body>



    <div class="nav-header">

        <div class="logo-trigger-box" id="logoToggle">

            <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">

        </div>

        <div class="header-title">Application Status</div>

        <div></div> 

    </div>



    <div class="sidebar-menu" id="panelSidebar">

        <a href="UpdateProfile.php">Update Profile</a>

        <a href="jobSearching.php">Job Vacancy</a>

        <a href="applicationStatus.php" class="active-view">Application Status</a>

        <div class="sidebar-divider"></div>

        <a href="Login.php" style="color: #FF8A8A; font-size: 0.95rem;">Log Out</a>

    </div>



    <div class="laptop-mockup-frame">

        <div class="status-canvas">

            

            <div class="status-grid">

                <?php if (empty($applications)): ?>

                    <div class="no-data-msg">You haven't applied for any jobs yet.</div>

                <?php else: ?>

                    <?php foreach ($applications as $row): 

                        $jobId = htmlspecialchars($row['job_id']);

                        $jobTitle = htmlspecialchars($row['job_title']);

                        $companyName = htmlspecialchars($row['company']);

                        $statusText = htmlspecialchars($row['status']);

                        

                        $statusClass = 'status-in-progress';

                        $isApproved = false;

                        $canDelete = false;



                        $normalizedStatus = strtolower($statusText);

                        if ($normalizedStatus == 'rejected') {

                            $statusClass = 'status-rejected';

                        } elseif ($normalizedStatus == 'approve' || $normalizedStatus == 'approved') {

                            $statusClass = 'status-approve';

                            $isApproved = true;

                        } elseif ($normalizedStatus == 'pending' || $normalizedStatus == 'in progress') {

                            $statusClass = 'status-in-progress';

                            $canDelete = true;

                        } else {

                            $canDelete = true;

                        }

                    ?>

                        <div class="status-box">

                            <div>

                                <div class="company-name"><?php echo $companyName; ?></div>

                                <span class="badge badge-applied">Applied</span>

                                <div class="job-title"><?php echo $jobTitle; ?></div>

                                <div class="process-text <?php echo $statusClass; ?>">

                                    <?php echo $statusText; ?>

                                </div>



                                <?php if ($isApproved): ?>

                                    <div class="interview-note">

                                        We will reach you soon via email/whatapps for an interview meeting

                                    </div>

                                <?php endif; ?>

                            </div>



                            <?php if ($canDelete): ?>

                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this application?');" style="margin-top: 10px; width: 100%;">

                                    <input type="hidden" name="cancel_application_id" value="<?php echo $jobId; ?>">

                                    <button type="submit" class="btn-card-delete">Delete</button>

                                </form>

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>



            <div class="action-row">

                <button type="button" onclick="window.location.href='jobSearching.php'" class="back-btn">Back</button>

            </div>



        </div>

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

    </script>

    

</body>

</html> 


<?php
include("dbconn.php");

$search = "";
$location = "";
$salary = "";

$query = "SELECT * FROM job_posting WHERE 1=1";

if (isset($_GET['search']) || isset($_GET['location']) || isset($_GET['salary'])) {

    $search   = isset($_GET['search']) ? trim($_GET['search']) : "";
    $location = isset($_GET['location']) ? trim($_GET['location']) : "";
    $salary   = isset($_GET['salary']) ? trim($_GET['salary']) : "";

    if ($search !== "") {
        $clean_search = mysqli_real_escape_string($dbconn, $search);
        $query .= " AND job_position LIKE '%$clean_search%'";
    }

    if ($location !== "") {
        $clean_location = mysqli_real_escape_string($dbconn, $location);
        $query .= " AND job_location LIKE '%$clean_location%'";
    }

    if ($salary !== "") {
        $user_salary = intval($salary);

        $query .= " AND (
            (
                salary_range LIKE '% to %' 
                AND $user_salary BETWEEN 
                    CAST(SUBSTRING_INDEX(salary_range, ' to ', 1) AS UNSIGNED) 
                    AND CAST(SUBSTRING_INDEX(salary_range, ' to ', -1) AS UNSIGNED)
            )
            OR 
            (
                salary_range NOT LIKE '% to %' 
                AND CAST(salary_range AS UNSIGNED) >= $user_salary
            )
        )";
    }
}

$query .= " ORDER BY job_id DESC"; 

$result = mysqli_query($dbconn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Vacancy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background-color: #F8F9FA;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #2D2D2D;
        }
        
        .nav-header {
            background-color: #4A0E4E;
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .header-title {
            color: white;
            font-size: 1.4rem;
            font-weight: 600;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .toggle-menu-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 6px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-menu-btn:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.02);
        }

        .nav-logo-img {
            width: 32px;
            height: 32px;
            display: block;
            object-fit: cover;
            border-radius: 50%;
        }

        .app-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            width: 100%;
            position: relative;
        }

        .sidebar-menu {
            width: 240px;
            background-color: #4A0E4E;
            box-shadow: 4px 8px 25px rgba(0,0,0,0.15);
            border-bottom-right-radius: 12px;
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 70px;
            left: -260px;
            z-index: 90;
            transition: left 0.3s ease;
        }

        .sidebar-menu.active {
            left: 0;
        }

        .sidebar-menu a {
            color: white;
            padding: 16px 25px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: background 0.2s, border-left 0.2s;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .sidebar-menu a.active-view {
            background-color: rgba(255,255,255,0.15);
            border-left: 4px solid #FFFFFF;
            font-weight: bold;
        }

        .sidebar-divider {
            height: 1px;
            background-color: rgba(255,255,255,0.15);
            margin: 10px 25px;
        }

        .main-content {
            width: 100%;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .white-panel {
            background-color: white;
            width: 100%;
            max-width: 1100px;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #EAEAEA;
            min-height: 520px;
        }

        .main {
            padding: 20px 0;
            text-align: center;
        }

        .headline {
            font-size: 36px;
            color: #2D2D2D;
            margin-top: 20px;
            margin-bottom: 40px;
            font-weight: 500;
        }

        .headline span {
            color: #4A0E4E;
            font-weight: 700;
        }

        .search-box {
            width: 100%;
            max-width: 900px;
            margin: 0 auto 50px;
            background-color: #FFFFFF;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(74, 14, 78, 0.08);
            border: 1px solid #E2E8F0;
        }

        .search-box form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .search-box input {
            padding: 12px 16px;
            border-radius: 25px;
            border: 1px solid #E2E8F0;
            width: 220px;
            outline: none;
            font-size: 14px;
            color: #2D2D2D;
            background-color: #F8F9FA;
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            border-color: #4A0E4E;
            background-color: #FFFFFF;
        }

        .search-btn {
            background-color: #4A0E4E;
            color: #FFFFFF;
            border: none;
            padding: 12px 35px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(74, 14, 78, 0.2);
            transition: background-color 0.2s, transform 0.1s;
        }

        .search-btn:hover {
            background-color: #350A38;
            transform: translateY(-1px);
        }

        .reset-link {
            color: #DC2626;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-left: 5px;
            transition: color 0.2s;
        }
        
        .reset-link:hover {
            color: #991B1B;
            text-decoration: underline;
        }
        
        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            width: 100%;
            margin-top: 20px;
        }

        .card {
            background-color: white;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(74, 14, 78, 0.08);
            border-color: #4A0E4E;
        }

        .card img {
            width: 100%;
            border-radius: 10px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #F0F0F0;
        }

        .company {
            font-weight: 700;
            margin-top: 15px;
            font-size: 1.2rem;
            color: #4A0E4E;
        }

        .tag {
            display: inline-block;
            background-color: #F3E8FF;
            color: #6B21A8;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin: 10px 0;
            align-self: flex-start;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .details {
            font-size: 14px;
            color: #4A5568;
            margin-top: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .apply-btn {
            width: 100%;
            margin-top: 18px;
            background-color: #4A0E4E;
            color: #FFFFFF;
            border: none;
            padding: 12px 40px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(74, 14, 78, 0.2);
            transition: background-color 0.2s, transform 0.1s;
        }

        .apply-btn:hover {
            background-color: #350A38;
            transform: translateY(-1px);
        }

        @media (max-width: 950px) {
            .cards { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 650px) {
            .cards { grid-template-columns: 1fr; }
            .search-box input { width: 100%; }
        }
    </style>
</head>
<body>

<div class="nav-header">
    <button class="toggle-menu-btn" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT" class="nav-logo-img">
    </button>
    <div class="header-title">Job Vacancy</div>
    <div></div>
</div>

<div class="app-container">

    <div class="sidebar-menu" id="panelSidebar">
        <a href="UpdateProfile.php">Update Profile</a>
        <a href="jobSearching.php" class="active-view">Job Vacancy</a>
        <a href="applicationStatus.php">Application Status</a>
        <div class="sidebar-divider"></div>
        <a href="Login.php" style="color:#FF8A8A; font-size:0.95rem;">Log Out</a>
    </div>

    <div class="main-content" id="mainContent">
        <div class="white-panel">
            <div class="main">
                <img src="startIT2.png.png" width="30%">

                <div class="headline">
                    Find your <span>Dream Job</span> here!
                </div>

                <div class="search-box">
                    <form method="GET" action="jobSearching.php">
                        <input type="text" name="search" placeholder="Search job title" value="<?php echo htmlspecialchars($search); ?>">
                        <input type="text" name="location" placeholder="Filter by location" value="<?php echo htmlspecialchars($location); ?>">
                        <input type="number" name="salary" placeholder="Min Salary (e.g. 3000)" min="0" value="<?php echo htmlspecialchars($salary); ?>">
                        <button type="submit" class="search-btn">Search</button>
                        <?php if($search !== "" || $location !== "" || $salary !== ""): ?>
                            <a href="jobSearching.php" class="reset-link">Clear Filters</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="cards">
                    <?php
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $imagePath = !empty($row['job_image']) ? $row['job_image'] : 'https://cdn-icons-png.flaticon.com/512/685/685655.png';
                    ?>
                    <div class="card">
                        <div>
                            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Job Image">
                            <div class="company"><?php echo htmlspecialchars($row['company_name']); ?></div>
                            <div class="tag"><?php echo htmlspecialchars($row['job_position']); ?></div>
                            <div class="details">📍 <?php echo htmlspecialchars($row['job_location']); ?></div>
                            <div class="details">💰 RM <?php echo htmlspecialchars($row['salary_range']); ?></div>
                        </div>
                        <a href="applyJob.php?id=<?php echo urlencode($row['job_id']); ?>" style="text-decoration: none; width: 100%;">
                            <button class="apply-btn">Apply Job</button>
                        </a>
                    </div>
                    <?php
                        }
                    } else {
                        echo "<h3 style='grid-column: span 3; color: #718096; padding: 40px 0;'>No job found matching your criteria.</h3>";
                    }
                    ?>
                </div> 
            </div>
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

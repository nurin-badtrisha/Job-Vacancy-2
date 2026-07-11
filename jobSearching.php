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

    // 1. Strict Job Title Matching
    if ($search !== "") {
        $clean_search = mysqli_real_escape_string($dbconn, $search);
        $query .= " AND job_position LIKE '%$clean_search%'";
    }

    // 2. Location Matching
    if ($location !== "") {
        $clean_location = mysqli_real_escape_string($dbconn, $location);
        $query .= " AND job_location LIKE '%$clean_location%'";
    }

    // 3. Dynamic Range Salary Matching
    if ($salary !== "") {
        $user_salary = intval($salary);

        $query .= " AND (
            (
                -- Check if it is a range format (contains the word 'to')
                salary_range LIKE '% to %' 
                AND $user_salary BETWEEN 
                    CAST(SUBSTRING_INDEX(salary_range, ' to ', 1) AS UNSIGNED) 
                    AND CAST(SUBSTRING_INDEX(salary_range, ' to ', -1) AS UNSIGNED)
            )
            OR 
            (
                -- Fallback: If it's a single flat number (e.g., '5000'), show it if it's >= user input
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
            background-color: #b7a9f0;
        }
		
		.nav-header {
			background-color: #4f0f69;
			width: 100%;
			height: 70px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 0 40px;
			position: relative;
			box-shadow: 0 4px 15px rgba(0,0,0,0.15);
			z-index: 10;
		}

		.header-title {
			color: white;
			font-size: 1.4rem;
			font-weight: 500;
			position: absolute;
			left: 50%;
			transform: translateX(-50%);
		}

		.logo-trigger-box {
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 6px;
			border-radius: 8px;
			transition: 0.2s;
		}

		.logo-trigger-box:hover {
			background-color: rgba(255,255,255,0.15);
		}

		.nav-logo-img {
			width: 45px;
			height: 45px;
			object-fit: contain;
		}

		.sidebar-menu {
			position: absolute;
			top: 70px;
			left: -260px;
			width: 240px;
			background-color: #4A154B;
			box-shadow: 4px 8px 25px rgba(0,0,0,0.3);
			border-bottom-right-radius: 12px;
			padding: 20px 0;
			display: flex;
			flex-direction: column;
			transition: left 0.3s ease;
			z-index: 20;
		}

		.sidebar-menu.active {
			left: 0;
		}

		.sidebar-menu a {
			color: white;
			padding: 16px 25px;
			text-decoration: none;
			font-size: 1rem;
			font-weight: 500;
			border-left: 4px solid transparent;
			transition: 0.2s;
		}

		.sidebar-menu a:hover {
			background-color: rgba(255,255,255,0.1);
		}

		.sidebar-menu a.active-view {
			background-color: rgba(255,255,255,0.15);
			border-left: 4px solid #B4A4EB;
			font-weight: bold;
		}

		.sidebar-divider {
			height: 1px;
			background-color: rgba(255,255,255,0.15);
			margin: 10px 25px;
		}

        .main {
            padding: 60px 20px;
            text-align: center;
        }

        .headline {
            font-size: 36px;
            color: black;
            margin-bottom: 40px;
        }

        .headline span {
            color: #6b4b3e;
            font-weight: bold;
        }

        .search-box {
            width: 90%;
            max-width: 900px;
            margin: 0 auto 40px;
            background-color: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .search-box form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .search-box input {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            width: 220px;
            outline: none;
            font-size: 14px;
        }

        .search-box input:focus {
            border-color: #4A154B;
        }

        .search-btn {
            background-color: #4A154B;
            color: #FFFFFF;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .search-btn:hover {
            opacity: 0.9;
        }

        /* Added clean reset adjustments layout styles */
        .reset-link {
            color: #4A154B;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-left: 5px;
        }
        .reset-link:hover {
            text-decoration: underline;
        }
		
        .cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background-color: white;
            width: 280px;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            text-align: left;
        }

        .card img {
            width: 100%;
            border-radius: 10px;
            height: 150px;
            object-fit: cover;
        }

        .company {
            font-weight: bold;
            margin-top: 10px;
            font-size: 18px;
        }

        .tag {
            display: inline-block;
            background-color: #e7c8ff;
            color: #4b1f6f;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin: 8px 0;
        }

        .details {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }

        .apply-btn {
            width: 100%;
            margin-top: 12px;
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

        .apply-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>

<div class="nav-header">
    <div class="logo-trigger-box" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    </div>

    <div class="header-title">Job Vacancy</div>

    <div></div>
</div>

<div class="sidebar-menu" id="panelSidebar">
    <a href="UpdateProfile.php">Update Profile</a>
    <a href="jobSearching.php" class="active-view">Job Vacancy</a>
    <a href="applicationStatus.php">Application Status</a>

    <div class="sidebar-divider"></div>

    <a href="Login.php" style="color:#FF8A8A; font-size:0.95rem;">
        Log Out
    </a>
</div>

<div class="main">

    <img src="StartIT.png" width="30%">

    <div class="headline">
        Find your <span>Dream</span><br>
        <span>Job</span> here!
    </div>

    <div class="search-box">
        <form method="GET" action="jobSearching.php">

            <input type="text" 
                   name="search" 
                   placeholder="Search job title"
                   value="<?php echo htmlspecialchars($search); ?>">

            <input type="text" 
                   name="location" 
                   placeholder="Filter by location"
                   value="<?php echo htmlspecialchars($location); ?>">

            <input type="number" 
                   name="salary" 
                   placeholder="Min Salary (e.g. 3000)" 
                   min="0"
                   value="<?php echo htmlspecialchars($salary); ?>">

            <button type="submit" class="search-btn">
                Search
            </button>

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
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Job Image">

            <div class="company">
                <?php echo htmlspecialchars($row['company_name']); ?>
            </div>

            <div class="tag">
                <?php echo htmlspecialchars($row['job_position']); ?>
            </div>

            <div class="details">
                📍 <?php echo htmlspecialchars($row['job_location']); ?>
            </div>

            <div class="details">
                💰 RM <?php echo htmlspecialchars($row['salary_range']); ?>
            </div>

            <a href="applyJob.php?id=<?php echo urlencode($row['job_id']); ?>">
                <button class="apply-btn">
                    Apply Job
                </button>
            </a>
        </div>

        <?php
            }
        } else {
            echo "<h3>No job found matching your criteria.</h3>";
        }
        ?>

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
    if (!panelSidebar.contains(event.target) &&
        !logoToggle.contains(event.target)) {

        panelSidebar.classList.remove('active');
    }
});
</script>

</body>
</html>
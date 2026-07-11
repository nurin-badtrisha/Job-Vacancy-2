<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: LogIn.php");
    exit();
}


$host = "localhost";
$user = "root";
$pass = "";
$db   = "startit";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}


$selected_month = isset($_GET['month']) ? intval($_GET['month']) : intval(date('m'));
$selected_year  = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));

$months_list = [
    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
];


$query = "
    SELECT jp.company_name, COUNT(aj.applicant_id) as total_applicants
    FROM apply_job aj
    JOIN job_posting jp ON aj.job_id = jp.job_id
    WHERE MONTH(aj.applied_date) = ? AND YEAR(aj.applied_date) = ?
    GROUP BY jp.company_name
    ORDER BY total_applicants DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $selected_month, $selected_year);
$stmt->execute();
$result = $stmt->get_result();

$chart_data = [];
$max_applicants = 0;

while ($row = $result->fetch_assoc()) {
    $chart_data[] = [
        'company' => $row['company_name'],
        'total' => intval($row['total_applicants'])
    ];
    if (intval($row['total_applicants']) > $max_applicants) {
        $max_applicants = intval($row['total_applicants']);
    }
}

if ($max_applicants == 0) { $max_applicants = 10; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartIt</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; }
        
        
        body { background-color: #b4a7d6; padding-bottom: 50px; }
        

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

        
        .main-card {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 30px; /* Lengkungan besar ikut gambar */
            padding: 35px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        
        .filter-section {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
            align-items: center;
        }
        .filter-section select {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #fff8ff;
        }

        
        .chart-box {
            border: 1px solid #cccccc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            background-color: #fcfbfe;
        }
        .chart-title {
            font-weight: bold;
            color: #4c2874;
            margin-bottom: 15px;
            font-size: 14px;
        }

        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #a2a2a2; 
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: #9999ff; 
            color: black;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f0f7;
        }

        
        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
        }

        
        .btn-canva {
            background-color: #4c2874;
            color: white;
            border: none;
            padding: 10px 30px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background 0.2s;
        }
        .btn-canva:hover {
            background-color: #361c54;
        }

        .no-data {
            padding: 30px;
            text-align: center;
            color: #777;
            font-style: italic;
        }

        @media print {
            body { background: white; }
            .topbar, .filter-section, .button-group { display: none !important; }
            .main-card { box-shadow: none; margin: 0; padding: 0; width: 100%; }
        }
    </style>
</head>
<body>

<div class="nav-header">
    <div class="logo-trigger-box" id="logoToggle">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    </div>

    <div class="header-title">Report</div>

    <div></div>
</div>

    <div class="main-card">

        <form class="filter-section" method="GET" action="">
            <label style="font-weight: bold;">Select Month:</label>
            <select name="month">
                <?php foreach ($months_list as $num => $name): ?>
                    <option value="<?php echo $num; ?>" <?php echo ($num == $selected_month) ? 'selected' : ''; ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>

            <select name="year">
                <?php 
                $current_yr = intval(date('Y'));
                for ($y = $current_yr; $y >= $current_yr - 3; $y--): 
                ?>
                    <option value="<?php echo $y; ?>" <?php echo ($y == $selected_year) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="btn-canva" style="padding: 5px 15px;">Filter</button>
        </form>

        <div class="chart-box">
            <div class="chart-title">Demand Statistics - <?php echo $months_list[$selected_month] . " " . $selected_year; ?></div>
            
            <?php if (empty($chart_data)): ?>
                <div class="no-data">No data available for this month.</div>
            <?php else: 
                $svg_width = 800; $svg_height = 300;
                $p_left = 60; $p_right = 40; $p_top = 20; $p_bottom = 50;
                $plot_w = $svg_width - $p_left - $p_right;
                $plot_h = $svg_height - $p_top - $p_bottom;
                
                $item_count = count($chart_data);
                $group_w = $plot_w / $item_count;
                $bar_w = $group_w * 0.5;
            ?>
                <svg width="100%" height="100%" viewBox="0 0 <?php echo $svg_width; ?> <?php echo $svg_height; ?>" style="max-height: 280px;">
                    <?php for($i = 0; $i <= 4; $i++): 
                        $y_line = $p_top + $plot_h - ($plot_h / 4) * $i;
                        $label_y = round(($max_applicants / 4) * $i);
                    ?>
                        <line x1="<?php echo $p_left; ?>" y1="<?php echo $y_line; ?>" x2="<?php echo $svg_width - $p_right; ?>" y2="<?php echo $y_line; ?>" stroke="#e0e0e0" stroke-dasharray="4,4" />
                        <text x="<?php echo $p_left - 10; ?>" y="<?php echo $y_line + 4; ?>" font-size="11; " fill="#666" text-anchor="end"><?php echo $label_y; ?></text>
                    <?php endfor; ?>

                    <line x1="<?php echo $p_left; ?>" y1="<?php echo $p_top + $plot_h; ?>" x2="<?php echo $svg_width - $p_right; ?>" y2="<?php echo $p_top + $plot_h; ?>" stroke="#555" stroke-width="1.5" />
                    <line x1="<?php echo $p_left; ?>" y1="<?php echo $p_top; ?>" x2="<?php echo $p_left; ?>" y2="<?php echo $p_top + $plot_h; ?>" stroke="#555" stroke-width="1.5" />

                    <?php foreach ($chart_data as $index => $data): 
                        $x_pos = $p_left + ($index * $group_w) + ($group_w - $bar_w) / 2;
                        $bar_h = ($data['total'] / $max_applicants) * $plot_h;
                        $y_pos = $p_top + $plot_h - $bar_h;
                    ?>
                        <rect x="<?php echo $x_pos; ?>" y="<?php echo $y_pos; ?>" width="<?php echo $bar_w; ?>" height="<?php echo $bar_h; ?>" fill="#9999ff" stroke="#4c2874" stroke-width="1" />
                        <text x="<?php echo $x_pos + $bar_w/2; ?>" y="<?php echo $y_pos - 6; ?>" font-size="11" font-weight="bold" fill="#4c2874" text-anchor="middle"><?php echo $data['total']; ?></text>
                        <text x="<?php echo $x_pos + $bar_w/2; ?>" y="<?php echo $p_top + $plot_h + 20; ?>" font-size="11" fill="#333" text-anchor="middle">
                            <?php echo (strlen($data['company']) > 12) ? substr($data['company'], 0, 10).'..' : $data['company']; ?>
                        </text>
                    <?php endforeach; ?>
                </svg>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Rank</th>
                    <th>Company Name</th>
                    <th style="width: 30%;">Total Applicants</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($chart_data)): ?>
                    <tr><td colspan="3" class="no-data">No data logged.</td></tr>
                <?php else: $rank = 1; foreach ($chart_data as $data): ?>
                    <tr>
                        <td><strong>#<?php echo $rank++; ?></strong></td>
                        <td style="text-align: left; padding-left: 20px;"><?php echo htmlspecialchars($data['company']); ?></td>
                        <td><strong><?php echo $data['total']; ?></strong></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>

        <div class="button-group">
            <button class="btn-canva" onclick="window.print()">Print</button>
            <a href="adminReport.php" class="btn-canva">Back</a>
        </div>

    </div>

</body>
</html>
<?php $conn->close(); ?>

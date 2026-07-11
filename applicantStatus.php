<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Login.php"); 
    exit();
}

$servername = "localhost";
$username   = "root"; 
$password   = ""; 
$dbname     = "startit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $applicant_id = intval($_POST['applicant_id']);
    $job_id = intval($_POST['job_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $check_ownership = "SELECT job_id FROM job_posting WHERE job_id = $job_id AND pic_id = $current_pic_id";
    $ownership_result = $conn->query($check_ownership);

    if ($ownership_result && $ownership_result->num_rows > 0) {
        $update_query = "UPDATE apply_job SET applicant_status = '$status' WHERE applicant_id = $applicant_id AND job_id = $job_id";
        
        if ($conn->query($update_query)) {
            $message = "<script>alert('Status updated successfully!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        } else {
            $message = "<script>alert('Failed to update status: " . $conn->error . "');</script>";
        }
    } else {
        $message = "<script>alert('Unauthorized action!');</script>";
    }
}

$query = "SELECT 
            aj.applicant_id,
            aj.job_id,
            aj.resume_path,
            aj.applicant_status,
            a.full_name AS applicant_name,
            a.email AS applicant_email,
            a.phone_number AS applicant_phone,
            j.job_position AS job_position
          FROM apply_job aj
          LEFT JOIN applicant a ON aj.applicant_id = a.applicant_id
          LEFT JOIN job_posting j ON aj.job_id = j.job_id
          WHERE j.pic_id = '$current_pic_id'"; // Tapis di sini!

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #b4bcf4; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .nav-header {
            background-color: #4f0f69; 
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .nav-logo-img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: contain;
        }

        .header-title {
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
			position: absolute;
			left: 50%;
			transform: translateX(-50%);
			z-index: 10;
        }

        .header-spacer {
            flex: 1;
        }
        
        .container {
            width: 95%;
            max-width: 1150px;
            margin: auto;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 5px 10px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .search-container {
            display: flex;
            align-items: center;
            background-color: #fffdf6; 
            border-radius: 8px;
            padding: 8px 15px;
            width: 100%;
            max-width: 500px;
            border: 1px solid #f1ece1;
        }

        .search-container i {
            color: #8e8271;
            margin-right: 15px;
            font-size: 16px;
        }

        .search-container input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            font-size: 15px;
            color: #333;
        }

        .table-wrapper {
            border: 1px solid #b3a2f2;
            border-radius: 4px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f1effd; 
        }

        th {
            background-color: #b3a2f2; 
            color: #000000;
            font-weight: bold;
            font-size: 18px;
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #9c8be0;
        }

        th:not(:last-child), td:not(:last-child) {
            border-right: 1px solid #cbc2f7;
        }

        td {
            padding: 14px;
            height: 55px; 
            border-bottom: 1px solid #cbc2f7;
            font-size: 15px;
            color: #333;
            outline: none;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .no-records {
            text-align: center;
            font-size: 18px;
            color: #666;
            font-style: italic;
            padding: 30px;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 5px;
            gap: 15px;
        }

        .btn-back {
            background-color: #4A154B;
            color: white;
            border: none;
            padding: 12px 28px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-back:hover {
            background-color: #330e34;
        }

        .status-action-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
		
		.status-select {
			flex: 1;
			padding: 8px 8px;
			font-size: 14px;
			font-weight: 600;
			border-radius: 6px;
			border: 1px solid #9c8be0;
			cursor: pointer;
			transition: all 0.2s ease;
		}

        .status-select.pending {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeeba;
        }

		.status-select.approved {
			background-color: #d4edda;
			color: #155724;
			border-color: #c3e6cb;
		}

		.status-select.rejected {
			background-color: #f8d7da;
			color: #721c24;
			border-color: #f5c6cb;
		}

        .btn-update {
            background-color: #4A154B;
            color: white;
            border: none;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            white-space: nowrap;
        }

        .btn-update:hover {
            background-color: #330e34;
        }
    </style>
</head>
<body>

<?php if (!empty($message)) echo $message; ?>

<div class="nav-header">
    <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    <div class="header-title">Applicant Status</div>
    <div class="header-spacer"></div>
</div>

<div class="container">
    <div class="card">
        
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="tableSearch" onkeyup="filterTable()" placeholder="Search for applicant details...">
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 22%;">Applicant name</th>
                        <th style="width: 18%;">Job Position</th>
                        <th style="width: 18%;">Email</th>
                        <th style="width: 15%;">Phone Number</th>
                        <th style="width: 10%;">Resume</th>
                        <th style="width: 17%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $current_status = strtolower($row['applicant_status'] ?? 'pending');
                            if (!in_array($current_status, ['pending', 'approved', 'rejected'])) {
                                $current_status = 'pending';
                            }
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['applicant_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['job_position'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['applicant_email'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['applicant_phone'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php if(!empty($row['resume_path'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['resume_path']); ?>" target="_blank" style="color: #512da8; font-weight: bold;">View</a>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="applicant_id" value="<?php echo $row['applicant_id']; ?>">
                                        <input type="hidden" name="job_id" value="<?php echo $row['job_id']; ?>">
                                        <div class="status-action-container">
                                            <select name="status" class="status-select <?php echo $current_status; ?>" onchange="updateStatusStyle(this)">
                                                <option value="pending" <?php if($current_status == 'pending') echo 'selected'; ?>>Pending</option>
                                                <option value="approved" <?php if($current_status == 'approved') echo 'selected'; ?>>Approved</option>
                                                <option value="rejected" <?php if($current_status == 'rejected') echo 'selected'; ?>>Rejected</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn-update">Update</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='no-records'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="button-container">
            <button class="btn-back" onclick="window.location.href='pic.php'">Back</button>
        </div>

    </div>
</div>

<script>
    function updateStatusStyle(selectElement) {
        selectElement.classList.remove('pending', 'approved', 'rejected');
        if (selectElement.value === 'pending') {
            selectElement.classList.add('pending');
        } else if (selectElement.value === 'approved') {
            selectElement.classList.add('approved');
        } else if (selectElement.value === 'rejected') {
            selectElement.classList.add('rejected');
        }
    }

    function filterTable() {
        const input = document.getElementById("tableSearch");
        const filter = input.value.toLowerCase();
        const table = document.querySelector("table tbody");
        const rows = table.getElementsByTagName("tr");

        for (let i = 0; i < rows.length; i++) {
            if(rows[i].querySelector('.no-records')) continue;

            let matchFound = false;
            const cells = rows[i].getElementsByTagName("td");
            
            for(let j = 0; j < 4; j++) {
                if (cells[j]) {
                    const textValue = cells[j].textContent || cells[j].innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        matchFound = true;
                        break;
                    }
                }
            }
            rows[i].style.display = matchFound ? "" : "none";
        }
    }
</script>
</body>
</html>
<?php 
$conn->close(); 
?>
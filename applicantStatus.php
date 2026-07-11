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
          WHERE j.pic_id = '$current_pic_id'";

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
            background-color: #F8F9FA; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .nav-logo-img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: contain;
        }

        .header-title {
            color: white;
            font-size: 1.4rem;
            font-weight: 600;
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
            margin: 40px auto;
        }

        .card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #EAEAEA;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .search-container {
            display: flex;
            align-items: center;
            background-color: #F8F9FA; 
            border-radius: 25px;
            padding: 10px 20px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #E2E8F0;
            transition: border-color 0.2s;
        }

        .search-container:focus-within {
            border-color: #4A0E4E;
        }

        .search-container i {
            color: #A0AEC0;
            margin-right: 15px;
            font-size: 16px;
        }

        .search-container input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            font-size: 15px;
            color: #2D2D2D;
        }

        .table-wrapper {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FFFFFF; 
        }

        th {
            background-color: #F3E8FF; 
            color: #4A0E4E;
            font-weight: 700;
            font-size: 1rem;
            padding: 16px;
            text-align: left;
            border-bottom: 2px solid #EAEAEA;
        }

        th:not(:last-child), td:not(:last-child) {
            border-right: 1px solid #F0F0F0;
        }

        td {
            padding: 16px;
            height: 55px; 
            border-bottom: 1px solid #F0F0F0;
            font-size: 0.95rem;
            color: #4A5568;
            outline: none;
        }

        tr:hover td {
            background-color: #F8F9FA;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .no-records {
            text-align: center;
            font-size: 1rem;
            color: #718096;
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
            background-color: #4A0E4E;
            color: white;
            border: none;
            padding: 12px 40px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(74, 14, 78, 0.2);
            transition: background-color 0.2s, transform 0.1s;
        }

        .btn-back:hover {
            background-color: #350A38;
            transform: translateY(-1px);
        }

        .status-action-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .status-select {
            flex: 1;
            padding: 6px 10px;
            font-size: 0.85rem;
            font-weight: 700;
            border-radius: 20px;
            border: 1px solid #E2E8F0;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
        }

        .status-select.pending {
            background-color: #EDF2F7;
            color: #4A5568;
        }

        .status-select.approved {
            background-color: #D1FAE5;
            color: #059669;
        }

        .status-select.rejected {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        .btn-update {
            background-color: #4A0E4E;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 0.8rem;
            font-weight: bold;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.2s;
            white-space: nowrap;
        }

        .btn-update:hover {
            background-color: #350A38;
        }
    </style>
</head>
<body>

<?php if (!empty($message)) echo $message; ?>

<div class="nav-header">
    <img src="startIT logo.jpg" alt="startIT" class="nav-logo-img">
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
                                        <a href="<?php echo htmlspecialchars($row['resume_path']); ?>" target="_blank" style="color: #6B21A8; font-weight: bold; text-decoration: none;">View</a>
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

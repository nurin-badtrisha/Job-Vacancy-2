<?php session_start(); 
if (!isset($_SESSION['username'])) {
    header("Location: LogIn.php");
    exit();
}


include("dbconn.php");


error_reporting(E_ALL);
ini_set('display_errors', 1); 


$query = "SELECT 

            a.full_name, 
            a.email, 
            j.job_position, 
            j.company_name 
          FROM apply_job aj
          JOIN applicant a ON aj.applicant_id = a.applicant_id
          JOIN job_posting j ON aj.job_id = j.job_id";

$result = $dbconn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #b4a7d6; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

       
        header {
            background-color: #4f0f69; 
            color: white;
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .header-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .nav-logo-img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: contain;
        }

        .header-title {
            flex: 1;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
        }

        
        .header-nav {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .header-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
        }

        .header-nav a:hover {
            text-decoration: underline;
        }

        
        .container {
            width: 95%;
            max-width: 1100px;
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

        .search-container input::placeholder {
            color: #c5bdae;
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
            font-size: 17px;
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
            font-size: 14px;
            color: #333;
        }

        tr:last-child td {
            border-bottom: none;
        }

       
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px; 
            background-color: #3b145a;
            color: white !important;
            padding: 10px 20px; 
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #3b145a;
            transform: translateY(-1px); 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); 
        }

        .btn-primary:active {
            transform: translateY(1px); 
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <header>
        <div class="header-left">
            <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
        </div>
        
        <div class="header-title">Admin Dashboard</div>
        
        <div class="header-spacer">
            <nav class="header-nav">
                <a href="adminReport.php">Admin Dashboard</a>
                <a href="PICdetails.php">View PIC Details</a>
                <a href="registerPIC.php">Register PIC</a>
                <a href="interface.php">Log Out</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card">
            
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="reportSearch" placeholder="Search for applicant">
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 25%;">Email</th>
                            <th style="width: 20%;">Job Position</th>
                            <th style="width: 25%;">Company</th>
                        </tr>
                    </thead>
                    <tbody id="reportTableBody">
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                ?>
                                <tr class="applicant-row">
                                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['job_position']); ?></td>
                                    <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr class='empty-row-fallback'><td colspan='4' style='text-align:center; color:#777;'>No applications found.</td></tr>";
                        }
                        $dbconn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="button-container" style="text-align: right; width: 100%;">
                <a href="generateReport.php" class="btn-primary">View Report</a>
            </div>

        </div>
    </div>

<script>
   
    document.getElementById('reportSearch').addEventListener('keyup', function() {
        const value = this.value.toLowerCase().trim();
        const tableBody = document.getElementById('reportTableBody');
        const rows = tableBody.getElementsByClassName('applicant-row');
        
        let foundMatches = 0;

        const oldNoMatch = tableBody.querySelector('.no-match-alert');
        if (oldNoMatch) oldNoMatch.remove();

        const basicFallback = tableBody.querySelector('.empty-row-fallback');
        if (basicFallback) basicFallback.style.display = 'none';

        for (let i = 0; i < rows.length; i++) {
            const name = rows[i].cells[0].textContent.toLowerCase();
            const email = rows[i].cells[1].textContent.toLowerCase();
            const position = rows[i].cells[2].textContent.toLowerCase();
            const company = rows[i].cells[3].textContent.toLowerCase();

            if (name.includes(value) || email.includes(value) || position.includes(value) || company.includes(value)) {
                rows[i].style.display = "";
                foundMatches++;
            } else {
                rows[i].style.display = "none";
            }
        }

        if (foundMatches === 0 && rows.length > 0) {
            const noMatchRow = document.createElement('tr');
            noMatchRow.className = 'no-match-alert';
            noMatchRow.innerHTML = `<td colspan="4" style="text-align: center; color: #777; font-style: italic;">No matching applicants found for "${this.value}"</td>`;
            tableBody.appendChild(noMatchRow);
        }
    });
</script>

</body>
</html>
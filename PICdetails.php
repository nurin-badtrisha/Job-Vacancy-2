<?php

include ("dbconn.php");


error_reporting(E_ALL);
ini_set('display_errors', 0); 


if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['id'])) {
    if (ob_get_length()) ob_clean();
    header('Content-Type: application/json');
    
    $company_id = intval($_POST['id']);
    
    
    if (!isset($dbconn) || $dbconn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Database link missing or failed."]);
        exit;
    }
    
    $delete_sql = "DELETE FROM company WHERE company_id = ?";
    $stmt = $dbconn->prepare($delete_sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $company_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record deleted successfully."]);
        } else {
            
            echo json_encode(["status" => "error", "message" => "Execution failed: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Preparation failed: " . $dbconn->error]);
    }
    
    $dbconn->close();
    exit; 
}


$sql = "SELECT * FROM company";
$result = $dbconn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIC Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #b4a7d6; 
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

        
        .logo-trigger-box {
            flex: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: flex-start;
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

        .header-title {
            flex: 1;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .header-spacer {
            flex: 1;
        }
        
      .header-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 14px;
            font-weight: 500;
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
            outline: none;
            transition: background-color 0.2s;
        }

        tr:last-child td {
            border-bottom: none;
        }

       
        tr.editing-row td.editable-cell {
            background-color: #ffffff; 
            box-shadow: inset 0 0 3px rgba(79, 15, 105, 0.4);
            color: #000;
        }

       
        .action-cell-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

      
        .btn-action-edit {
            color: #4f0f69;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-action-edit:hover {
            color: #3d1f85;
            text-decoration: underline;
        }

        .btn-action-edit.saving {
            color: #2e7d32; 
        }

        .btn-action-remove {
            color: #c62828;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-action-remove:hover {
            color: #b71c1c;
            text-decoration: underline;
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
        
        
        header {
            background-color: #4f0f69; 
            color: white;
            width: 100%;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
    </style>
</head>
<body>


<header>
        <div class="header-left">
          <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
        </div>
        <div class="header-title">PIC Details</div>
        <nav class="header-nav">
            <a href="adminReport.php" class="active-view">Admin Dashboard</a>
            <a href="PICdetails.php" class="active-view">PIC Details</a>
            <a href="registerPIC.php" class="active-view">Register PIC</a>
            <a href="interface.php" class="active-view">Log Out</a>
        </nav>
    </header>

<div class="container">
    <div class="card">
        
        <div class="search-container">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Search for company">
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%;">Company Name</th>
                        <th style="width: 20%;">Company Email</th>
                        <th style="width: 20%;">Company Phone Number</th>
                        <th style="width: 20%;">Company Address</th>
                        <th style="width: 15%; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="companyTableBody">
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                    ?>
                    <tr class="company-row" data-id="<?php echo $row['company_id']; ?>">
                        <td class="editable-cell"><?php echo htmlspecialchars($row['company_name']); ?></td>
                        <td class="editable-cell"><?php echo htmlspecialchars($row['company_email']); ?></td>
                        <td class="editable-cell"><?php echo htmlspecialchars($row['contact_number']); ?></td>
                        <td class="editable-cell">
                            <?php 
                            echo htmlspecialchars($row['company_address'] . ", " . $row['company_state'] . " " . $row['company_city']); 
                            ?>
                        </td>
                        <td style="text-align: center;">
                        <div class="action-cell-container">
                            <span class="btn-action-edit" onclick="handleRowEdit(this)">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </span>
                            <span class="btn-action-remove" onclick="handleRowDelete(this)">
                                <i class="fa-solid fa-trash-can"></i> Remove
                            </span>
                        </div>
                        </td>
                    </tr>
                   <?php
                        }
                    } else {
                        echo "<tr class='no-data-fallback'><td colspan='5' style='text-align:center;'>No data found.</td></tr>";
                    }
                    if (isset($dbconn)) $dbconn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <div class="button-container" style="text-align: right; width: 100%;">
            <button class="btn-primary" onclick="window.location.href='adminReport.php'">Back</button>
        </div>

    </div>
</div>

<script>
   
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filterValue = this.value.toLowerCase().trim();
        const tableBody = document.getElementById('companyTableBody');
        const rows = tableBody.getElementsByClassName('company-row');
        
        let visibleRowsCount = 0;
        
       
        const customFallback = tableBody.querySelector('.custom-no-match-row');
        if (customFallback) customFallback.remove();
        
        
        const basicFallback = tableBody.querySelector('.no-data-fallback');
        if (basicFallback) basicFallback.style.display = 'none';

        for (let i = 0; i < rows.length; i++) {
           
            const nameCell = rows[i].cells[0].textContent.toLowerCase();
            const emailCell = rows[i].cells[1].textContent.toLowerCase();
            const phoneCell = rows[i].cells[2].textContent.toLowerCase();
            const addressCell = rows[i].cells[3].textContent.toLowerCase();
            
            if (nameCell.includes(filterValue) || 
                emailCell.includes(filterValue) || 
                phoneCell.includes(filterValue) || 
                addressCell.includes(filterValue)) {
                
                rows[i].style.display = ""; 
                visibleRowsCount++;
            } else {
                rows[i].style.display = "none"; 
            }
        }
        
        
        if (visibleRowsCount === 0 && rows.length > 0) {
            const noMatchRow = document.createElement('tr');
            noMatchRow.className = 'custom-no-match-row';
            noMatchRow.innerHTML = `<td colspan="5" style="text-align: center; color: #666;">No matching records found for "${this.value}"</td>`;
            tableBody.appendChild(noMatchRow);
        }
    });

    function handleRowEdit(buttonElement) {
        const row = buttonElement.closest('tr');
        const cells = row.querySelectorAll('.editable-cell');
        const isEditing = row.classList.contains('editing-row');

        if (!isEditing) {
            row.classList.add('editing-row');
            cells.forEach(cell => {
                cell.setAttribute('contenteditable', 'true');
            });
            cells[0].focus();

            buttonElement.innerHTML = '<i class="fa-solid fa-circle-check"></i> Save';
            buttonElement.classList.add('saving');
        } else {
            row.classList.remove('editing-row');
            cells.forEach(cell => {
                cell.setAttribute('contenteditable', 'false');
            });

            buttonElement.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> Edit';
            buttonElement.classList.remove('saving');

            alert("Changes to this row have been successfully saved!");
        }
    }
    
    function handleRowDelete(buttonElement) {
        const row = buttonElement.closest('tr');
        const companyId = row.getAttribute('data-id');
        const companyName = row.cells[0].innerText || "this company";
        
        if (confirm(`Are you absolutely sure you want to remove all details for "${companyName}"?`)) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', companyId);

            fetch(window.location.pathname, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(textData => {
                try {
                    const data = JSON.parse(textData);
                    if (data.status === 'success') {
                        row.style.transition = "all 0.4s ease";
                        row.style.opacity = "0";
                        setTimeout(() => {
                            row.remove();
                        }, 400);
                    } else {
                        alert("Database Error:\n" + data.message);
                    }
                } catch (jsonError) {
                    console.error("Raw Response:", textData);
                    alert("Server Output Parse Error:\n" + textData);
                }
            })
            .catch(error => {
                console.error("Error executing deletion process:", error);
                alert("An error occurred: " + error.message);
            });
        }
    }

    const logoToggle = document.getElementById('logoToggle');
    const panelSidebar = document.getElementById('panelSidebar');

    if(logoToggle && panelSidebar) {
        logoToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            panelSidebar.classList.toggle('active');
        });

        document.addEventListener('click', function(event) {
            if (!panelSidebar.contains(event.target) && !logoToggle.contains(event.target)) {
                panelSidebar.classList.remove('active');
            }
        });
    }
</script>

</body>
</html>
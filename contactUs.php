<?php
include("dbconn.php");

if (isset($_POST['submit'])) {
    
    
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $phone   = trim($_POST['phone']);
    $message = trim($_POST['message']);
    
    
    $sql = "INSERT INTO contact_messages (name, email, phone_number, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($dbconn, $sql);
    
    if ($stmt) {
        
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $message);
        $query_execute = mysqli_stmt_execute($stmt);
        
        if ($query_execute) {
            echo "<script>
                    alert('Your question has been successfully sent! We will contact you as soon as possible 😊');
                    window.location.href = 'interface.php';
                  </script>";
            mysqli_stmt_close($stmt);
            mysqli_close($dbconn);
            exit();
        } else {
            die("Database Insert Error: " . mysqli_stmt_error($stmt));
        }
    } else {
        die("Query Preparation Failed: " . mysqli_error($dbconn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us </title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            background-color: #b7a9f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        
        .top-bar {
            background-color: #4f0f69;
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 40px;
            color: white;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

       
        .logo-box-static {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 6px;
        }

        .nav-logo-img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: contain;
        }

        .top-title {
            flex: 1;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .header-spacer {
            flex: 1; 
        }

        
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            width: 100%;
        }

        
        .form-container {
            background-color: #512b7c;
            width: 90%;
            max-width: 1000px;
            margin: 0 auto; 
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            color: white;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-container h2 {
            font-size: 28px;
        }

        .form-container p.subtitle {
            color: #d1c4e9;
            margin-bottom: 10px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        label {
            font-size: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border-radius: 6px;
            border: none;
            outline: none;
            color: black;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }
		
        
        .button-container {
            display: flex;
            justify-content: flex-start;
            gap: 15px;
            margin-top: 10px;
        }

        .btn-submit {
            background-color: #b7a9f0;
            color: #4f0f69;
            border: none;
            padding: 12px 35px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s, color 0.2s;
        }

        .btn-submit:hover {
            background-color: #3d1f85;
            color: white;
        }

        
        .footer-info {
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 20px;
            font-size: 14px;
            line-height: 1.6;
            color: #e0d8f5;
        }
    </style>
</head>

<body>

<div class="top-bar">
    <div class="logo-box-static">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
    </div>
    
    <div class="top-title">Contact Us</div>
    <div class="header-spacer"></div> 
    
    </div>

<div class="main-content">

    <form class="form-container" method="POST" action="">

        <h2>Any Question?</h2>
        <p class="subtitle">Feel free to ask, We are always ready to assist you.</p>
        
        <div class="form-row">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>
          
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" placeholder="Phone Number">
        </div>
          
        <div class="form-group">
            <label>Write a message</label>
            <textarea name="message" placeholder="Type your message here..." required></textarea>
        </div>
        
        <div class="button-container">
            <button type="submit" name="submit" class="btn-submit">Send</button>
            <button type="button" class="btn-submit" onclick="window.location.href='interface.php'">Back</button>
        </div>
        
        <div class="footer-info">
            <p><strong>StartIT Office Location:</strong></p>
            <p>No.18 Jalan 37/16, Seksyen 3,</p>
            <p>Bandar Baru Bangi, Selangor</p>
            <p>09-4238890</p>
            <p>hr@startit.com</p>
        </div>
    </form>

</div>

</body>
</html>
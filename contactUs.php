<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        /* 1. Background Halaman Putih */
        body {
            background-color: #ffffff; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            background-color: #4A0E4E; 
            height: 75px;
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
            object-fit: cover;
            border-radius: 50%;
        }

        .top-title {
            flex: 1;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .header-spacer { flex: 1; }

        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            width: 100%;
        }

        .form-container {
            background-color: #D3C5F5; 
            width: 90%;
            max-width: 1000px;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            color: #4A0E4E; /* Tukar teks ke gelap supaya senang baca atas ungu cair */
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-container h2 { font-size: 28px; }
        .form-container p.subtitle { color: #5B4A8F; margin-bottom: 10px; }

        .form-row { display: flex; gap: 20px; }
        .form-group { flex: 1; display: flex; flex-direction: column; gap: 5px; }

        label { font-size: 15px; font-weight: 600; }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #C4B4E8;
            outline: none;
            color: black;
            font-size: 15px;
            background-color: #ffffff;
        }

        textarea { resize: vertical; min-height: 100px; }
        
        .button-container { display: flex; justify-content: flex-start; gap: 15px; margin-top: 10px; }
		
        .btn-submit {
            background-color: #4A0E4E;
            color: #ffffff;
            border: none;
            padding: 12px 35px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-submit:hover {
            background-color: #2D0830;
        }

        .footer-info {
            margin-top: 20px;
            border-top: 1px solid #B5A5DB;
            padding-top: 20px;
            font-size: 14px;
            line-height: 1.6;
            color: #4A0E4E;
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

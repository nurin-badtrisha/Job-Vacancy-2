<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .nav-header {
            background-color: #4A0E4E; 
            width: 100%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            box-sizing: border-box;
        }
		
        .nav-logo-img {
           width: 45px;
            height: 45px;
            display: block;
            object-fit: cover;
            border-radius: 50%;
        }

        .nav-right-link {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }
		
        .main-content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 700px; 
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .brand-logo-container2 {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
            width: 75%;
        }

        .brand-logo-container2 img {
            max-width: 300px; 
            height: auto;
            object-fit: contain;
        }

        .login-box {
            background-color: #4A0E4E;
            padding: 40px 50px;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            width: 100%;
            box-sizing: border-box;
        }

        .login-box h2 {
            color: white;
            text-align: center;
            font-size: 48px;
            font-weight: 500;
            margin: 0 0 15px 0;
        }

        .role-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .role-label {
            color: white;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .role-label input[type="radio"] {
            accent-color: #b5a6f2;
            transform: scale(1.2);
            cursor: pointer;
        }

        .error-msg {
            background-color: #ffccd5;
            color: #b7094c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .input-group {
            display: grid;
            grid-template-columns: 140px 1fr;
            align-items: center;
            margin-bottom: 25px;
            text-align: left;
        }

        .input-group label {
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 8px;
            background-color: white;
            color: #333;
            font-size: 16px;
            box-sizing: border-box;
        }

        .btn-container {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 5px;
            gap: 15px; 
        }

        .btn-submit {
            background-color: #4A0E4E;
            color: #FFFFFF;
            border: none;
            padding: 12px 40px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-submit:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <div class="nav-header">
        <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
        <a href="aboutUs.php" class="nav-right-link">About Us</a> 
    </div>

    <div class="main-content">
        <form action="authenticate.php" method="POST" class="login-wrapper">
            
            <div class="brand-logo-container2">
                <img src="startIT2.png.png" alt="startIT Logo">
            </div>
            
            <div class="login-box">
                <h2>Log in</h2>
                
                <div class="role-group">
                    <label class="role-label">
                        <input type="radio" name="user_role" value="applicant"> Applicant
                    </label>
                    <label class="role-label">
                        <input type="radio" name="user_role" value="admin"> Admin
                    </label>
                    <label class="role-label">
                        <input type="radio" name="user_role" value="person_in_charge"> Person-In-Charge
                    </label>
                </div>
                
                <?php if(isset($_GET['error'])): ?>
                    <div class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                    
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn-submit">Submit</button>
                <button type="button" class="btn-submit" onclick="window.location.href='interface.php'">Back</button>
            </div>
            
        </form>
    </div>

</body>
</html>

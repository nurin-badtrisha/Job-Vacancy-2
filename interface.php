<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartIT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: #f8f9fa; 
            color: #212529;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        nav {
            background-color:#4A0E4E ; 
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4%; 
            border-bottom: 1px solid #3d0b52; 
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 6px;
        }

        .logo img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: cover;
            border-radius: 50%;
        }

        nav ul {
            display: flex;
            list-style: none;
            align-items: center;
            gap: 15px; 
        }

        /* --- Butang Nav Atas (Gaya Outline Putih) --- */
        nav ul li a {
            color: #ffffff; /* Tulisan putih */
            background-color: transparent; 
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 24px;
            border: 2px solid #ffffff; 
            border-radius: 50px; 
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #ffffff;
            color: #4f0f69; 
        }

        .hero-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center; 
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .hero-logo-wrapper {
            margin-bottom: 30px;
            width: 100%;
            display: flex;
            justify-content: center; 
            align-items: center;
        }

        .hero-logo {
            width: 380px; 
            max-width: 100%;
            height: auto;
            display: block;
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 20px;
        }

        h1 span.highlight {
            color: #4A0E4E;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 35px;
            margin-bottom: 25px;
        }

        .buttons a {
            text-decoration: none;
        }

        .btn {
            padding: 14px 40px;
            min-width: 160px;
            background: #4f0f69;
            color: white;
            font-size: 18px;
            font-weight: 600;
            border: none;
            border-radius: 50px; 
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(79, 15, 105, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            justify-content: center;
            align-items: center;
        }

        .btn:hover {
            background:#4A0E4E;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(79, 15, 105, 0.4);
        }

        .register-text {
            font-size: 15px;
            color: #6c757d;
        }

        .register-text a {
            color: #4f0f69;
            font-weight: 700;
            text-decoration: none;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            padding: 30px 20px;
            color: #a0aec0;
            font-size: 14px;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <div class="logo">
            <img src="startIt logo.jpg" alt="StartIT Logo">
        </div>
        <ul>
            <li><a href="aboutUs.php">About Us</a></li>
            <li><a href="contactUs.php">Contact Us</a></li>
        </ul>
    </nav>
</header>

<main class="hero-container">
    
    <div class="hero-logo-wrapper">
        <img src="startIT2.png.png" alt="StartIT Banner" class="hero-logo">
    </div>

    <h1>Find your <span class="highlight">Dream Job</span> here!</h1>

    <div class="buttons">
        <a href="login.php" class="btn">Log In</a>
        <a href="registerUser.php" class="btn">Register</a>
    </div>

    <p class="register-text">First time user? <a href="registerUser.php">Register now!</a></p>

</main>

<footer>
    &copy; <?php echo date("Y"); ?> StartIT. All rights reserved.
</footer>

</body>
</html>

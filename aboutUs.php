<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartIT</title>
</head>
<body>

<nav>
    <div class="logo">
        <img src="startIt logo.jpg" width = "40%">
    </div>

    <ul>
        <li><a href="aboutUs.php">About Us</a></li>
		 <li><a href="interface.php">Back</a></li>
    </ul>
</nav>

    <div class="about-hero">
        <p style = "text-align: center;"> <img src="startIT.png" alt="" width = "270" height = "95"></p><br>
        <div class="headline">
			Find your <span>Dream</span><br>
			<span>Job</span> here!
		</div>
    </div>

    <div class="container">
        
        <div class="section">
            <h2>Our Story</h2>
            <p>Founded in 2026, StartIT was created with a simple mission; to connect talented IT professionals with meaningful career opportunities in the technology industry. What began as an innovative project has evolved into a centralized platform designed to simplify the recruitment process for both job seekers and employers.</p>
			<p>At StartIT, we believe that finding the right opportunity should be efficient, accessible and hassle-free. That is why we focus on providing a user-friendly platform where individuals can explore job vacancies, submit applications and track their career progress with ease. By bringing employers and technology talent together in one place, StartIT aims to support career growth and contribute to the development of a stronger digital workforce.</p></p>

        </div>

        <div class="section">
            <h2>Our Mission</h2>
            <p>Our mission is to connect technology professionals with meaningful career opportunities through a simple, reliable and accessible platform. We are committed to creating a seamless recruitment experience that supports career growth, empowers employers and contributes to a stronger technology workforce.</p>
        </div>

        <div class="section">
            <h2>Our Foundations</h2>
            <div class="values-grid">
                <div class="value-card">
                    <h3>Accessibility</h3>
                    <p>Making job opportunities easier to access for students, fresh graduates and job seekers everywhere.</p>
                </div>
                <div class="value-card">
                    <h3>Simplicity</h3>
                    <p>Creating a clean and user-friendly platform that is simple to navigate and use.</p>
                </div>
                <div class="value-card">
                    <h3>Efficiency</h3>
                    <p>Helping employers and applicants manage recruitment and applications more effectively.</p>
                </div>
            </div>
        </div>

    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> StartIT. All rights reserved.
    </footer>

<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }

        /* Navigation Bar */
        nav {
	background-color: #4b1a6a;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    color: white;
}

.logo img{
    width:45px;
}

nav ul{
    display:flex;
    list-style:none;
}

nav ul li{
    margin-left:35px;
}

nav ul li a{
    color:white;
    text-decoration:none;

    font-size:16px;
    font-weight:bold;

    transition:0.2s;
}

nav ul li a:hover{
    color:#d8c5ff;
}

        /* Hero Section */
        .about-hero {
            background-color: #b1a1ed;
            color: white;
            text-align: center;
            padding: 60px 20px;
        }
		
		.headline {
            font-size: 45px;
            color: black;
            margin-bottom: 40px;
			font-weight: bold;
        }

        .headline span {
            color: #6b4b3e;
            font-weight: bold;
        }

        /* Main Content Container */
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .section h2 {
            color: #b1a1ed;
            margin-top: 0;
            border-bottom: 2px solid #f4f7f6;
            padding-bottom: 10px;
        }

        /* Values Grid */
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .value-card {
            background: #f4f7f6;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }
        .value-card h3 {
            margin-top: 0;
            color: #333;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
	
</body>
</html>
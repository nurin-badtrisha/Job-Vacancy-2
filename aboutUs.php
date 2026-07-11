<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | StartIT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<nav>
    <div class="nav-container">
        <div class="logo-area">
            <img src="startIt logo.jpg" alt="StartIT Logo" class="nav-logo">
        </div>
        <ul class="nav-links">
            <li><a href="aboutUs.php" class="active">About Us</a></li>
            <li><a href="interface.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back</a></li>
        </ul>
    </div>
</nav>

<header class="about-hero">
    <div class="hero-content">
        <div class="hero-logo-container">
            <img src="startIT2.png.png" alt="startIT" class="hero-brand-img">
        </div>
        <h1 class="headline">
            Find your <span class="gradient-text">Dream Job</span> here!
        </h1>
    </div>
    <div class="wave-splitter">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 1200" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,42.4V0Z" class="shape-fill"></path>
        </svg>
    </div>
</header>

<main class="container">
    <div class="grid-two-cols">
        <section class="section glass-card">
            <div class="section-icon"><i class="fa-solid fa-book-open"></i></div>
            <h2>Our Story</h2>
            <p>Founded in 2026, <strong>StartIT</strong> was created with a simple mission: to connect talented IT professionals with meaningful career opportunities in the technology industry. What began as an innovative project has evolved into a centralized platform designed to simplify the recruitment process for both job seekers and employers.</p>
            <p>At StartIT, we believe that finding the right opportunity should be efficient, accessible, and hassle-free. That is why we focus on providing a user-friendly platform where individuals can explore job vacancies, submit applications, and track their career progress with ease. By bringing employers and technology talent together in one place, StartIT aims to support career growth and contribute to the development of a stronger digital workforce.</p>
        </section>

        <section class="section glass-card mission-card">
            <div class="section-icon"><i class="fa-solid fa-bullseye"></i></div>
            <h2>Our Mission</h2>
            <p>Our mission is to connect technology professionals with meaningful career opportunities through a simple, reliable, and accessible platform. We are committed to creating a seamless recruitment experience that supports career growth, empowers employers, and contributes to a stronger technology workforce.</p>
        </section>
    </div>
    <section class="section glass-card foundations-section">
        <div class="text-center">
            <div class="section-icon"><i class="fa-solid fa-gem"></i></div>
            <h2>Our Foundations</h2>
            <p class="section-subtitle">The core values driving our platform's innovation and user success.</p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon"><i class="fa-solid fa-universal-access"></i></div>
                <h3>Accessibility</h3>
                <p>Making job opportunities easier to access for all IT students, fresh graduates, and job seekers everywhere.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                <h3>Simplicity</h3>
                <p>Creating a clean and user-friendly platform that is simple to navigate and use.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i class="fa-solid fa-bolt"></i></div>
                <h3>Efficiency</h3>
                <p>Helping employers and applicants manage recruitment and applications more effectively.</p>
            </div>
        </div>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> <span>StartIT</span>. All rights reserved.</p>
</footer>

<style>
    :root {
        --primary-purple: #4A0E4E;   
        --hero-bg-cair: #D3C5F5;     
        --secondary-purple: #D3C5F5;
        --light-purple: #F5F2FC;      
        --dark-text: #200924;
        --body-bg: #F9F8FC;
        --card-bg: #ffffff;
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1.7;
        background-color: var(--body-bg);
        color: var(--dark-text);
    }

    nav {
        background-color: var(--primary-purple);
        height: 75px;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 25px rgba(74, 14, 78, 0.15);
        width: 100%;
    }

    .nav-container {
        width: 100%;
        height: 100%;
        padding: 0 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .logo-area {
        display: flex;
        align-items: center;
    }

    .nav-logo {
        height: 44px;
        width: 44px;
        object-fit: cover;
        border-radius: 50%;
        border: none;
        box-shadow: none;
    }

    .nav-links {
        display: flex;
        align-items: center;
        list-style: none;
        gap: 20px;
    }

    .nav-links li a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 20px;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .nav-links li a:hover, .nav-links li a.active {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.12);
    }

    .nav-links li a.btn-back {
        border: 1px solid rgba(255, 255, 255, 0.4);
        background-color: rgba(255, 255, 255, 0.15);
    }

    .nav-links li a.btn-back:hover {
        background-color: #ffffff;
        color: var(--primary-purple);
        border-color: #ffffff;
        transform: translateY(-1px);
    }

   .about-hero {
        background-color: var(--hero-bg-cair);
        color: white;
        text-align: center;
        padding: 70px 20px 100px 20px;
        position: relative;
        border-bottom-left-radius: 50px;
        border-bottom-right-radius: 50px;
    }

    .hero-logo-container {
        margin-bottom: 20px;
    }

    .hero-brand-img {
        max-width: 200px;
        height: auto;
        filter: drop-shadow(0 4px 10px rgba(74, 14, 78, 0.15));
    }
    
    .headline {
        font-size: 42px;
        color: var(--primary-purple); 
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    /* Teks Dream Job Menyerlah Moden */
    .headline .gradient-text {
        background: linear-gradient(45deg, #ffffff, #FFF3D1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        display: inline-block;
        position: relative;
        text-shadow: 0 2px 10px rgba(74, 14, 78, 0.1);
    }

   .wave-splitter {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
	}

    .wave-splitter svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 40px;
    }

    .wave-splitter .shape-fill {
        fill: var(--body-bg);
    }

   .container {
    max-width: 1140px;
    margin: -50px auto 60px auto;
    padding: 0 24px;
    position: relative;
    z-index: 10;
	}

    .glass-card {
        background: var(--card-bg);
        border: 1px solid rgba(74, 14, 78, 0.05);
        border-radius: 18px;
        box-shadow: 0 12px 35px rgba(74, 14, 78, 0.04);
        padding: 40px;
        transition: var(--transition);
    }

    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 45px rgba(74, 14, 78, 0.08);
    }

    .grid-two-cols {
        display: grid;
        grid-template-columns: 1.5fr 1.5fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    /* Ikon & Tajuk Kad */
    .section-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        background-color: var(--light-purple);
        color: var(--primary-purple);
        border-radius: 12px;
        font-size: 20px;
        margin-bottom: 18px;
    }

    .section h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-purple);
        margin-bottom: 16px;
    }

    .section p {
        margin-bottom: 15px;
        color: #4A3E4D;
        font-size: 15px;
        text-align: justify;
    }

    .mission-card {
        background: linear-gradient(180deg, #ffffff 0%, #FAF8FC 100%);
        border-left: 4px solid var(--primary-purple);
    }

    /* Foundations Section */
    .foundations-section {
        margin-top: 30px;
    }

    .text-center {
        text-align: center;
    }

    .section-subtitle {
        max-width: 600px;
        margin: -10px auto 30px auto !important;
        color: #6A596E !important;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
    }

    .value-card {
        background: #FAF8FC;
        border: 1px solid #F0EAF2;
        padding: 30px 20px;
        border-radius: 14px;
        text-align: center;
        transition: var(--transition);
    }

    .value-card:hover {
        background: var(--primary-purple);
        color: white;
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(74, 14, 78, 0.25);
    }

    .value-icon {
        font-size: 28px;
        color: var(--primary-purple);
        margin-bottom: 15px;
        transition: var(--transition);
    }

    .value-card:hover .value-icon {
        color: #ffffff;
    }

    .value-card h3 {
        margin-bottom: 10px;
        font-size: 18px;
    }

    .value-card p {
        font-size: 14px;
        color: #5A4A5E;
        transition: var(--transition);
    }

    .value-card:hover p {
        color: rgba(255, 255, 255, 0.85);
    }

    /* Footer */
    footer {
        text-align: center;
        padding: 30px 20px;
        color: #7A697E;
        font-size: 14px;
        background-color: #ffffff;
        margin-top: 40px;
        border-top: 1px solid #F0EAF2;
    }

    footer span {
        color: var(--primary-purple);
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .grid-two-cols {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .nav-container {
            padding: 0 20px;
        }
        .headline {
            font-size: 28px;
        }
    }
</style>

</body>
</html>

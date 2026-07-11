<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register Person In Charge</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", sans-serif;
    }

    body {
        background-color: #ffffff;;
    }

   
    .top-bar {
        background-color: #4A0E4E;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 40px;
        color: white;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        max-height: 45px;
        width: auto;
    }

    .about {
        font-size: 16px;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.15);
        padding: 6px 15px;
        border-radius: 20px;
    }
  
    .form-container {
        background-color: #4A0E4E;
        width: 85%;
        max-width: 1000px;
        margin: 50px auto 50px auto; 
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.3);
        color: white;
    }

   
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px 30px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

   
    .form-group.full-width {
        grid-column: span 2;
    }

    label {
        display: block;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #e2d5f3;
    }

    input, select {
        width: 100%;
        padding: 12px 15px;
        border-radius: 8px;
        border: 2px solid transparent;
        outline: none;
        background-color: #ffffff;
        color: #2d2525;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    input:focus, select:focus {
        border-color: #b9acf3;
        box-shadow: 0 0 10px rgba(185, 172, 243, 0.5);
    }

   
    .action-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 35px;
    }

    .submit-btn {
        background-color: #4A0E4E;
        color: white;
        border: 2px solid #6a3fa0;
        padding: 12px 50px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #6a3fa0;
        border-color: #b9acf3;
        transform: translateY(-2px);
    }

   
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
        .page-title, .form-container {
            width: 90%;
            padding: 25px;
        }
    }
	
	 
        header {
            background-color: #4A0E4E; 
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
		
		  .header-title {
            flex: 1;
            color: white;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
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
		
		  .nav-logo-img {
            width: 45px;
            height: 45px;
            display: block;
            object-fit: cover;
            border-radius: 50%;
        }
</style>
</head>

<body>

<header>
        <div class="header-left">
		  <img src="startIT logo.jpg" alt="startIT Menu Logo" class="nav-logo-img">
        </div>
        <div class="header-title">Register PIC</div>
        <nav class="header-nav">
            <a href="adminReport.php" class="active-view">Admin Dashboard</a>
            <a href="PICdetails.php" class="active-view">PIC Details</a>
			<a href="registerPIC.php" class="active-view">Register PIC</a>
			<a href="interface.php" class="active-view">Log Out</a>
        </nav>
    </header>

<form class="form-container" action="registerPICProcess.php" method="POST">

    <div class="form-grid">
        
        <div class="form-group full-width">
            <label>Company Name:</label>
            <input type="text" name="company_name" placeholder="e.g. StartIT Tech Sdn Bhd" required>
        </div>

        <div class="form-group">
            <label>Company Email:</label>
            <input type="email" name="company_email" placeholder="company@example.com" required>
        </div>
        
        <div class="form-group">
            <label>Company Phone Number:</label>
            <input type="text" name="company_phone" placeholder="e.g. 0123456789" required>
        </div>

        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Choose a username" required>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="form-group full-width">
            <label>Company Address:</label>
            <input type="text" name="company_address" placeholder="Street name, industrial zone, etc." required>
        </div>

        <div class="form-group">
            <label>State:</label>
            <select name="state" required>
                <option value="">-- Select State --</option>
                <option value="JOHOR">JOHOR</option>
                <option value="KEDAH">KEDAH</option>
                <option value="KELANTAN">KELANTAN</option>
                <option value="MELAKA">MELAKA</option>
                <option value="NEGERI SEMBILAN">NEGERI SEMBILAN</option>
                <option value="PAHANG">PAHANG</option>
                <option value="PENANG">PENANG</option>
                <option value="PERAK">PERAK</option>
                <option value="PERLIS">PERLIS</option>
                <option value="TERENGGANU">TERENGGANU</option>
                <option value="SELANGOR">SELANGOR</option>
                <option value="SABAH">SABAH</option>
                <option value="SARAWAK">SARAWAK</option>
                <option value="KUALA LUMPUR">KUALA LUMPUR</option>
                <option value="LABUAN">LABUAN</option>
                <option value="PUTRAJAYA">PUTRAJAYA</option>
            </select>
        </div>

        <div class="form-group">
            <label>City:</label>
            <input type="text" name="city" placeholder="e.g. Cheras" required>
        </div>
        
    </div>

    <div class="action-container">
        <button type="submit" name="Submit" class="submit-btn">Submit</button>
    </div>

</form>

</body>
</html>

<!DOCTYPE html>
<html lang = "en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>StartIT</title></head>
<body bgcolor = "#b1a1ed">

<header>

<nav>
    <div class="logo">
        <img src="startIt logo.jpg">
    </div>

    <ul>
        <li><a href="aboutUs.php">About Us</a></li>
		<li><a href="contactUs.php">Contact Us</a></li>
    </ul>
</nav>


<br><br><br>

<p style = "text-align: center;"> <img src="startIT.png" alt="" width = "270" height = "95"></p><br>

<font face = "Sans-serif" size = "8">
<p style = "text-align: center;">Find your <font face = "Sans-serif" size = "8" color = "#5e4b45">Dream
<br style = "text-align: center;">Job<font face = "Sans-serif" size = "8" color = "black"> here!</p>

<br>

<div class="buttons">
    <a href="login.php" class="btn">Log In</a>
    <a href="registerUser.php" class="btn">Register</a>
</div>

<p style = "text-align: center;"><font face = "Sans-serif" size = "4" color = "black">First time user? Register now!</p>

<br>
<br>
<br>

<footer>
        &copy; <?php echo date("Y"); ?> StartIT. All rights reserved.
</footer>

<style>
*{
	font-family: "Segoe UI", sans-serif;
	margin:0;
	padding:0;
	box-sizing:border-box;
}

.buttons{
    display:flex;
	justify-content:center;
    gap:40px;
    margin-top:40px;
}

.buttons a {
	text-decoration: none;
	display:flex;
	justify-content:center;
	align-items:center;
}

.btn{
    width:160px;
    height:55px;

    background:#5a2386;

    color:white;
    font-size:26px;
    font-weight:bold;

    border:none;
    border-radius:8px;

    cursor:pointer;

    box-shadow:0px 8px 15px rgba(0,0,0,0.25);

    transition:0.2s;
}

.btn:hover{
    transform:translateY(-3px);
}

nav {
	background-color: #4f0f69;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 40px;
    color: white;
}

.logo img{
    width:45px;
	max-height: 45px;
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


        footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 0.9rem;
        }
		
</style>
</body>
</html>
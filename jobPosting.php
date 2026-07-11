<?php
session_start();

if (!isset($_SESSION['username'])) {
	die("Error: Access denied. Please log in first.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Job Posting</title>
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		font-family: "Segoe UI", sans-serif;
	}

	body {
		background: #F8F9FA;
		color: #2D2D2D;
	}

	.main-container {
		max-width: 1100px;   
		margin: 40px auto;   
		padding: 20px;
	}

	.top-bar {
		background-color: #4A0E4E;
		height: 70px;
		display: flex;
		align-items: center;
		padding: 0 40px;
		color: white;
		position: relative;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
	}

	.top-title {
		flex-grow: 1;
		text-align: center;
		font-size: 1.4rem;
		font-weight: 600;
	}

	.error-alert {
		background-color: #FEE2E2;
		color: #DC2626;
		border: 1px solid #DC2626;
		padding: 15px;
		margin-bottom: 20px;
		border-radius: 8px;
		font-weight: bold;
		font-size: 16px;
	}

	.upload-container {
		display: flex;
		justify-content: center;
		margin-bottom: 40px;
		margin-top: 20px;
	}

	.upload-box {
		width: 190px;
		height: 180px;
		background: #FFFFFF;
		border: 1px solid #E2E8F0;
		border-radius: 20px;
		display: flex;
		justify-content: center;
		align-items: center;
		overflow: hidden;
		cursor: pointer;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
		transition: transform 0.2s, border-color 0.2s;
	}

	.upload-box img {
		width: 70px;
		opacity: 0.5;
		transition: 0.3s;
	}

	.upload-box:hover {
		transform: translateY(-2px);
		border-color: #4A0E4E;
	}

	#previewImage.preview-active {
		width: 100%;
		height: 100%;
		object-fit: cover;
		opacity: 1;
	}

	.form-grid {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 20px 25px;
		background-color: #FFFFFF;
		padding: 40px;
		border-radius: 20px;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
		border: 1px solid #EAEAEA;
	}

	.form-group label {
		font-size: 14px;
		font-weight: 700;
		color: #4A5568;
		display: block;
		margin-bottom: 8px;
	}

	.form-group input {
		width: 100%;             
		height: 45px;
		border: 1px solid #E2E8F0;
		border-radius: 8px;
		font-size: 14px;
		padding: 10px 14px;
		outline: none;
		background: #F8F9FA;
		color: #2D2D2D;
		display: block;          
		transition: border-color 0.2s, background-color 0.2s;
	}

	.form-group input:focus, .form-group textarea:focus {
		border-color: #4A0E4E;
		background-color: #FFFFFF;
	}

	.form-group.full-width {
		grid-column: span 3;
	}

	.form-group textarea {
		width: 100%;
		height: 150px;
		border: 1px solid #E2E8F0;
		border-radius: 8px;
		font-size: 14px;
		padding: 12px 14px;
		outline: none;
		background: #F8F9FA;
		color: #2D2D2D;
		resize: none;
		transition: border-color 0.2s, background-color 0.2s;
	}

	.button-container {
		display: flex;
		justify-content: flex-end;
		gap: 15px; 
		margin-top: 30px;
	}

	.post-btn {
		background: #4A0E4E;
		color: white;
		border: none;
		padding: 12px 40px;
		font-size: 1rem;
		font-weight: bold;
		border-radius: 25px;
		cursor: pointer;
		box-shadow: 0 4px 6px rgba(74, 14, 78, 0.2);
		transition: background-color 0.2s, transform 0.1s;
	}

	.post-btn:hover {
		background: #350A38;
		transform: translateY(-1px);
	}

	.back-btn {
		background: none;
		color: #4A0E4E;
		border: 1px solid #4A0E4E;
		padding: 12px 40px;
		font-size: 1rem;
		font-weight: bold;
		border-radius: 25px;
		cursor: pointer;
		transition: background-color 0.2s, transform 0.1s;
	}

	.back-btn:hover {
		background: rgba(74, 14, 78, 0.05);
		transform: translateY(-1px);
	}

	@media(max-width: 900px){
		.form-grid {
			grid-template-columns: 1fr;
		}
		.form-group.full-width {
			grid-column: span 1;
		}
	}
</style>

<div class="top-bar">
	<div class="top-title">Job Posting</div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="main-container">

	<?php if (isset($_SESSION['error'])): ?>
		<div class="error-alert">
			<i class="fa-solid fa-triangle-exclamation"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
		</div>
	<?php endif; ?>

	<form method="POST" action="jobPostingProcess.php" enctype="multipart/form-data">

		<div class="upload-container">
			<label for="jobImage" class="upload-box">
				<img id="previewImage" src="https://cdn-icons-png.flaticon.com/512/685/685655.png" alt="Upload Image">
			</label>
			<input type="file" id="jobImage" name="job_image" accept="image/*" hidden>
		</div>
	
		<div class="form-grid">
			<div class="form-group">
				<label>Job Position:</label>
				<input type="text" name="job_position" required>
			</div>

			<div class="form-group">
				<label>Company Name:</label>
				<input type="text" name="company_name" required>
			</div>
			
			<div class="form-group">
				<label>Location:</label>
				<input type="text" name="job_location" required>
			</div>

			<div class="form-group">
				<label>Language Preferences:</label>
				<input type="text" name="language" required>
			</div>

			<div class="form-group">
				<label>Educational Level:</label>
				<input type="text" name="education" required>
			</div>

			<div class="form-group">
				<label>Years of Working Experience:</label>
				<input type="text" name="experience" required>
			</div>

			<div class="form-group">
				<label>Working Days:</label>
				<input type="text" name="working_days" required>
			</div>

			<div class="form-group">
				<label>Salary Range:</label>
				<input type="text" name="salary_range" required>
			</div>
			
			<div class="form-group full-width">
				<label> Job Description:</label>
				<textarea placeholder="Enter job description here.." name="job_description" required></textarea>
			</div>
		</div>

		<div class="button-container">
			<button type="button" class="back-btn" onclick="window.location.href='pic.php'">
				BACK
			</button>
			<button type="submit" name="submit" class="post-btn">
				POST!
			</button>
		</div>
	</form>
</div>

<script>
const imageInput = document.getElementById("jobImage");
const previewImage = document.getElementById("previewImage");
const form = document.querySelector("form");

imageInput.addEventListener("change", function(){
	const file = this.files[0];
	if(file){
		const reader = new FileReader();
		reader.onload = function(e){
			previewImage.setAttribute("src", e.target.result);
			previewImage.classList.add("preview-active");
		}
		reader.readAsDataURL(file);
	}
});

form.addEventListener("submit", function(event) {
	if (imageInput.files.length === 0) {
		event.preventDefault(); 
		alert("Please upload a company logo or job banner image before posting!");
		const uploadBox = document.querySelector(".upload-box");
		uploadBox.style.borderColor = "#DC2626";
		uploadBox.style.backgroundColor = "#FEE2E2";
	}
});
</script>
</body>
</html>

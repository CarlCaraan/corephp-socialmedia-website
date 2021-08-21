<?php
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Welcome to Twitter Clone</title>
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<link rel="stylesheet" href="bootstrap-4.6.0-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"> <!--- For animation.css CDN -->
	<link rel="stylesheet" href="assets/css/fixed.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> <!-- Fix php code of show/hide -->
</head>
<body>

<!-- Fixed Register Button that proceed to login! -->
	<?php

	if(isset($_POST['register_button'])) {
		echo '
		<script>

		$(document).ready(function() {
			$(".login__wrapper").hide();
			$(".register__wrapper").show();
			$(".spinner-border").hide();
		});

		</script>

		';
	}

	?>


<!-- Start Form Section -->
	<!-- Spinner -->
	<div class="center">
		<div class="spinner-border"></div>
	</div>

<div class="container animate__animated animate__bounceIn animate__delay-1s" id="container-prop">
	<div class="control">

	<!-- Login Form -->
	<div class="login__wrapper">
		<form class="" action="register.php" method="POST">
			<!-- Logo and Header -->
			<div class="center">
				<span class="fa-layers fa-4x">
					<i class="fab fa-twitter fa-inverse shadow" data-fa-transform="shrink-6"></i>
				</span>
			</div>
			<h3>Login or Sign Up Below</h3>

			<div class="form-group">
			<label for="log_email">Email:</label>
				<input type="email" class="form-control" name="log_email" placeholder="Email Address" value="<?php
				if(isset($_SESSION['log_email'])) { //Start the SESSION to remain users input
					echo $_SESSION['log_email'];
				} ?>" required>
			</div>

			<div class="form-group">
				<label for="log_password">Password:</label>
				<input class="form-control" type="password" name="log_password" placeholder="Password">
			</div>

				<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo "Email or password was incorrect<br>"; ?><!-- Show Error Message -->

			<div class="center">
				<input class="btn btn-outline-light btn-lg shadow-sm" id="ibtn-lg" type="submit" name="login_button" value="Login"><br>
			</div>

			<div class="text-center">
				<a href="#" class="signup" id="signup">Need an account? Register here!</a>
			</div>
		</form>
	</div> <!-- End Login Wrapper -->

	<!-- Register Form -->
	<div class="register__wrapper">
		<form  class"" action="register.php" method="POST">
			<!-- Logo and Header -->
			<div class="center">
				<span class="fa-layers fa-4x">
					<i class="fab fa-twitter fa-inverse shadow" data-fa-transform="shrink-6"></i>
				</span>
			</div>
			<h3>Login or Sign Up Below</h3>

			<div class="form-group">
				<label for="reg_fname">Full Name:</label>
				<input class="form-control" type="text" name="reg_fname" placeholder="First Name" value="<?php
				if(isset($_SESSION['reg_fname'])) { //Start the SESSION to remain users input
					echo $_SESSION['reg_fname'];
				} ?>" required>
				<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>
			</div>

			<div class="form-group">
				<input class="form-control" type="text" name="reg_lname" placeholder="Last Name" value="<?php
				if(isset($_SESSION['reg_lname'])) {
					echo $_SESSION['reg_lname'];
				} ?>" required>
				<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>
			</div>

			<div class="form-group">
				<label for="reg_email">Email:</label>
				<input class="form-control" type="email" name="reg_email" placeholder="Email" value="<?php
				if(isset($_SESSION['reg_email'])) {
					echo $_SESSION['reg_email'];
				} ?>" required>
			</div>

			<div class="form-group">
				<input class="form-control" type="email" name="reg_email2" placeholder="Confirm Email" value="<?php
				if(isset($_SESSION['reg_email2'])) {
					echo $_SESSION['reg_email2'];
				} ?>" required>
				<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>";
				else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
				else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; ?>
			</div>

			<div class="form-group">
				<label for="reg_password">Password:</label>
				<input class="form-control" type="password" name="reg_password" placeholder="Password" required>
			</div>

			<div class="form-group">
				<input class="form-control" type="password" name="reg_password2" placeholder="Confirm Password" required>
				<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>";
				else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
				else if(in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>"; ?>
			</div>

			<div class="center">
				<input class="btn btn-outline-light btn-lg shadow-sm" type="submit" name="register_button" value="Register">
			</div>
			<!-- Register Successful Message -->
			<?php if(in_array("<span>You're all set! Go ahead and login!</span><br>", $error_array)) echo "<span>You're all set! Go ahead and login!</span><br>"; ?>

			<div class="text-center">
				<a href="#" class="signin" id="signin">Already have an account? Sign in here!</a>
			</div>
		</form>
	</div> <!-- End Register Wrapper -->

	</div> <!-- End Control -->
</div> <!-- End Container -->


<!-- Start Fixed Background -->
<div class="fixed-wrap">
	<div id="fixed">
	</div>
</div> <!-- End Fixed Background -->

<!-- End Form Section -->


<!-- Script Source Files -->
<script src="https://use.fontawesome.com/releases/v5.10.2/js/all.js"></script>
<script src="assets/js/jquery-3.5.1.min.js"></script>
<script src="assets/js/custom.js"></script>
<!-- End of Script Source Files -->

</body>
</html>

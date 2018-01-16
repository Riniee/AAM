<?php
    require "App.php";
	if(isset($_SESSION['username'])) {
		header('Location:dashboard.php');
	}
    require "head.php";
?>  
<body>
	<div class="login-wrapper">
		<form  id="password-reset" method="post" action="model/password_reset_model.php">
			<div class="inner">
				<div class="login-content">
					<?php require 'display_alert.php'; ?>
					<div class="login-block">
						<label>New Password</label>
						<input id="password" type="password" name="password" class="form-control" placeholder="" >
					</div>
					<div class="login-block">
						<label>Confirm password</label>
						<input id="cpassword" type="password" name="cpassword" class="form-control" placeholder="" >
					</div>
					<div class="login-block">
						<button type="submit" name="submit" class="btn-login">Reset password</button>
					</div>
				</div>
			</div>
		</form>
    </div>
	<script src="assets/js/password_reset_validate.js"></script>
</body>

</html>
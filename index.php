<?php
    require "App.php";
	if(isset($_SESSION['username'])) {
		header('Location:dashboard.php');
	}
    require "head.php";
?>  
<body class="swatch1">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="login-main">
					<div class="login-sub">
						<div class="bg-img"></div>
						<form id="login-form" method="post" action="model/LoginModel.php">
							<?php include 'display_alert.php'; ?>
							<div class="form-div">
								<div class="form-group">
									<label>User Id</label>
									<input type="text" name="username" id="username">
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" name="password" id="password">
								</div>
								<div class="form-group">
									<span class="group-btn">     
										<button name="submit" type="submit" class="btn btn-sm btn-primary">login</a>
									</span>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/js/login_form_validate.js"></script>
</body>

</html>
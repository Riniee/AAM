<?php
    require "App.php";
if(isset($_SESSION['username'])) {
    header('Location:dashboard.php');
}
    require "head.php";
?>  
<body>
    <div class="login-wrapper">
        <form method="POST" action="model/LoginModel.php">
            <div class="inner">
                <div class="login-content">
        <?php require 'display_alert.php'; ?>
                    <div class="login-block">
                        <label>user ID</label>
                        <input type="text" name="username" class="form-control" placeholder="" >
                    </div>
                    <div class="login-block">
                        <label>password</label>
                        <input type="password" name="password" class="form-control" placeholder="" >
                    </div>
                    <div class="login-block">
                        <button type="submit" name="submit" class="btn-login">login</button>
                        <span>Forgot Password? Click <a href="forgot_password.php">here</a></span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="assets/js/login_form_validate.js"></script>
</body>

</html>

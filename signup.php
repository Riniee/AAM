<?php
    require "App.php";
    require "common/head.php";
	//$roles = App::getUserRoles();
	//$roles = [];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>AAM</title>
        <link rel="icon" href="./assets/images/icon.jpg">
        <meta charset="UTF-8">
        <meta name="description" content="">
        <meta name="author" content="Elite">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="./assets/css/custom.css" rel="stylesheet" />
        <link href="./assets/css/font.css" rel="stylesheet" />
        <link rel="stylesheet" href="assets/css/custom/lib-style.css">
        <link rel="stylesheet" href="assets/css/custom/skins/_all-skins.min.css">
        <script type="text/javascript" src="./libraries/jquery.js"></script>
        <script type="text/javascript" src="./libraries/bootstrap.js"></script>
        <script type="text/javascript" src="./libraries/custom.js"></script>
    </head>

    <body class="swatch1">
        <!-- Login Wrapper -->
        <div class="login-wrapper">
            <div class="inner">
                <form action="model/RegistrationModel.php" method="post">
                <div class="login-content">
                    <div class="login-block"><br>
						<?php require 'display_alert.php'; ?>
                        <label>Email:</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="">
                        <div class="error-show" style="display:none">error messages here</div>
                    </div>
                    <div class="login-block">
                        <label>Mobile:</label>
                        <input type="text" class="form-control" id="mobile" name="mobile"> </div>
                    <div class="login-block">
                        <label>Username:</label>
                        <input id="uname" type="text" name="uname" class="form-control"> </div>
                    <div class="login-block">
                        <label>Password:</label>
                        <input type="password" class="form-control" id="password" name="password"> </div>
                    <div class="login-block">
                        <label>User Role</label>
                        <p>
                            <label>
                                <input type="checkbox" name ="user_role[]" value = "Proof Reader"> proof reader </label>
                        </p>
                        <p>
                            <label>
                                <input type="checkbox" name ="user_role[]" value = "Proof Admin"> proof admin </label>
                        </p>
                        <p>
                            <label>
                                <input type="checkbox" name ="user_role[]" value = "Reviewer">reviewers </label>
                        </p>
                    </div>
                    <div class="login-block">
                        <button type="submit" name="submit" value="Signup" id="form-submit" class="btn-login">save</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <script src="assets/js/login_form_validate.js"></script>
    </body>

    </html>
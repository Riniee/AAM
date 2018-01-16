<?php
    require "App.php";
    require "head.php";

?>
    <body>
        <div class="login-wrapper">
            <form id="forgot-password-mail"  method="POST" action="model/forgot_password_email_model.php">
                <div class="inner">
                    <div class="login-content">
                        <?php require 'display_alert.php'; ?>
                        <div class="login-block">
                            <label>Enter Email</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="">
                        </div>
                        <div class="login-block">
                            <button type="submit" name="submit" class="btn-login">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script src="assets/js/forgot_password_email_validate.js"></script>
    </body>

    </html>
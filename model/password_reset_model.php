<?php
	/**
	 * @author - sathish
	 * @description -  password reset model
	 *
	 */
    require "../App.php";
    require "../data/PasswordManager.php";
    $email = $_SESSION['email'];
    if (isset($_POST['submit'])) {
        try {
            $password=htmlentities($_POST['password']);
            $cpassword=htmlentities($_POST['cpassword']);
            
            //validation
            if($password =="") {
                $_SESSION['error']="Password cannot be empty";
                header('Location:../password_reset.php');return;
            }
            if($cpassword =="") {
                $_SESSION['error']="Confirm Password cannot be empty";
                header('Location:../password_reset.php');return;
            }
            if($password != $cpassword) {
                $_SESSION['error']="Password Missmatched";
                header('Location:../password_reset.php');return;
            }
            
            $reset = PasswordManager::passwordReset($email,$password);
            if($reset) {
                $_SESSION['success'] = 'Password resetted successfully';
                error_log("\r\n[".gmdate("Y-m-d\ H:i:s\Z")."] Password resetted successfully on http://".$_SERVER['HTTP_HOST']."/auditMedia/model/password_reset_model.php  Line No: 29 ",3,"../logs/my-errors.log");
                unset($_SESSION['email']);
                header('Location:../login.php');
            }
            else {
				
			}
        }
        catch(Exception $ex) {
            echo 'Occured Exception -', $ex->getMessage(), "\n";
            error_log("\r\n[".gmdate("Y-m-d\ H:i:s\Z")."] ".htmlentities($ex->getMessage())." on http://".$_SERVER['HTTP_HOST']."/auditMedia/model/password_reset_model.php  Line No: 11 ",3,"../logs/my-errors.log");
        }
    }
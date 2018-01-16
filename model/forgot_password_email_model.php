<?php
	/**
	 * @author - sathish
	 * @description - Forgot password
	 *
	 */
    require "../App.php";
    if (isset($_POST['submit'])) {
        try {
            $email=htmlentities($_POST['email']);
            
            //validation
            if($email =="") {
                $_SESSION['error']="Email cannot be empty";
                header('Location:../forgot_password.php');return;
            }
            
            $rs=array();
            $conn = App::getConnection();
            $sel = oci_parse($conn, "SELECT * FROM USERS WHERE EMAIL =: email");
            oci_bind_by_name($sel,':email',$email);
            oci_execute($sel);
			$row = oci_fetch_assoc($sel);
			$count = oci_num_rows($sel);
			
			if($count == 1) {
				save_session($row);
                error_log("\r\n[".gmdate("Y-m-d\ H:i:s\Z")."] Forget Password triggered on http://".$_SERVER['HTTP_HOST']."/auditMedia/model/forgot_password_email_model.php  Line No: 22 ",3,"../logs/my-errors.log");
				header('Location:../password_reset.php');
                /*
                //Email link part
                $from = 'info@aam.com';
                $to = '';
                $subject = 'AAM Password Reset';
                $message = 'Hi! This is your Password Reset Link. \n Click on link to reset password <a href="localhost/AAM/password_reset.php">';
                $headers = 'From: ' . $from . '\r\n';
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                mail($to, $subject, $message, $headers);
                */
			} else if ($count > 1) {
				throw new Exception('Two or more users exists with same Email');
			} else {
				$_SESSION['error']="Invalid Email!";
                header('Location:../forgot_password.php');
			}

            App::closeConnection($conn, $sel);
        }
        catch(Exception $ex) {
            echo 'Occured Exception -', $ex->getMessage(), "\n";
        }
    }

	function save_session($row) {
		$_SESSION['email'] = $row['EMAIL'];
		
	}
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
                header('Location:forgot_password.php');return;
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
				//echo json_encode($row);
				header('Location:password_reset.php');
			} else if ($count > 1) {
				throw new Exception('Two or more users exixts with same Email');
			} else {
				$_SESSION['error']="Invalid Email!";
                header('Location:forgot_password.php');
			}

            App::closeConnection($conn, $sel);
        }
        catch(Exception $ex) {
            echo 'Occured Exception -', $ex->getMessage(), "\n";
        }
    }

	function save_session($row) {
		$_SESSION['email_id'] = $row['EMAIL'];
		
	}
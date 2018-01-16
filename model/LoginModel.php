<?php
	/**
	 * @author - Thilak ramu
	 * @description - Login code
	 *
	 */
    require "../App.php";
    ini_set('display_errors',0);
    $log_Msg_success = "\r\n[".gmdate("Y-m-d\ H:i:s\Z")."] Login Success on http://".$_SERVER['HTTP_HOST']."/auditMedia/model/LoginModel.php  Line No: 27 ";
    $log_Msg_Fail = "\r\n[".gmdate("Y-m-d\ H:i:s\Z")."] Login failed on http://".$_SERVER['HTTP_HOST']."/auditMedia/model/LoginModel.php  Line No: 27 ";
    
    if (isset($_POST['submit'])) {
        try {
            $username=htmlentities($_POST['username']);
            $password=htmlentities($_POST['password']);
            //validation
            if($username =="") {
                $_SESSION['error']="User Name cannot be empty";
                header('Location:../login.php');return;
            }
            if($password ==""){
                $_SESSION['error']="Password cannot be empty";
                header('Location:../login.php');return;
            }
            $rs=array();
            $conn = App::getConnection();
            $sel = oci_parse($conn, "SELECT * FROM USERS WHERE USERNAME=:username AND PASSWORD=:pass");
            oci_bind_by_name($sel,':pass',$password);
            oci_bind_by_name($sel,':username',$username);
            oci_execute($sel);	
			$row = oci_fetch_assoc($sel);
			$count = oci_num_rows($sel);
			
			if($count == 1) {
				save_session($row);
				//echo json_encode($row);
                error_log($log_Msg_success,3,"../logs/my-errors.log");
                //App::insertLoginLog($username);
				header('Location:../dashboard.php');
			} else if ($count > 1) {
				throw new Exception('Two or more users exixts with same username');
			} else {
                error_log($log_Msg_Fail,3,"../logs/my-errors.log");
				$_SESSION['error']="Invalid Username or Password!";
                header('Location:../login.php');
			}

            App::closeConnection($conn, $sel);
        }
        catch(Exception $ex) {
            echo 'Occured Exception -', $ex->getMessage(), "\n";
            error_log("\r\n[".gmdate("Y-m-d\TH:i:s\Z")."] ".htmlentities($ex->getMessage())." on http://".$_SERVER['HTTP_HOST']."/auditMedia/  Line No: 9 ",3,"../logs/my-errors.log");
        }
    }

	function save_session($row) {
		$_SESSION['user_id'] = $row['ID'];
		$_SESSION['username'] = $row['USERNAME'];
		$_SESSION['email'] = $row['EMAIL'];
		$_SESSION['mobile'] = $row['MOBILE'];
		$_SESSION['user_type'] = $row['USER_TYPE'];
		$_SESSION['user_role'] = App::getUserRole($row['USER_ROLE_ID']);		
	}
<?php
    //require "../App.php";
    class PasswordManager {
    static public function passwordReset($email, $password) {
        $conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USERS SET PASSWORD =: pass WHERE EMAIL =: email');
		oci_bind_by_name($stid, ':pass', $password);
		oci_bind_by_name($stid, ':email', $email);
		oci_execute($stid);
        error_log("\r\n[".gmdate("Y-m-d\ H:i:s\Z")."] Password updated successfully on http://".$_SERVER['HTTP_HOST']."/auditMedia/data/passwordManager.php  Line No: 9 ",3,"../logs/my-errors.log");
		App::closeConnection($conn, $stid);
        if($stid) {
		  return true;
        }
        else {
            return false;
        }
    }
}
?>
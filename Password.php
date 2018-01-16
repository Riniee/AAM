<?php
class Password {
    static public function passwordReset($email, $password) {
        $conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USERS SET PASSWORD =: pass WHERE EMAIL =: email');
		oci_bind_by_name($stid, ':pass', $password);
		oci_bind_by_name($stid, ':email', $email);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
    }
}
?>
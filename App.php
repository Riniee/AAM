<?php
	session_start();
	$otherTypes = [1145, 1146, 1200, 1205, 1210, 1201];
	$singleCellCirc = [1170,1185,1190];
	$threeCellCirc = [1180];
	$gridType = [1145, 1146];
	$checkBoxType = [1200, 1205, 1210, 1201];
	class App {

		/**
		 * Database Connection
		 *
		 * @return Connection
		 */
		static public function getConnection() {
			//$conn = oci_connect('system', 'Thilakramu1', 'sys5.elitedomain.com/aam');
			$conn = oci_connect('LC_MAGAZINES', 'Elitesoft1', '192.168.0.199/Demo2');
			if (!$conn) {
				$e = oci_error();
				trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                error_log("\r\n[".gmdate("Y-m-d\ H:i:s\Z")."] Oracle Connection error".htmlentities($e['message'])." on http://".$_SERVER['HTTP_HOST']."/auditMedia/app.php  Line No: 13 ",3,"../logs/my-errors.log");
			}

			return $conn;
		}
		/**
		 * Database connection close
		 * 
		 * @return null
		 */
		static public function closeConnection($conn, $stid) {
			oci_free_statement($stid);
			oci_close($conn);
		}
		
		static function getUsers() {
			$conn = self::getConnection();
			$stid = oci_parse($conn, 'SELECT * FROM USERS');
			oci_execute($stid);
			$rows = [];
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$rows[] = $row;
			}
			self::closeConnection($conn, $stid);
			
			return $rows;		
		}

		/**
		 * logActivity
		 *
		 * @param string $action
		 * @param string $text
		 *
		 * @return bool
		 */
		static public function logActivity(
			$action = 'action',
			$text = 'message'
		) {
			$conn = self::getConnection();
			if (isset($_SERVER['REMOTE_ADDR'])) {
				$ip_address = $_SERVER['REMOTE_ADDR'];
			} else if (isset($_SERVER['SERVER_ADDR'])) {
				$ip_address = $_SERVER['SERVER_ADDR'];
			} else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$ip_address = $_SERVER['HTTP_CLIENT_IP'];	
			}

			if (isset($_SERVER['HTTP_USER_AGENT'])) {
				$user_agent = $_SERVER['HTTP_USER_AGENT'];
			}

			$s = oci_parse($conn, "call log_activity(:action, :message, :ip_address, :user_agent)");
			oci_bind_by_name($s, ":action", $action);
			oci_bind_by_name($s, ":message", $text);
			oci_bind_by_name($s, ":ip_address", $ip_address);
			oci_bind_by_name($s, ":user_agent", $user_agent);

			oci_execute($s);

			return true;
		}
		
		static function getUserRoles() {
			$conn = self::getConnection();
			$stid = oci_parse($conn, 'SELECT * FROM USER_ROLES');
			oci_execute($stid);
			$rows = [];
			while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
				$rows[] = $row;
			}
			self::closeConnection($conn, $stid);
			
			return $rows;			
		}
		
		static function getUserRole($roleId) {
			$conn = self::getConnection();
			$stid = oci_parse($conn, 'SELECT * FROM USER_ROLES WHERE ID = :id');
			oci_bind_by_name($stid, ':id', $roleId);
			oci_execute($stid);
			$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
			
			$role = $row['ROLE_NAME'];
				
			self::closeConnection($conn, $stid);
			
			return $role;			
		}
        
}

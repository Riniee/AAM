<?php

/*
 * @author - thilak ramu
 *
 * @description this file serves data for the pdf 
 */

//require '../App.php';

class PdfManager {
	static public function closeConnection($stid, $curs) {
		oci_free_statement($stid);
		oci_free_statement($curs);
	}
	
	/*
	 * Returns the certify
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */	
    static public function p_get_certify($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_CERTIFY(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the document layout
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */
	static public function p_get_document_layout($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_DOCUMENT_LAYOUT(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		$row['LAYOUT_OPTIONS'] = $row['LAYOUT_OPTIONS']->load();
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the periodical image
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @return row
	 *
	 */
	static public function p_get_edp_periodical_image($member = 400010, $ddate = '31-DEC-2016') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_EDP_PERIODICAL_IMAGE(:member_num, :drive_date, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return rows
	 *
	 */	
	static public function p_get_executive_summary($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_EXECUTIVESUMMARY(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$rows = [];
		while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$rows[] = $row;
		}
		
		self::closeConnection($stid, $curs);

		return $rows;
    }
	
	/*
	 * Returns the header
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */	
	static public function p_get_header($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_HEADER(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the layout details
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */
	static public function p_get_layout_details($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_LAYOUT_DETAILS(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the member attributes
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */
	static public function p_get_member_attributes($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_MEMBER_ATTRIBUTES(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the prices summary
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */
	static public function p_get_price_summary_layout($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_PRICE_SUMMARY_LAYOUT(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$rows = [];
		while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$rows[] = $row;
		}
		
		self::closeConnection($stid, $curs);

		return $rows;
    }
	
	/*
	 * Returns the prior date
	 * @param $ddate (string) Drive Date
	 * @return row
	 *
	 */
	static public function p_get_prior_date($ddate = '31-DEC-2016') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_PRIOR_DATE(:drive_date, :cursbv); end;");
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the Rate Base
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */
	static public function p_get_rate_base($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_RATEBASE(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the rate base changes
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @return row
	 *
	 */
	static public function p_get_ratebase_changes($member = 403133, $ddate = '31-DEC-2016') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_RATEBASE_CHANGES(:member_num, :drive_date, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$rows = [];
		while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$rows[] = $row;
		}
		
		self::closeConnection($stid, $curs);

		return $rows;
    }
	
	/*
	 * Returns the religious magazine
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */
	static public function p_get_religious_mag($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_RELIGIOUS_MAG(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the total circulation by issue
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return rows
	 *
	 */
	static public function p_get_total_circulation_issue($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_TOTAL_CRCLATON_ISSUE(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$rows = [];
		while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$rows[] = $row;
		}
		
		self::closeConnection($stid, $curs);

		return $rows;
    }
	
	/*
	 * Returns the variance
	 * @param $member (number) Member Number
	 * @return rows
	 *
	 */
	static public function p_get_variance($member = 400010) {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_NEW_GET_VARIANCE(:member_num, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$rows = [];
		while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$rows[] = $row;
		}
		
		self::closeConnection($stid, $curs);

		return $rows;
    }
	
	/*
	 * Returns the Additional Analysis Verified
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return rows
	 *
	 */
	static public function p_get_additional_analysis($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_ADDITIONAL_ANAL_VERIFIED(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$rows = [];
		while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
			$rows[] = $row;
		}
		
		self::closeConnection($stid, $curs);

		return $rows;
    }
	
	/*
	 * Returns the Supplymentory Analysis
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return row
	 *
	 */	
	static public function p_get_supply_analysis($member = 400010, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_SPPLMNT_ANALYS_AVG_CRCLT(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		self::closeConnection($stid, $curs);

		return $row;
    }
	
	/*
	 * Returns the P_GET_NOTES_EXPLANATORY_DET
	 * @param $member (number) Member Number
	 * @param $ddate (string) Drive Date
	 * @param $ptype (string) Product Type
	 * @return $rows Array
	 *
	 */
	static public function p_get_notes($member = 400012, $ddate = '31-DEC-2016', $ptype = 'PS') {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_NOTES_EXPLANATORY_DET(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$rows = [];
		while (($row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {			
			$rows[] = $row;
		}
		
		self::closeConnection($stid, $curs);

		return $rows;
    }
}

//$r = PdfManager::p_get_notes();

//echo print_r($r);
//echo json_encode($r);

<?php

/*
 * @author - thilak ramu
 *
 * @description this file serves data for the cards 
 */

//require '../App.php';

class CardManager {
	
	static public function cardList($asignee = 'Reviewer') {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'SELECT * FROM CARDS WHERE ASIGNEE =: asignee and STATUS = 0 and CLAIMED = 0');
		oci_bind_by_name($stid, ':asignee', $asignee);
		oci_execute($stid);
		$rows = [];
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$rows[] = $row;
		}
		App::closeConnection($conn, $stid);

		return $rows;	
	}
	
	static public function userCardList($id) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE USER_ID =: id AND STATUS = 0 AND ((REVIEWER_ACCESS = 1) OR (PROOF_READER_ACCESS = 1) OR (PROOF_ADMIN_ACCESS = 1))');
		oci_bind_by_name($stid, ':id', $id);
		oci_execute($stid);
		$rows = []; 
		$cards = [];
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$rows[] = $row;
		}
		foreach ($rows as $row) {
			$cards[] = self::card($row['CARD_ID']);		
		}
		App::closeConnection($conn, $stid);

		return $cards;	
	}
    static public function anotherUserCardList($id) { //sathsih
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE USER_ID =: id AND STATUS = 0  AND CARDLOCK = 0 AND ((REVIEWER_ACCESS = 1) OR (PROOF_READER_ACCESS = 1) OR (PROOF_ADMIN_ACCESS = 1))');
		oci_bind_by_name($stid, ':id', $id);
		oci_execute($stid);
		$rows = []; 
		$cards = [];
		while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
			$rows[] = $row;
		}
		foreach ($rows as $row) {
			$cards[] = self::card($row['CARD_ID']);		
		}
		App::closeConnection($conn, $stid);

		return $cards;	
	}
	
	static public function insertUserCard($cardId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'INSERT INTO USER_CARDS (USER_ID, CARD_ID) VALUES (:userId, :cardId)');
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_execute($stid);		
		App::closeConnection($conn, $stid);

		return true;	
	}
	
	static public function userClaimCard($cardId, $revierAceess = 0, $prfRdrAccess = 0, $prfAdminAccess = 0) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET REVIEWER_ACCESS = :revierAceess, PROOF_READER_ACCESS = :prfRdrAccess, PROOF_ADMIN_ACCESS= :prfAdminAccess WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':revierAceess', $revierAceess);
		oci_bind_by_name($stid, ':prfRdrAccess', $prfRdrAccess);
		oci_bind_by_name($stid, ':prfAdminAccess', $prfAdminAccess);
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);		
		
		$stid1 = oci_parse($conn, 'UPDATE CARDS SET CLAIMED = 1 WHERE ID = :cardId');
		oci_bind_by_name($stid1, ':cardId', $cardId);
		oci_execute($stid1);
		
		App::closeConnection($conn, $stid);

		return true;
	}
	
	static public function card($cardId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'SELECT * FROM CARDS WHERE ID =: id');
		oci_bind_by_name($stid, ':id', $cardId);
		oci_execute($stid);		
		$row = oci_fetch_assoc($stid);
		
		App::closeConnection($conn, $stid);

		return $row;		
	}
	
	static public function userHasCardOpened($cardId) {
		$conn = App::getConnection();
		//$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE CARD_ID =: cardId AND USER_ID = :userId');
		$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE CARD_ID =: cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);		
		$row = oci_fetch_assoc($stid);
		
		App::closeConnection($conn, $stid);
		if ($row) {
			return $row;
		}

		return false;		
	}
	
	static public function fwdToReviewer($cardId) {
		$value = 'Reviewer';
		$conn = App::getConnection();		
		$stid = oci_parse($conn, 'UPDATE CARDS SET ASIGNEE = :value, CLAIMED = 0 WHERE ID = :cardId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':value', $value);
		oci_execute($stid);
		
		App::closeConnection($conn, $stid);
		
		self::updateUserCardStatus($cardId, 0, 0, 0);

		return true;
	}
	
	static public function fwdToProofReader($cardId) {
		$value = 'Proof Reader';
		$conn = App::getConnection();		
		$stid = oci_parse($conn, 'UPDATE CARDS SET ASIGNEE = :value, CLAIMED = 0 WHERE ID = :cardId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':value', $value);
		oci_execute($stid);
		
		App::closeConnection($conn, $stid);
		
		self::updateUserCardStatus($cardId, 0, 0, 0);

		return true;
	}
	
	static public function fwdToProofAdmin($cardId) {
		$value = 'Proof Admin';
		$conn = App::getConnection();		
		$stid = oci_parse($conn, 'UPDATE CARDS SET ASIGNEE = :value, CLAIMED = 0 WHERE ID = :cardId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':value', $value);
		oci_execute($stid);
		
		App::closeConnection($conn, $stid);
		
		self::updateUserCardStatus($cardId, 0, 0, 0);

		return true;
	}
	
	static public function hasUserClaimedReviewerCard($cardId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE CARD_ID =: cardId AND USER_ID = :userId AND REVIEWER_ACCESS = 1');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);		
		$row = oci_fetch_assoc($stid);
		
		App::closeConnection($conn, $stid);
		if ($row) {
			return $row;
		}

		return false;		
	}
	
	static public function hasUserClaimedPRCard($cardId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE CARD_ID =: cardId AND USER_ID = :userId AND PROOF_READER_ACCESS = 1');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);		
		$row = oci_fetch_assoc($stid);
		
		App::closeConnection($conn, $stid);
		if ($row) {
			return $row;
		}

		return false;		
	}
	
	static public function hasUserClaimedPACard($cardId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE CARD_ID =: cardId AND USER_ID = :userId AND PROOF_ADMIN_ACCESS = 1');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);		
		$row = oci_fetch_assoc($stid);
		
		App::closeConnection($conn, $stid);
		if ($row) {
			return $row;
		}

		return false;		
	}
	
	static public function claimReviewerCard($cardId) {
		$conn = App::getConnection();		
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET REVIEWER_ACCESS = 1 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
				
		App::closeConnection($conn, $stid);
		self::claimCard($cardId);

		return true;
	}
	
	static public function claimProofReaderCard($cardId) {
		$conn = App::getConnection();		
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET PROOF_READER_ACCESS = 1 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
		
		App::closeConnection($conn, $stid);
		self::claimCard($cardId);

		return true;
	}
	
	static public function claimProofAdminCard($cardId) {
		$conn = App::getConnection();		
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET PROOF_ADMIN_ACCESS = 1 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
		
		App::closeConnection($conn, $stid);
		self::claimCard($cardId);

		return true;
	}
	
	static public function claimCard($cardId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE CARDS SET CLAIMED = 1 WHERE ID = :cardId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
	}
	
	static public function updateUserCardStatus($cardId, $reviewer_access = 0, $pr_access = 0, $pa_access = 0) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET REVIEWER_ACCESS = :reviewer_access, PROOF_READER_ACCESS = :pr_access, PROOF_ADMIN_ACCESS = :pa_access  WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_bind_by_name($stid, ':reviewer_access', $reviewer_access);
		oci_bind_by_name($stid, ':pr_access', $pr_access);
		oci_bind_by_name($stid, ':pa_access', $pa_access);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
	}	
	
	static public function finishCard($cardId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET STATUS = 1 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
		App::closeConnection($conn, $stid);
		
		$conn = App::getConnection();
		$stid1 = oci_parse($conn, 'UPDATE CARDS SET STATUS = 1 WHERE ID = :cardId');
		oci_bind_by_name($stid1, ':cardId', $cardId);
		oci_execute($stid1);		
		App::closeConnection($conn, $stid1);

		return true;
	}
	
	static public function updateOtherUserCard($cardId, $userId) {
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET STATUS = 1 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $userId);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
	}
	
	static public function userForwardCard($cardId, $otherUserId) {
		$revierAceess = 0;
		$prfRdrAccess = 0;
		$prfAdminAccess = 0;
		$conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET STATUS = 1 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
		App::closeConnection($conn, $stid);
		
		$card = self::card($cardId);
		
		if ($card['ASIGNEE'] == 'Reviewer') {
			$revierAceess = 1;
		} else if ($card['ASIGNEE'] == 'Proof Reader') {
			$prfRdrAccess = 1;
		} else if ($card['ASIGNEE'] == 'Proof Admin') {
			$prfAdminAccess = 1;
		} else {}
		
		self::insertUserForwardCard($cardId, $otherUserId, $revierAceess, $prfRdrAccess, $prfAdminAccess);
		return true;
	}
    
    static public function returnCardToPrevious($cardId) {
        $revierAceess = 0;
		$prfRdrAccess = 0;
		$prfAdminAccess = 0;
		$conn = App::getConnection();        
		$stid = oci_parse($conn, 'UPDATE CARDS SET CLAIMED = 0 WHERE ID = :cardId');
		oci_bind_by_name($stid, ':cardId', $cardId);		
		oci_execute($stid);
        App::closeConnection($conn, $stid);
        $conn = App::getConnection();
        $stid = oci_parse($conn, 'UPDATE USER_CARDS SET REVIEWER_ACCESS = :reviewer_access, PROOF_READER_ACCESS = :pr_access, PROOF_ADMIN_ACCESS = :pa_access  WHERE CARD_ID = :cardId AND USER_ID = :userId');
        oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
        oci_bind_by_name($stid, ':reviewer_access', $revierAceess);
		oci_bind_by_name($stid, ':pr_access', $prfRdrAccess);
		oci_bind_by_name($stid, ':pa_access', $prfAdminAccess);
		oci_execute($stid);
        App::closeConnection($conn, $stid);
	}
	
	static public function insertUserForwardCard($cardId, $userId, $revierAceess = 0, $prfRdrAccess = 0, $prfAdminAccess = 0) {
		$conn = App::getConnection();		
		$stid = oci_parse($conn, 'SELECT * FROM USER_CARDS WHERE CARD_ID =: cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $userId);
		oci_execute($stid);		
		$row = oci_fetch_assoc($stid);		
		App::closeConnection($conn, $stid);
		
		if ($row) {
			$conn = App::getConnection();			
			$stid = oci_parse($conn, 'UPDATE USER_CARDS SET REVIEWER_ACCESS = :reviewer_access, PROOF_READER_ACCESS = :pr_access, PROOF_ADMIN_ACCESS = :pa_access  WHERE CARD_ID = :cardId AND USER_ID = :userId');
			
		} else {
			$conn = App::getConnection();
			$stid = oci_parse($conn, 'INSERT INTO USER_CARDS (USER_ID, CARD_ID, REVIEWER_ACCESS, PROOF_READER_ACCESS, PROOF_ADMIN_ACCESS) VALUES (:userId, :cardId, :reviewer_access, :pr_access, :pa_access)');				
		}
		
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $userId);
		oci_bind_by_name($stid, ':reviewer_access', $revierAceess);
		oci_bind_by_name($stid, ':pr_access', $prfRdrAccess);
		oci_bind_by_name($stid, ':pa_access', $prfAdminAccess);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
	}
    static public function lockCard($cardId) {
        $conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET CARDLOCK = 1 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
    }
    static public function unlockCard($cardId) {
        $conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USER_CARDS SET CARDLOCK = 0 WHERE CARD_ID = :cardId AND USER_ID = :userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
		oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
    }
	static public function checkLocked($cardId) {
        $conn = App::getConnection();
        $stid = oci_parse($conn, 'SELECT CARD_ID FROM USER_CARDS WHERE CARDLOCK = 1 AND CARD_ID =:cardId AND USER_ID =:userId');
		oci_bind_by_name($stid, ':cardId', $cardId);
        oci_bind_by_name($stid, ':userId', $_SESSION['user_id']);
		oci_execute($stid);
        $row = oci_fetch_assoc($stid);		
        if($row) {
            return true;
        }
        App::closeConnection($conn, $stid);
        return false;
    }
    static public function passwordReset($email, $password) {
        $conn = App::getConnection();
		$stid = oci_parse($conn, 'UPDATE USERS SET PASSWORD =: pass WHERE EMAIL =: email');
		oci_bind_by_name($stid, ':pass', $password);
		oci_bind_by_name($stid, ':email', $email);
		oci_execute($stid);
		App::closeConnection($conn, $stid);

		return true;
    }
    static public function p_get_process_attributes($member, $ddate, $ptype) {
		$conn = App::getConnection();
		$curs = oci_new_cursor($conn);
		$stid = oci_parse($conn, "begin P_GET_PROCESS_ATTRIBUTES(:member_num, :drive_date, :product_type, :cursbv); end;");
		oci_bind_by_name($stid, ":member_num", $member);
		oci_bind_by_name($stid, ":drive_date", $ddate);
		oci_bind_by_name($stid, ":product_type", $ptype);
		oci_bind_by_name($stid, ":cursbv", $curs, -1, OCI_B_CURSOR);
		oci_execute($stid);
		oci_execute($curs);  // Execute the REF CURSOR like a normal statement id
		$row = oci_fetch_array($curs, OCI_ASSOC+OCI_RETURN_NULLS);
		
		oci_free_statement($stid);
		oci_free_statement($curs);

		return $row;
    }
}

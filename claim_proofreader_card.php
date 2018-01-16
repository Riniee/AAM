<?php
	require 'App.php';	
	require 'data/CardManager.php';
	
	if (isset($_GET['card_id']) && isset($_SESSION['user_id'])) {
		
		$claim = CardManager::claimProofReaderCard($_GET['card_id']);
		if (isset($_GET['otherUserId'])) {
			$update = CardManager::updateOtherUserCard($_GET['card_id'], $_GET['otherUserId']);
			if ($claim && $update) {
				$_SESSION['success'] = 'Other user card claimed successfully';
				echo json_encode([
					'success' => 'Other user card claimed successfully'
				]);
			}
		} else if ($claim) { 
			$_SESSION['success'] = 'Proof Reader card claimed successfully';
			echo json_encode([
				'success' => 'User claimed card successfully'
			]);
		} else {
			echo json_encode([
				'error' => 'user unable to claimed card'
			]);
		}
	} else {
		echo json_encode([
			'error' => 'Required card Id to process'
		]);
	}
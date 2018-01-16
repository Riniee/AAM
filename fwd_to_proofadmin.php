<?php
	require 'App.php';
	require 'data/CardManager.php';
	
	if (isset($_POST['card_id']) && isset($_SESSION['user_id'])) {
		
		$claim = CardManager::fwdToProofAdmin($_POST['card_id']);
		
		if ($claim) { 
			$_SESSION['success'] = 'Card forwarded to Proof Admin successfully';
			echo json_encode([
				'success' => 'Card forwarded to Proof Admin successfully'
			]);
		} else {
			echo json_encode([
				'error' => 'Failed to forward'
			]);
		}
	} else {
		echo json_encode([
			'error' => 'Invalid request'
		]);
	}
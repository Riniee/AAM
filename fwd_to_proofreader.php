<?php
	require 'App.php';
	require 'data/CardManager.php';
	
	if (isset($_POST['card_id']) && isset($_SESSION['user_id'])) {
		
		$claim = CardManager::fwdToProofReader($_POST['card_id']);
		
		if ($claim) { 
			$_SESSION['success'] = 'Card forwarded to Proof Reader successfully';
			echo json_encode([
				'success' => 'Card forwarded to Proof Reader successfully'
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
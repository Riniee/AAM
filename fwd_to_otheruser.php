<?php
	require 'App.php';
	require 'data/CardManager.php';
	
	if (isset($_POST['card_id']) && isset($_POST['user_id'])) {
		
		$claim = CardManager::userForwardCard($_POST['card_id'], $_POST['user_id']);
		
		if ($claim) { 
			$_SESSION['success'] = 'Card forwarded to Other user successfully';
			echo json_encode([
				'success' => 'Card forwarded to  Other user successfully'
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
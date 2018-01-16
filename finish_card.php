<?php
	require 'App.php';
	require 'data/CardManager.php';
	
	if (isset($_POST['card_id']) && isset($_SESSION['user_id'])) {
		
		$claim = CardManager::finishCard($_POST['card_id']);
		
		if ($claim) { 
			$_SESSION['success'] = 'Card is Approved and Finished';
			echo json_encode([
				'success' => 'Card is Approved and Finished'
			]);
		} else {
			echo json_encode([
				'error' => 'Failed to generate pdf'
			]);
		}
	} else {
		echo json_encode([
			'error' => 'Invalid request'
		]);
	}
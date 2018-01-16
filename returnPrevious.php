<?php
	require 'App.php';
	require 'data/CardManager.php';
	
	if (isset($_POST['card_id'])) {
		
        $retprev = CardManager::returnCardToPrevious($_POST['card_id']);
		
		
		if ($retprev) { 
			$_SESSION['success'] = 'Card Returned Back to Previous Assignee successfully';
			echo json_encode([
				'success' => 'Card Returned Back to Previous Assignee successfully'
			]);
		} else {
			echo json_encode([
				'error' => 'Failed to Return Back'
			]);
		}
	} else {
		echo json_encode([
			'error' => 'Invalid Operation'
		]);
	}
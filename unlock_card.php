<?php  
    require 'App.php';
    require 'data/CardManager.php';
    
    if (isset($_GET['card_id']) && isset($_SESSION['user_id'])) {
       $unlock = CardManager::unlockCard($_GET['card_id']);
        if( $unlock ) {
        $_SESSION['success'] ='Card ' . $_GET['card_id'] . ' unlocked successfully';
				echo json_encode([
					'success' => 'Card Unlocked successfully'
                ]);
        }
        else {
            
        }
    }
    else {
		echo json_encode([
			'error' => 'Required card Id to process'
		]);
	}

?>
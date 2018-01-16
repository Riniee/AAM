<?php  
    require 'App.php';
    require 'data/CardManager.php';
    
    if (isset($_GET['card_id']) && isset($_SESSION['user_id'])) {
       $lock = CardManager::lockCard($_GET['card_id']);
        if( $lock ) {
        $_SESSION['success'] ='Card ' . $_GET['card_id'] .' locked successfully';
				echo json_encode([
					'success' => 'Card locked successfully'
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
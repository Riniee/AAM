<?php if(isset($_SESSION['error'])) { ?>
	<div class="alert alert-danger alert-dismissible">
		<?php 
			echo $_SESSION['error'];
			unset($_SESSION['error']);
		?>
	</div>
	<?php } ?>
	<?php if(isset($_SESSION['success'])) { ?>
	<div class="alert alert-success alert-dismissible">
		<?php 
			echo $_SESSION['success'];
			unset($_SESSION['success']);
		?>
	</div>
<?php } ?>


<div class="alert alert-danger alert-dismissible" id="validate_alert" style="display:none;">
	<p id="validate_error"></p>
</div>

<?php 
	require 'App.php';	
	if(!isset($_SESSION['username'])) {
		header('Location:login.php');
	}
	$card = [];
	require 'data/CardManager.php';	
	
	$rc = CardManager::cardList('Reviewer');	
	$pr = CardManager::cardList('Proof Reader');	
	$pd = CardManager::cardList('Proof Admin');
    $instruction = CardManager::p_get_process_attributes(400010,'31-DEC-2016','PS');
	$loggedUserCards = CardManager::userCardList($_SESSION['user_id']);

	$pdCount = count($pd);
	$reviewerCount = count($rc);
	$prCount = count($pr);
	$cntloggedUserCards = count($loggedUserCards);

	if(isset($_GET['cardId'])) {
		$card = CardManager::card($_GET['cardId']);
	}
    require 'data/pdfdata.php';	
	require 'common/commonData.php';
	
	if (isset($_GET['cardId']) && isset($_GET['otherUserId'])) {
		$user_cards_page = $_GET['otherUserId'];		
	} else if (CardManager::hasUserClaimedReviewerCard($_GET['cardId']) || CardManager::hasUserClaimedPRCard($_GET['cardId']) || CardManager::hasUserClaimedPACard($_GET['cardId'])) {
		$current_user_page = true;
	} else {
		if ($card['ASIGNEE'] == 'Reviewer') {
			$reviewer_page = true;		
		} else if ($card['ASIGNEE'] == 'Proof Reader') {
			$proof_reader_page = true;		
		} else if ($card['ASIGNEE'] == 'Proof Admin') {
			$proof_admin_page = true;
		} else {
		}
	}
	
	$hasOpened = CardManager::userHasCardOpened($_GET['cardId']);
	if (!$hasOpened) {
		CardManager::insertUserCard($_GET['cardId']);
	}
	$cardAssignee = $card['ASIGNEE'];
	require 'layout.php';
	require 'head.php';
	require 'common/user_header.php';
?>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include 'common/user_header_menu.php'; ?>
		<div class="content-wrapper">
			<!-- Main content -->
			<section class="content">
				<div class="wrapper-outer">
					<h3>Review</h3>
					<div class="wrapper-inner">
						<div class="row">
							<div class="col-md-12">
								<div class="nav-tabs-custom" id="myTabs">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#taskDetails" data-toggle="tab" onclick="showTaskDetailsButton();">task details</a></li>
										<li id="form-tab" onclick="showFormTab();"><a href="#form" data-toggle="tab">form</a></li>
										<li id="history-tab" onclick="manageButtons();"><a href="#history" data-toggle="tab">history</a></li>
										<li id="attachments-tab" onclick="manageButtons();"><a href="#attachments" data-toggle="tab">attachments<span>(0)</span></a></li>
										<li id="user-selection-tab" style="display:none;" onclick="manageButtons();"><a href="#forward" data-toggle="tab">User Selection</a></li>
									</ul>
									<div class="tab-content">
										<div class="active tab-pane" id="taskDetails">
											<div class="task-details-wrapper">
												<div class="inner">
													<div class="task-content">
														<h3 class="text-capitalize">review</h3>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>instructions</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<address>
<!--                                                        <h4 class="text-uppercase">proof to member</h4>-->
                                                        <p><span>drive:<em><?php echo $instruction['DRIVE_DATE'] ?></em></span> <span>format:<em><?php echo $instruction['PS_FORMAT'] ?></em></span></p>
                                                        <p><span>member:<em><?php echo $instruction['MEMBER_NUMBER'] ?></em></span> <span>receipt:<em><?php echo $instruction['RECEIPT_SEQUENCE'] ?></em></span></p>
                                                        <p><span>doc:<em><?php echo $instruction['STATEMENT_STATUS'] ?></em></span> <span>rev:<em>none</em></span> <span>mem<em><?php echo $instruction['MEMBERSHIP_STATUS'] ?></em></span></p>
                                                        <p><span>city/st:<em><?php echo $instruction['PUBLICATION_CITY'] .','. $instruction['PUBLICATION_STATE']?></em></span></p>
                                                        <p><span>publisher:<em><?php echo $instruction['PUBLISHER_NAME'] ?></em></span></p>
                                                        <p><span>name:<em><?php echo $instruction['PUBLICATION_NAME_1'] ?></em></span></p>
                                                        <p class="process-id"><span>process id:<em>5485454</em></span></p>
                                                    </address>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>descriptions</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p></p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>deadline date</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p></p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>creation date</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>NOV 22,2016 - 12:25:56</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>update date</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>JAN 22,2016 - 12:25:56</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>take id</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>415445</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>status</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>assigned</p>
																</div>
															</div>
														</div>
													</div>
													<div class="clearfix"></div>
													<div class="task-content">
														<h3 class="text-capitalize">process details</h3>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>descriptions</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>changed the watched folder to frist magazine app folder</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>deadline date</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p></p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>creation date</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>NOV 22,2016 - 12:25:56</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>update date</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>JAN 22,2016 - 12:25:56</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>process name</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>magazine workflow / published statement</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>process id</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>452855</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>process status</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>running</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="sub-heading">
																<h3 class="col-md-4">process variables</h3>
															</div>
															<div class="col-md-4">
																<div class="left-sider">
																	<span>drive date</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>JAN 22,2016 - 12:25:56</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>group name</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>reviewers</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>member number</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>655476</p>
																</div>
															</div>
														</div>
														<div class="block">
															<div class="col-md-4">
																<div class="left-sider">
																	<span>product type</span>
																</div>
															</div>
															<div class="col-md-8">
																<div class="right-sider">
																	<p>PS</p>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
										<div class="clearfix"></div>
										<div class="tab-pane" id="form">
											<?php 
												//include 'Magazine Format Type/1_MAG_print_only.php'; 
												//include 'Magazine Format Type/2_MAG_print_digital.php'; 
                                                require($htmlUrl);
											?>
										</div>
										<div class="tab-pane" id="history"> History</div>
										<div class="tab-pane" id="attachments"> No Attachments</div>
										<div class="tab-pane" id="forward">
											<div style="min-height:300px;">
												User Selection
												<div class="form-group">
													<select id="forward-user" onchange="enable_fwd_btn();">
														<option value="">Select User</option>
													<?php 
														$users = App::getUsers();
														foreach ($users as $user) { 
															if ($user['ID'] == $_SESSION['user_id']) {
																continue;
															}
														?>															
														<option value="<?php echo $user['ID']; ?>"><?php echo ucwords($user['USERNAME']) ?></option>
													<?php															
														}
													?>
													</select>
												</div>
												<div class="form-group">
													<button id="forward-user-btn" onclick="sendToOtherUser(<?php echo $card['ID'] ?>)" class="btn btn-sm btn-primary" disabled>Ok</button>
													<button id="forward-cancel-btn" onclick="clearData();" class="btn btn-sm btn-default" disabled>Cancel</button>
												</div>

											</div>

										</div>
									</div>
									<!-- /.tab-content -->
								</div>
								<!-- /.nav-tabs-custom -->
							</div>
							<!-- /.col -->
							<div class="todo-fot-wrapper">
								<ul>
									<?php 
										if ($cardAssignee == 'Reviewer') {
											$access = CardManager::hasUserClaimedReviewerCard($_GET['cardId']);
											$url = 'claim_reviewer_card.php?card_id=' . $_GET['cardId'];
											require 'common_buttons.php';
										} else if ($cardAssignee == 'Proof Reader') {												$access = CardManager::hasUserClaimedPRCard($_GET['cardId']);
											$url = 'claim_proofreader_card.php?card_id=' . $_GET['cardId'];
											require 'common_buttons.php';
										} else if ($cardAssignee == 'Proof Admin') {
											$access = CardManager::hasUserClaimedPACard($_GET['cardId']);
											$url = 'claim_proofadmin_card.php?card_id=' . $_GET['cardId'];
											require 'common_buttons.php';
										} else {}
									?>

								</ul>
							</div>
						</div>
						<!-- /.row -->

					</div>

				</div>
			</section>
			<!-- /.content -->
		</div>
	</div>
	<script src="libraries/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="libraries/bootstrap.min.js"></script>
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/custom.js"></script>
</body>

</html>
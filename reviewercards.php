<?php 
	require 'App.php';	
	require 'data/CardManager.php';	
	if(!isset($_SESSION['username'])) {
		header('Location:login.php');
	}
	$reviewer_page = true;
	$rc = CardManager::cardList('Reviewer');	
	$pr = CardManager::cardList('Proof Reader');	
	$pd = CardManager::cardList('Proof Admin');
    $instruction = CardManager::p_get_process_attributes(400010,'31-DEC-2016','PS');
	$loggedUserCards = CardManager::userCardList($_SESSION['user_id']);

	$pdCount = count($pd);
	$reviewerCount = count($rc);
	$prCount = count($pr);
	$cntloggedUserCards = count($loggedUserCards);
	require 'common/user_header.php';
?>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include 'common/user_header_menu.php'; ?>
		<div class="content-wrapper">
			<section class="content">
				<div class="wrapper-outer">
					<h3>consult-1</h3>
					<div class="wrapper-inner">				
						<div class="row">
							<div class="col-md-12">
								<div class="box box-info">
									<div class="box-body">
										<div class="table-responsive">
											<table id="grid-command-buttons" class="table no-margin dashboard">
												<thead>
													<tr>
														<th data-column-id="id"></th>
														<th data-column-id="id1">process name</th>
														<th data-column-id="id2">task name</th>
														<th data-formatter="instructions" data-column-id="id3">instructions</th>
														<th data-column-id="id4">priority</th>
														<th data-column-id="id5">deadline date</th>
														<th data-column-id="id6">task id</th>
														<th data-formatter="commands" data-sortable="false" data-column-id="id7">#</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($rc as $c) { ?>
													<tr onclick="gotoCardDetails(<?php echo $c['ID'] ?>);" style="cursor:pointer;">
														<td>
															<?php echo $c['ID'] ?>
														</td>
														<!--
												<td>
                                                    <ul class="icon">
                                                        <li><i class="fa fa-clipboard" style="color:#f5c018;"></i></li><li><i class="fa fa-lock" style="color:#b67815;"></i></li>
                                                    </ul>
                                                </td>-->
														<td><a>magazines_workflow/published statement</a></td>
														<td>
															<?php echo $c['ASIGNEE'] ?>
														</td>
														<td>
															<?php 

                                                            echo $c['MEMBER_NUMBER']  .'_' . $instruction['DRIVE_DATE'] . '_' . $instruction['PS_FORMAT'] .'_'.$instruction['RECEIPT_SEQUENCE'] .'_'.$instruction['STATEMENT_STATUS'] .'_'. $instruction['MEMBERSHIP_STATUS'] .'_'.$instruction['PUBLICATION_CITY'] .'_'.$instruction['PUBLICATION_STATE'] .'_'.$instruction['PUBLISHER_NAME'] .'_'. $instruction['PUBLICATION_NAME_1'];

                                                                                                                    ?>
														</td>
														<td>normal</td>
														<td></td>
														<td>5546</td>
														<td></td>
													</tr>

													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<?php require 'common/user_footer.php'; ?>
</body>

</html>

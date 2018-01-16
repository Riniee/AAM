<?php 
	require 'App.php';	
	require 'data/CardManager.php';	
	if(!isset($_SESSION['username'])) {
		header('Location:login.php');
	}
	
	$rc = CardManager::cardList('Reviewer');	
	$pr = CardManager::cardList('Proof Reader');	
	$pd = CardManager::cardList('Proof Admin');
    $instruction = CardManager::p_get_process_attributes(400010,'31-DEC-2016','PS');
	$loggedUserCards = CardManager::userCardList($_SESSION['user_id']);
    $anotherUserCards = CardManager::anotherUserCardList($_GET['user_id']);//sathish
	$pdCount = count($pd);
	$reviewerCount = count($rc);
	$prCount = count($pr);
	$cntloggedUserCards = count($loggedUserCards);
	$cntanotherUserCards = count($anotherUserCards);//SATHISH
	require 'common/user_header.php';
	
	if (isset($_GET['user_id'])) {
		$userCards = CardManager::anotherUserCardList($_GET['user_id']);
		$user_cards_page = $_GET['user_id'];
	} else {
		header('Location:dashboard.php');
	}
?>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php include 'common/user_header_menu.php'; ?>
		<div class="content-wrapper">
			<section class="content">
				<div class="wrapper-outer">
					<h3><?php echo $_SESSION['username']; ?></h3>
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
													<?php foreach ($userCards as $c) { ?>
													<tr onclick="gotoCardDetails(<?php echo $c['ID'] ?>);" style="cursor:pointer;">
														<td>
															<?php echo $c['ID'] ?>
														</td>														
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
	<script src="libraries/jQuery/jQuery-2.1.4.min.js"></script>
	<script src="libraries/bootstrap.min.js"></script>
	<!-- App -->
	<script src="assets/js/app.min.js"></script>
	<script src="assets/js/jquery.bootgrid.js"></script>
	<script>
		var grid = $("#grid-command-buttons").bootgrid({
			formatters: {
				"commands": function(column, row) {
					return "<button  class=\"btn btn-primary command-view\" data-row-id=\"" + row.id + "\">View</button>";
				},
				"instructions": function(column, row) {
					//console.log(row.id3);
                    var instruct = row.id3;
                    var id3_splited = instruct.split("_");
//                    <h4 class='text-uppercase'>proof to member</h4>
					return "<address>" +
						"<p class='ins'><span>drive:<em>" + id3_splited['1'] + "</em></span> <span>format:<em>" + id3_splited['2'] + "</em></span></p>" +
						"<p class='ins'><span>member:<em>" + id3_splited['0'] + "</em></span> <span>receipt:<em>" + id3_splited['3'] + "</em></span></p>" +
						"<p class='ins'><span>doc:<em>" + id3_splited['4'] + "</em></span> <span>rev:<em>none</em></span> <span>mem<em>msm</em></span></p>" +
						"<p class='ins'><span>city/st:<em>" + id3_splited['6'] + ","+ id3_splited['7'] +"</em></span></p>" +
						"<p class='ins'><span>publisher:<em>" + id3_splited['8'] + "</em></span></p>" +
						"<p class='ins'><span>name:<em>" + id3_splited['9'] + "</em></span></p>" +
						//"<p class='ins process-id'><span>process id:<em>5485454</em></span></p>" +
						"</address>";
				}
			}
		}).on("loaded.rs.jquery.bootgrid", function() {
			/* Executes after data is loaded and rendered */
			grid.find(".command-edit").on("click", function(e) {
				alert("You pressed edit on row: " + $(this).data("row-id"));
			}).end().find(".command-delete").on("click", function(e) {
				alert("You pressed delete on row: " + $(this).data("row-id"));
			}).end().find(".command-view").on("click", function(e) {
				//alert("You pressed view on row: " + $(this).data("row-id"));
				window.location = 'carddetails.php?cardId=' + $(this).data("row-id") + '&otherUserId=<?php echo $_GET['user_id'] ?>';
			});
		});

	</script>
    
</body>

</html>

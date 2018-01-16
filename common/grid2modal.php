<!-- Presentation Mode (Modal popup) start -->
<div class="modal-wrapper">
	<!-- Modal -->
	<div class="modal fade" id="edit-grid2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="form-wrapper">
					<div class="form-header">
						<h3 class="text-uppercase">notes</h3>
					</div>
					<div class="form-content m-strong">
						<div class="form-group m-strong">
							<label class="col-form-label">title:</label>
							<input class="form-control" value="<?php echo $grid2Data['TITLE'] ?>" placeholder="14557 Mulit-Title Digital Programs %" type="text">
						</div>
						<div class="form-group">
							<label class="col-form-label">text before:</label>
							<input class="form-control fill-bule" value="<?php echo $grid2Data['TEXT_BEFORE'] ?>" placeholder="Text Before Content:" type="text">
						</div>
						<div class="form-group m-strong">
							<div class="col-md-12 pad-4">
								<div class="col-sm-3 pad-left nopadding">
									<div class="form-group">
										<label class="col-form-label">program name</label>
									</div>
								</div>
								<div class="col-sm-3 nopadding">
									<div class="form-group">
										<label class="col-form-label">report multi-title digital program</label>
									</div>
								</div>
								<div class="col-sm-2 nopadding">
									<div class="form-group">
										<label class="col-form-label">unique opens by reader</label>
									</div>
								</div>
								<div class="col-sm-2 nopadding">
									<div class="form-group">
										<label class="col-form-label">opens by issue</label>
									</div>
								</div>
								<div class="col-sm-2 pad-right nopadding">
									<div class="form-group">
										<label class="col-form-label">total opens by reader</label>
									</div>
								</div>
							</div>
							<!-- Fields is here -->
							<div id="grid2_fields"> </div>
							<?php 								
								if(isset($grid2Data['data']) && $grid2Data['data']) {
								$count = count($grid2Data['data']);
								$i = 0;
								foreach ($grid2Data['data'] as $key=>$row) { 
									if(++$i === $count) {
										$displayGrid2Plus = true;
									}
							?>
								<div class="form-group removeGrid2Data-<?php echo $key; ?>">
									<div class="col-sm-3 pad-left nopadding">
										<div class="form-group">
											<input class="form-control fill-bule" value="<?php echo $row['TEXT'] ?>" placeholder="Text-1" type="text">
										</div>
									</div>
									<div class="col-sm-3 nopadding">
										<div class="form-group">
											<input class="form-control fill-bule" value="<?php echo $row['MULTI_TITLE'] ?>" placeholder="22" type="text">
										</div>
									</div>
									<div class="col-sm-2 nopadding">
										<div class="form-group">
											<input class="form-control fill-bule" value="<?php echo $row['UNIQUE_OPENS'] ?>" placeholder="22" type="text">
										</div>
									</div>
									<div class="col-sm-2 nopadding">
										<div class="form-group">
											<input class="form-control fill-bule" value="<?php echo $row['OPENS_PER_ISSUE'] ?>" placeholder="22" type="text">
										</div>
									</div>
									<div class="col-sm-2 pad-right nopadding">
										<div class="form-group">
											<div class="input-group">
												<input class="form-control fill-bule" value="<?php echo $row['TOT_OPENS'] ?>" placeholder="22" type="text">
												<div class="btn-wrapper text-right">
													<?php if (isset($displayGrid2Plus)) { ?>
													<button class="btn btn-success btn-gray" type="button" onclick="add_new_grid2_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
													<?php } else { ?>
														<button class="btn btn-danger btn-gray" type="button" onclick="removeGrid2Data(<?php echo $key; ?>);"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button>
													<?php } ?>																				
												</div>
											</div>
										</div>
									</div>
									<div class="clear"></div>
								</div>
							<?php } } ?>
						</div>
						<div class="form-group">
							<label class="col-form-label">text after:</label>
							<input class="form-control fill-bule" value="<?php echo $grid2Data['TEXT_AFTER'] ?>" placeholder="text after contents" type="text"> </div>
					</div>
					<div class="form-footer">
						<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Presentation Mode (Modal popup) end -->
<script>
	var room = 1;

	function add_new_grid2_fields() {
		room++;
		var objTo = document.getElementById('grid2_fields')
		var divtest = document.createElement("div");
		divtest.setAttribute("class", "form-group removeclass" + room);
		var rdiv = 'removeclass' + room;
		divtest.innerHTML = '<div class="col-sm-3 pad-left nopadding"><div class="form-group"><input class="form-control fill-bule" value="" placeholder="Text-1" type="text"></div></div><div class="col-sm-3 nopadding"><div class="form-group"><input class="form-control fill-bule" value="" placeholder="22" type="text"></div></div><div class="col-sm-2 nopadding"><div class="form-group"><input class="form-control fill-bule" value="" placeholder="22" type="text"></div></div><div class="col-sm-2 nopadding"><div class="form-group"><input class="form-control fill-bule" value="" placeholder="22" type="text"></div></div><div class="col-sm-2 nopadding pad-right"><div class="form-group"><div class="input-group"><input class="form-control fill-bule" value="" placeholder="22" type="text"><div class="btn-wrapper text-right"><button class="btn btn-danger btn-gray" type="button" onclick="remove_new_grid2_fields(' + room + ');"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button></div></div></div></div><div class="clear"></div>';
		objTo.appendChild(divtest)
	}

	function remove_new_grid2_fields(rid) {
		$('.removeclass' + rid).remove();
	}
	
	function removeGrid2Data(rid) {
		$('.removeGrid2Data-' + rid).remove();
	}

</script>

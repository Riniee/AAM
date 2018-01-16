<div class="modal-wrapper">
	<!-- Modal -->
	<div class="modal fade" id="edit-grid1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="form-wrapper">
					<div class="form-header">
						<h3 class="text-uppercase">notes</h3>
					</div>
					<div class="form-content">
						<div class="form-group m-strong">
							<label class="col-form-label">title:</label>
							<div class="col-md-11 pad-left">
								<input class="form-control" value="<?php echo $grid1Data['TITLE'] ?>" placeholder="1180 Renewal %" type="text"> </div>							
						</div>
						<div class="form-group">
							<label class="col-form-label">text before:</label>
							<input class="form-control fill-bule" value="<?php echo $grid1Data['TEXT_BEFORE'] ?>" placeholder="Text Before Content:" type="text"> </div>
						<div class="form-group m-strong">
							<div class="col-md-12 pad-4">
								<div class="col-sm-5 pad-left nopadding">
									<div class="form-group">
										<label class="col-form-label">program name</label>
									</div>
								</div>
								<div class="col-sm-5 nopadding">
									<div class="form-group">
										<label class="col-form-label">average circulation</label>
									</div>
								</div>
							</div>
							<!-- Fields is here -->
							<div id="grid1_fields"> </div>
							<?php 								
								if(isset($grid1Data['data']) && $grid1Data['data']) {
								$count = count($grid1Data['data']);
								$i = 0;
								foreach ($grid1Data['data'] as $key=>$row) { 
									if(++$i === $count) {
										$displayGrid1Plus = true;
									}
							?>
							<div class="form-group removeGrid1Data-<?php echo $key; ?>">
							<div class="col-sm-5 pad-left nopadding">
								<div class="form-group">
									<input class="form-control fill-bule" value="<?php echo $grid1Data['TEXT'] ?>" placeholder="Text-1" type="text">
								</div>
							</div>
							<div class="col-sm-5 pad-right nopadding">
								<div class="form-group">
									<input class="form-control fill-bule" value="<?php echo $grid1Data['CIRC'] ?>" placeholder="22" type="text">
								</div>
							</div>
							<div class="col-sm-2 pad-right nopadding">
								<div class="form-group">
									<div class="btn-wrapper text-right margin-4">
										<?php if (isset($displayGrid1Plus)) { ?>
										<button class="btn btn-success btn-gray" type="button" onclick="add_new_grid1_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
										<?php } else { ?>
											<button class="btn btn-danger btn-gray" type="button" onclick="removeGrid1Data(<?php echo $key; ?>);"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button>
										<?php } ?>										
									</div>
								</div>
							</div>

							<div class="clear"></div>
							</div>
							<?php } } ?>
						</div>
						<div class="form-group">
							<label class="col-form-label">text after:</label>
							<input class="form-control fill-bule" value="<?php echo $grid1Data['TEXT_AFTER'] ?>" placeholder="text after contents" type="text"> </div>
					</div>
					<div class="form-footer">
						<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var room = 1;

	function add_new_grid1_fields() {
		room++;
		var grid1objTo = document.getElementById('grid1_fields')
		var divtestgrid1 = document.createElement("div");
		divtestgrid1.setAttribute("class", "form-group removeclassgrid1" + room);
		var rdiv = 'removeclassgrid1' + room;
		divtestgrid1.innerHTML = '<div class="col-sm-5 pad-left nopadding"><div class="form-group"><input class="form-control fill-bule" value="" placeholder="Text-1" type="text"></div></div><div class="col-sm-5 pad-right nopadding"><div class="form-group"><input class="form-control fill-bule" value="" placeholder="22" type="text"></div></div><div class="col-sm-2 pad-right nopadding"><div class="form-group"><div class="btn-wrapper text-right margin-4"><button class="btn btn-danger btn-gray" type="button" onclick="remove_new_grid1_fields(' + room + ');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button></div></div></div>';
		grid1objTo.appendChild(divtestgrid1)
	}

	function remove_new_grid1_fields(rid) {
		$('.removeclassgrid1' + rid).remove();
	}
	
	function removeGrid1Data(rid) {
		$('.removeGrid1Data-' + rid).remove();
	}

</script>
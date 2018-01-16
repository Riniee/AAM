<div class="modal-wrapper">
	<!-- Modal -->
	<div class="modal fade" id="edit-checkbox1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="form-wrapper">
					<div class="form-header">
						<h3 class="text-uppercase">notes</h3>
					</div>
					<div class="form-content m-strong">
						<div class="form-group m-strong">
							<label class="col-form-label">title:</label>
							<input class="form-control" value="<?php echo $checkBoxData2['TITLE']; ?>" placeholder="14557 Mulit-Title Digital Programs %" type="text">
						</div>
						<div class="form-group">
							<label class="col-form-label">text before:</label>
							<input class="form-control fill-bule" value="<?php echo $checkBoxData2['TEXT_BEFORE']; ?>" placeholder="Text Before Content:" type="text">
						</div>
						<div class="form-group">
							<div class="col-md-12 padd-4">
								<div class="input-wrapper">
								<?php 
									if (isset($checkBoxData1['data']) && $checkBoxData1['data']) {
										foreach ($checkBoxData1['data'] as $row) { ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" value="<?php echo $row['TEMP_TEXT']; ?>">
													<?php echo $row['TEMP_TEXT']; ?>
												</label>
											</div>
								<?php }	} ?>
																		
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="edit-checkbox2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="form-wrapper">
					<div class="form-header">
						<h3 class="text-uppercase">notes</h3>
					</div>
					<div class="form-content m-strong">
						<div class="form-group m-strong">
							<label class="col-form-label">title:</label>
							<input class="form-control" value="<?php echo $checkBoxData2['TITLE']; ?>" placeholder="14557 Mulit-Title Digital Programs %" type="text">
						</div>
						<div class="form-group">
							<label class="col-form-label">text before:</label>
							<input class="form-control fill-bule" value="<?php echo $checkBoxData2['TEXT_BEFORE']; ?>" placeholder="Text Before Content:" type="text">
						</div>
						<div class="form-group">
							<div class="col-md-12 padd-4">
								<div class="input-wrapper">
								<?php 
									if (isset($checkBoxData2['data']) && $checkBoxData2['data']) {
										foreach ($checkBoxData2['data'] as $row) { ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" value="<?php echo $row['TEMP_TEXT']; ?>">
													<?php echo $row['TEMP_TEXT']; ?>
												</label>
											</div>
								<?php }	} ?>
																		
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="edit-checkbox3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="form-wrapper">
					<div class="form-header">
						<h3 class="text-uppercase">notes</h3>
					</div>
					<div class="form-content m-strong">
						<div class="form-group m-strong">
							<label class="col-form-label">title:</label>
							<input class="form-control" value="<?php echo $checkBoxData3['TITLE']; ?>" placeholder="14557 Mulit-Title Digital Programs %" type="text">
						</div>
						<div class="form-group">
							<label class="col-form-label">text before:</label>
							<input class="form-control fill-bule" value="<?php echo $checkBoxData3['TEXT_BEFORE']; ?>" placeholder="Text Before Content:" type="text">
						</div>
						<div class="form-group">
							<div class="col-md-12 padd-4">
								<div class="input-wrapper">
								<?php 
									if (isset($checkBoxData3['data']) && $checkBoxData3['data']) {
										foreach ($checkBoxData3['data'] as $row) { ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" value="<?php echo $row['TEMP_TEXT']; ?>">
													<?php echo $row['TEMP_TEXT']; ?>
												</label>
											</div>
								<?php }	} ?>
																		
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="edit-checkbox4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="form-wrapper">
					<div class="form-header">
						<h3 class="text-uppercase">notes</h3>
					</div>
					<div class="form-content m-strong">
						<div class="form-group m-strong">
							<label class="col-form-label">title:</label>
							<input class="form-control" value="<?php echo $checkBoxData4['TITLE']; ?>" placeholder="14557 Mulit-Title Digital Programs %" type="text">
						</div>
						<div class="form-group">
							<label class="col-form-label">text before:</label>
							<input class="form-control fill-bule" value="<?php echo $checkBoxData4['TEXT_BEFORE']; ?>" placeholder="Text Before Content:" type="text">
						</div>
						<div class="form-group">
							<div class="col-md-12 padd-4">
								<div class="input-wrapper">
								<?php 
									if (isset($checkBoxData4['data']) && $checkBoxData4['data']) {
										foreach ($checkBoxData4['data'] as $row) { ?>
											<div class="checkbox">
												<label>
													<input type="checkbox" value="<?php echo $row['TEMP_TEXT']; ?>">
													<?php echo $row['TEMP_TEXT']; ?>
												</label>
											</div>
								<?php }	} ?>
																		
								</div>
							</div>
						</div>
					</div>
					<div class="form-footer">
						<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<!-- Modal -->
<div class="modal-wrapper">
	<div class="modal fade" id="myModal-<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<?php if ($noCirc) { ?>
					<div class="form-wrapper">
						<div class="form-header">
							<h3 class="text-uppercase">notes</h3>
						</div>
						<div class="form-content">
							<div class="form-group">
								<label class="col-form-label">title:</label>
								<input class="form-control" value="<?php echo $row['TITLE'] ?>" placeholder="Special issue" type="text">
							</div>
							<div class="form-group">
								<label class="col-form-label">text before:</label>
								<input class="form-control fill-bule" value="<?php echo $row['TEXT_BEFORE'] ?>" placeholder="Special issue circulation not included in averages." type="text">
							</div>
							<div class="form-group">
								<label class="col-form-label">text after:</label>
								<input class="form-control fill-bule" value="<?php echo $row['TEXT_AFTER'] ?>" placeholder="Text After Content" type="text">
							</div>
						</div>
						<div class="form-footer">
							<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
						</div>
					</div>
					<?php } ?>
					<?php if ($singleCirc) { ?>
					<div class="form-wrapper">
						<div class="form-header">
							<h3 class="text-uppercase">notes</h3>
						</div>
						<div class="form-content">
							<div class="form-group">
								<label class="col-form-label">title:</label>
								<input class="form-control" value="<?php echo $row['TITLE'] ?>" placeholder="1770 Award Point Programs" type="text">
							</div>
							<div class="form-group">
								<label class="col-form-label">text before:</label>
								<input class="form-control fill-bule" value="<?php echo $row['TEXT_BEFORE'] ?>" placeholder="Included in Paid Subscriptions Individual is the following average number of copies purchased through the redemption of award points/miles:" type="text">
							</div>
							<div class="form-group">
								<label class="col-form-label">text value:</label>
								<input class="form-control fill-bule" value="<?php echo $row['CIRC'] ?>" placeholder="101" type="text">
							</div>
							<div class="form-group">
								<label class="col-form-label">text after:</label>
								<input class="form-control fill-bule" value="<?php echo $row['TEXT_AFTER'] ?>" placeholder="text after content" type="text">
							</div>
						</div>
						<div class="form-footer">
							<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
						</div>
					</div>
					<?php } ?>
					<?php if ($threeCirc) { ?>
					<div class="form-wrapper">
						<div class="form-header">
							<h3 class="text-uppercase">notes</h3>
						</div>
						<div class="form-content">
							<div class="form-group">
								<label class="col-form-label">title:</label>
								<input class="form-control" value="<?php echo $row['TITLE'] ?>" placeholder="1180 Renewal %" type="text">
							</div>
							<div class="form-group">
								<label class="col-form-label">text before:</label>
								<input class="form-control fill-bule" value="<?php echo $row['TEXT_BEFORE'] ?>" placeholder="Renewal of Paid Subscriptions:" type="text">
							</div>
							<div class="form-group m-strong">
								<label class="col-md-4 col-form-label sm-text-label">total expirations during 12 months:</label>
								<div class="col-md-6">
									<input class="form-control fill-bule" value="<?php echo $row['TOT_12MON'] ?>" placeholder="1519584" type="text">
								</div>
							</div>
							<div class="form-group m-strong">
								<label class="col-md-4 col-form-label sm-text-label">total renewals of those expirations</label>
								<div class="col-md-6">
									<input class="form-control fill-bule" value="<?php echo $row['TOT_REN_EXP'] ?>" placeholder="11587584" type="text">
								</div>
							</div>
							<div class="form-group m-strong">
								<label class="col-md-4 col-form-label sm-text-label">renewal percentage:</label>
								<div class="col-md-6">
									<input class="form-control fill-bule" value="<?php echo $row['REN_PERCENT'] ?>" placeholder="44" type="text">
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label">text after:</label>
								<input class="form-control fill-bule" value="<?php echo $row['TEXT_AFTER'] ?>" placeholder="text after content" type="text">
							</div>
						</div>
						<div class="form-footer">
							<button type="button" value=" " class="btn btn-default btn-gray text-uppercase">ok</button>
						</div>
					</div>
					<?php } ?>
					<?php if ($grid1) { ?> Grid
					<?php } ?>
					<?php if ($grid2) { ?>
						
					<?php } ?>
					<?php if ($checkBox) { ?> Grid
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

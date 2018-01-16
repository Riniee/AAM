<!doctype html>
<html lang="en">
<head>
		<title>CNTL print digital</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="text/css" href="assets/images/icon.jpg">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/custom.css">
		<link rel="stylesheet" type="text/css" href="assets/css/font.css"> 
</head>

	<body>
		<div class="full-wrapper">
			<section id="prototype_table1">
				<div class="container-fluid">
					<div class="row header-div">
						<div class="col-md-6 col-sm-6 header-lft"> <img src="assets/images/logo.jpg" alt="aam">
							<h3>Publisher’s Statement</h3>
							<p>6 months ended December 31, 2015, Subject to Audit</p>
						</div>
						<div class="col-md-6 col-sm-6 header-rtl">
							<h1>Prototype Magazine</h1>
						<p><strong>Annual Frequency:</strong>
							<?php echo $lheader['FREQUENCY'] ?>
						</p>
						<p><strong>Field Served:</strong>
							<?php echo $lheader['FIELD_SERVED'] ?>
						</p>
						<h5>
							<?php echo $lheader['PUBLISHED_BY'] ?>
						</h5>
						</div>
					</div>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6">
							<div class="flt-lft">
								<div class="calculation-header">
									<h5>EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION</h5>
								</div>
								<div class="table-div">
									<table>
										<thead>
											<tr>
												<th>Total Analyzed
													<br> Nonpaid Circulation</th>
												<th>Rate
													<br> Base</th>
												<th>Variance
													<br> to Rate Base</th>
											</tr>
										</thead>
										<tbody>
											<?php 
								foreach ($es as $row) { ?>
								<tr>
									<td class="tb">
										<?php echo $row['NP_PARA_1_A_TOTAL_ANP'] ?>
									</td>
									<td class="tb">
										<?php echo $row['NP_PARA_1_TOTL_RB'] ?>
									</td>
									<td class="tb">
										<?php echo $row['NP_PARA_1_TOTL_VARIANCE_RB'] ?>
									</td>
								</tr>
								<?php		
								}
							?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="flt-lft">
								<div class="calculation-header">
									<h5>TOTAL CIRCULATION BY ISSUE</h5>
								</div>
								<div class="table-div">
									<table>
										<thead>
											<tr>
												<th class="vbh" colspan="2"></th>
												<th colspan="3">Analyzed Nonpaid</th>
											</tr>
										</thead>
										<thead>
											<tr>
												<th>&nbsp;&nbsp;</th>
												<th>Issue</th>
												<th>Print</th>
												<th>Digital
													<br /> Issue</th>
												<th>Total
													<br /> Analyzed
													<br /> Nonpaid</th>
											</tr>
										</thead>
										<tbody>
											 <?php 
								$count = count($tci);
								$i = 0;
								foreach ($tci as $row) {
									if(++$i === $count) {
										$tcibold = true;
									}
							?>
								<tr>
									<td class="tb">
										<?php echo $row['NPC_SPECIAL_ISSUE'] ?>
									</td>
									<td class="tb">
										<?php echo $row['NPC_ISSUE_NAME'] ?>
									</td>
									<td class="tb">
										<?php echo $row['NPC_TOTAL_ANP_PRINT'] ?>
									</td>
									<td class="tb">
										<?php echo $row['NPC_TOTAL_ANP_DIG_REPL'] ?>
									</td>
									<td class="tb">
										<?php echo $row['NPC_TOTAL_ANP'] ?>
									</td>
								</tr>
								<?php
								}
							?>
										</tbody>
									</table>
								</div>
							</div>
							
							<div class="flt-lft table-media-link">
								<p>Visit <a href="javascript:void(0);">www.auditedmedia.com</a> Media Intelligence Center for audit reports</p>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6">
							<div class="container-fluid rate-base">
								<div class="row">
									<div class="calculation-header">
										<h5>RATE BASE</h5>
									</div>
									<p>
							<?php echo $pvctext; ?>
						</p>
						<?php if ($rbca) { 
							foreach ($rbca as $row) { ?>
						<p>
							Rate Base Change(s):
							<br>
							<?php echo $row['start_rb'] ?> through
							<?php echo $row['start_date'] ?>,
							<?php echo $row['end_rb'] ?> starting
							<?php echo $row['end_date'] ?>
						</p>
						<?php
								
							}
						} ?>

							<?php if ($rbnotes) { ?>
							<p> Rate Base Notes:
								<?php echo $rbnotes; ?> </p>
							<?php }?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="calculation-header">
								<h5>NOTES</h5>
							</div>
						  <div class="row">
						<?php require 'common/notes.php'; ?>					
						</div>
							<div class="table-div">
								<table class="table">
									<tbody>
									<tr>
										<td>
											<p class="taj pl4">We certify that to the best of our knowledge all data set forth in this publisher’s statement are true and report circulation in accordance with Alliance for Audited Media’s bylaws and rules. </p>
											<p class="taj pl4">Parent Company:
												<?php echo $certify['PARENT_COMPANY'] ?>
											</p>
											<div class="container-fluid">
												<div class="row">
													<div class="col-md-6 col-sm-6">
														<p class="taj p0">NAME :
															<?php echo $certify['PARA_12_NAME1'] ?>
														</p>
														<p class="taj p0">Director :
															<?php echo $certify['PARA_12_TITLE1'] ?>
														</p>
														<p class="taj p0">Date Signed: </p>
														<p class="taj p0">
															<?php echo $certify['PHON_FAX_URL'] ?>
														</p>
														<p class="taj p0">Established:
															<?php echo $certify['ESTABLISHED'] ?>
														</p>
													</div>
													<div class="col-md-6 col-sm-6 ">
														<p class="taj p0">NAME :
															<?php echo $certify['PARA_12_NAME2'] ?>
														</p>
														<p class="taj p0">Publisher
															<?php echo $certify['PARA_12_TITLE2'] ?>
														</p>
														<p class="taj p0">Sales Offices:
															<?php echo $certify['SALES_OFFICE'] ?>
														</p>
														<p class="taj p0">&nbsp;</p>
														<p class="taj p0">AAM Member since:
															<?php echo $certify['MEM_SINCE'] ?>
														</p>
													</div>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<script type="text/javascript" src="libraries/jquery.js"></script>
		<script type="text/javascript" src="libraries/bootstrap.js"></script>
		<script type="text/javascript" src="libraries/custom.js"></script>
	</body>

	</html>
<!doctype html>
<html lang="en">

<head>
	<title>::MAG print only Canada::</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" type="text/css" href="assets/images/icon.jpg">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/custom.css">
	<link rel="stylesheet" type="text/css" href="assets/css/font.css"> </head>

<body>
	<div class="full-wrapper">
		<section id="prototype_table1">
			<div class="container-fluid">
				<div class="row header-div">
					<div class="col-md-6 col-sm-6 header-lft"> <img src="assets/images/logo.jpg" alt="aam">
						<h3>Publisher’s Statement</h3>
						<h4>6 months ended December 31, 2015, Subject to Audit</h4>
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
				<div class="row magazine-table-div">
					<div class="calculation-header">
						<h2>EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION</h2>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Total
										<br>Paid & Verified
										<br> Subscriptions</th>
									<th>Single Copy
										<br>Sales</th>
									<th>Total
										<br>Circulation</th>
									<th>Rate Base</th>
									<th>variance
										<br>of rate base</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach ($es as $row) { ?>
								<tr>
									<td class="tb">
										<?php echo $row['PARA_1_PAID_VERIF_SUBS'] ?>
									</td>
									<td class="tb">
										<?php echo $row['PARA_1_SCS'] ?>
									</td>
									<td class="tb">
										<?php echo $row['PARA_1_PAID_VERIF_ANP_CIRC'] ?>
									</td>
									<td class="tb">
										<?php echo $row['PARA_1_TOTL_RB'] ?>
									</td>
									<td class="tb">
										<?php echo $row['PARA_1_TOTL_VARIANCE_RB'] ?>
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
			<div class="container-fluid">
				<div class="row magazine-table-div">
					<div class="col-md-8 col-sm-8 p0">
						<div class="calculation-header">
							<h2>DIGITAL NONREPLICA</h2>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Total
											<br>Paid & Verified
											<br> Subscriptions</th>
										<th>Single Copy
											<br>Sales</th>
										<th>Total
											<br>Circulation</th>
									</tr>
								</thead>
								<tbody>
									<?php 
								foreach ($es as $row) { ?>
									<tr>
										<td class="tb">
											<?php echo $row['PAR_1_DIGIT_NR_PD_VER_SUBS'] ?>
										</td>
										<td class="tb">
											<?php echo $row['PARA_1_DIGIT_NON_REPL_SCS'] ?>
										</td>
										<td class="tb">
											<?php echo $row['PARA_1_DIGIT_NON_REPL_TOTAL'] ?>
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
			</div>
			<div class="container-fluid">
				<div class="row magazine-table-div">
					<div class="calculation-header">
						<h2>TOTAL CIRCULATION BY ISSUE</h2>
					</div>
					<div class="table-responsive">
						<table class="table fontsize">
							<thead>
								<tr>
									<th class="vbh">&nbsp;</th>
									<th class="vbh">&nbsp;</th>
									<th colspan="3">Paid Subscriptions</th>
									<th colspan="3">Verified Subscriptions</th>
									<th rowspan="2">Tota
										<br>lPaid & Verified
										<br>Subscriptions</th>
									<th colspan="3">Single Copy Sales</th>
									<th rowspan="2">Total
										<br>Paid & Verified
										<br>Circulation - Print</th>
									<th rowspan="2">Total
										<br>Paid & Verified
										<br>Circulation
										<br>- Digital Issue</th>
									<th rowspan="2">Total
										<br>Paid & Verified
										<br>Issue Print Circulation</th>
								</tr>
								<tr>
									<th colspan="2">Issue</th>
									<th>Print</th>
									<th>Digital
										<br>Issue</th>
									<th>Total
										<br>Paid
										<br>Subscriptions</th>
									<th>Print</th>
									<th>Digital
										<br>Issue</th>
									<th>Total
										<br>Verified
										<br>Subscriptions</th>
									<th>Print</th>
									<th>Digital
										<br>Issue</th>
									<th>Total
										<br>Single Copy
										<br>Sales</th>
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
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['SPECIAL_ISSUE'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['ISSUE_NAME'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['PAID_SUBS_PRINT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['PAID_SUBS_DIGIT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['SUBSCRIPTION_COUNT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['VERIF_SUBS_PRINT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['VERIF_SUBS_DIGIT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['VERIF_SUBS'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_SUBS'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['SCS_PRINT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['SCS_DIGIT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['SINGLE_COPY_COUNT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_CIRC_PRINT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_CIRC_DIGIT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_CIRC'] ?>
									</td>
								</tr>
								<?php
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row magazine-table-div">
					<div class="calculation-header">
						<h2>DIGITAL NONREPLICA</h2>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th colspan="2">Issue</th>
									<th>Paid
										<br>Subscriptions</th>
									<th>Verified
										<br>Subscriptions</th>
									<th>Total
										<br>Paid & Verified
										<br>Subscriptions</th>
									<th>Single Copy
										<br>Sales</th>
									<th>Total
										<br>Paid & Verified
										<br>Circulation</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$count = count($tci);
								$i = 0;
								foreach ($tci as $row) {
									if(++$i === $count) {
										$tcibold1 = true;
									}
							?>
								<tr>
									<td <?php if(isset($tcibold1)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['SPECIAL_ISSUE'] ?>
									</td>
									<td <?php if(isset($tcibold1)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['ISSUE_NAME'] ?>
									</td>
									<td <?php if(isset($tcibold1)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['PAID_SUBS_DIG_NR'] ?>
									</td>
									<td <?php if(isset($tcibold1)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['VERIF_SUBS_DIG_NR'] ?>
									</td>
									<td <?php if(isset($tcibold1)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_SUBS_DIG_NR'] ?>
									</td>
									<td <?php if(isset($tcibold1)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['SCS_DIG_NR'] ?>
									</td>
									<td <?php if(isset($tcibold1)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_CIRC_DIG_NR'] ?>
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
			<div class="container-fluid">
				<div class="row magazine-table-div">
					<div class="col-md-6 col-sm-12 pl4">
						<div class="calculation-header">
							<h2>SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION</h2>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th class="vbh">&nbsp;</th>
										<th>Print</th>
										<th>Digital
											<br>Issue</th>
										<th>Total</th>
										<th>% of Circulation</th>
										<th>Digital Nonreplica</th>
									</tr>
								</thead>
								<tbody>
									<?php if ($psdata) { ?>
									<tr>
										<th class="blue-light-clr p0" colspan="6">Paid Subscriptions</th>
									</tr>
									<tr>
										<td class="taj pr4">Individual Subscriptions</td>
										<td>
											<?php echo $sa['PARA_6_PD_INDV_SUBS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_INDV_SUBS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_INDIV_SUBS_PCT'] ?>
										</td>

										<td>
											<?php echo $sa['PARA_6_PD_INDIV_SUBS_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_INDV_SUBS_DIG_NR'] ?>
										</td>
									</tr>

									<tr>
										<td class="taj pr4">Association: Deductible</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_DED_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_DED'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSO_SUBS_DED_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Association: Nondeductible</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_ND_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_ND'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_ASSO_SUBS_ND_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Club/Membership: Deductible</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBR_DED_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBER_DED'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMB_DED_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Club/Membership: Nondeductible</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBR_ND_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBER_ND'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_CLUB_MEMB_ND_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Deferred</td>
										<td>
											<?php echo $sa['PARA_6_PD_DEFER_SUBS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_DEFER_SUBS_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_DEFER_SUBS'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_DEFER_SUBS_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_DEFER_SUBS_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Partnership Deductible Subscriptions</td>
										<td>
											<?php echo $sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_PRTNR_SUBS_DED_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_PARTNER_SUBS_DED'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_PRTNR_SUB_DED_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">School</td>
										<td>
											<?php echo $sa['PARA_6_PD_SCHOOL_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SCHOOL_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SCHOOL_SUBS'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SCHOOL_SUBS_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SCHOOL_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Sponsored Subscriptions</td>
										<td>
											<?php echo $sa['PARA_6_PD_SPONS_SALES_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SPONS_SALES_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SPONS_SALES'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SPONS_SALES_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_PD_SPONS_SALES_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4 tb">Total Paid Subscriptions</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PAID_SUBS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PAID_SUBS_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PAID_SUBS'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PAID_SUBS_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PAID_SUBS_DIG_NR'] ?>
										</td>
									</tr>
									<?php } ?>

									<?php if ($vsdata) { ?>
									<tr>
										<th class="blue-light-clr p0" colspan="6">Verified Subscriptions</th>
									</tr>
									<tr>
										<td class="taj pr4">Public Place</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_PP_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_PP_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_PUBL_PL'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_PP_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Individual Use</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_IU_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_IU_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_IND_USE'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_IND_USE_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_VERIF_SUBS_IU_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4 tb">Total Verified Subscriptions</td>
										<td>
											<?php echo $sa['PARA_6_TOT_VERIF_SUBS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOT_VERIF_SUBS_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_VERIF_SUBS'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_VERIF_SUBS_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOT_VERIF_SUBS_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4 tb">Total Paid & Verified Subscrptions</td>
										<td>
											<?php echo $sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOT_PD_VERIF_SUBS_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PD_VERIF_SUBS'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOT_PD_VER_SUBS_DIG_NR'] ?>
										</td>
									</tr>
									<?php } ?>
									<?php if ($scsdata) { ?>
									<tr>
										<th class="blue-light-clr p0" colspan="6">Single Copy Sales</th>
									</tr>
									<tr>
										<td class="taj pr4">Single Issue</td>
										<td>
											<?php echo $sa['PARA_6_SCS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SINGLE_ISSUE_SALES'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SINGLE_ISSUE_SALES_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Partnership Deductible Single Issue</td>
										<td>
											<?php echo $sa['PARA_6_SCS_PARTNER_DED_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_PARTNER_DED_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_PARTNERSHIP_DED'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_PARTNER_DED_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Sponsored Single Issue</td>
										<td>
											<?php echo $sa['PARA_6_SCS_SPONS_SALES_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_SPONS_SALES_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_SPONS_SALES'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_SPONS_SALES_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_SCS_SPONS_SALES_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4 tb">Total Single Copy Sales</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_SCS_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_SCS_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_SCS'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_SCS_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_SCS_DIG_NR'] ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4 tb">Total Paid & Verified Circulation</td>
										<td>
											<?php echo $sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOT_PD_VERIF_CIRC_DIGIT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PD_VERIF_CIRC'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'] ?>
										</td>
										<td>
											<?php echo $sa['PARA_6_TOT_PD_VER_CIRC_DIG_NR'] ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 p0">
						<div class="calculation-header">
							<h2>VARIANCE OF LAST THREE RELEASED AUDIT REPORTS</h2>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>Audit Period Ended</th>
										<th>Rate Base</th>
										<th>Audit Report</th>
										<th>Publisher's Statements</th>
										<th>Difference</th>
										<th>Percentage of Difference</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach ($variance as $row) {
								?>
									<tr>
										<td>
											<?php echo $row['DRIVE_DATE'] ?>
										</td>
										<td>
											<?php echo $row['RATE_BASE'] ?>
										</td>
										<td>
											<?php echo $row['AUDIT_REPORT'] ?>
										</td>
										<td>
											<?php echo $row['PUBLISHERS_STATEMENT'] ?>
										</td>
										<td>
											<?php echo $row['DIFFERENCE'] ?>
										</td>
										<td>
											<?php echo $row['PERCENTAGE_OF_DIFFERENCE'] ?>
										</td>
									</tr>
									<?php
									}
								?>
								</tbody>
							</table>
							<p>Visit www.auditedmedia.com Media Intelligence Center for audit reports</p>
						</div>
						<div class="calculation-header">
							<h2>PRICES</h2>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th class="vbh">&nbsp;</th>
										<th rowspan="2">Suggested
											<br>Retail Prices (1)</th>
										<th colspan="2">Average Price (2)</th>
									</tr>
									<tr>
										<th class="vbh">&nbsp;</th>
										<th>Net</th>
										<th>Gross
											<br>(Optional)</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$asc = 0;
									$subscription = 0;
									$aspa1net = 0;
									$aspa1gross = 0;
									$aspa2net = 0;
									$aspa2gross = 0;
									foreach ($prices as $row) {
										$asc += $row['AVERAGE_SINGLE_COPY'];
										$subscription += $row['SUBSCRIPTION'];
										$aspa1net += $row['AVG_SUB_PRI_NET'];
										$aspa1gross += $row['AVG_SUBCRB_PRI_GROSS'];
										$aspa2net += $row['AVG_SUBCRB_PCPY_NET'];
										$aspa2gross += $row['AVG_SUBCRB_PCPY_GROSS'];
									}
								?>
									<tr>
										<td class="taj pr4">Average Single Copy</td>
										<td>$
											<?php echo $asc; ?>
										</td>
										<td rowspan="2">&nbsp;</td>
										<td rowspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td class="taj pr4">Subscription</td>
										<td>$
											<?php echo $subscription; ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Average Subscription Price Annualized (3)</td>
										<td rowspan="2">&nbsp;</td>
										<td>$
											<?php echo $aspa1net; ?>
										</td>
										<td>$
											<?php echo $aspa1gross; ?>
										</td>
									</tr>
									<tr>
										<td class="taj pr4">Average Subscription Price Annualized (3)</td>
										<td>$
											<?php echo $aspa2net; ?>
										</td>
										<td>$
											<?php echo $aspa2gross; ?>
										</td>
									</tr>
								</tbody>
							</table>
							<p>(1) For statement period</p>
							<p>(2) Represents subscriptions for the 12 month period ended June 30, 2015</p>
							<p>(3) Based on the following issue per year frequency: 10</p>
						</div>
					</div>
				</div>
				<div class="row magazine-table-div">
					<div class="col-md-6 col-sm-12 pl4">
						<div class="calculation-header">
							<h2>ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER</h2>
						</div>
						<p>Circulation by Regional, Metro & Demographic Editions
							<br> Geographic Data
							<br> Analysis of New & Renewal Paid Individual Subscriptions
							<br> Trend Analysis</p>
						<div class="calculation-header">
							<h2>ADDITIONAL ANALYSIS OF VERIFIED</h2>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th class="vbh">&nbsp;</th>
										<th>Print</th>
										<th>Digital
											<br>Issue</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									
									<?php print_r($paav);  if ($paav) { ?>
									<tr>
										<th class="blue-light-clr p0" colspan="4">Public Place</th>
									</tr>
									<?php 
										$count = count($paav);
										$i = 0;
										foreach ($paav as $row) {
											if(++$i === $count) {
												$paavbold = true;
											} 
									?>
									<tr>
										<td <?php if (isset($paavbold)) { ?> class="taj pr4 tb"
											<?php } else { ?> class="taj pr4"
											<?php } ?> >
											<?php echo $row['DESCRIPTION']; ?>
										</td>
										<td>
											<?php echo $row['MAVS_VERIF_SUBS_PRINT']; ?>
										</td>
										<td>
											<?php echo $row['MAVS_VERIF_SUBS_DIGIT']; ?>
										</td>
										<td>
											<?php echo $row['MAVS_VERIF_SUBS']; ?>
										</td>
									</tr>
									<?php } ?>
									<?php } ?>
									<?php if ($iaav) { ?>
									<tr>
										<th class="blue-light-clr p0" colspan="4">Individual Use</th>
									</tr>
									<?php 
										$count = count($iaav);
										$i = 0;
										foreach ($iaav as $row) {
											if(++$i === $count) {
												$iaavbold = true;
											} 
									?>
									<tr>
										<td <?php if (isset($iaavbold)) { ?> class="taj pr4 tb"
											<?php } else { ?> class="taj pr4"
											<?php } ?> >
											<?php echo $row['DESCRIPTION']; ?>
										</td>
										<td>
											<?php echo $row['MAVS_VERIF_SUBS_PRINT']; ?>
										</td>
										<td>
											<?php echo $row['MAVS_VERIF_SUBS_DIGIT']; ?>
										</td>
										<td>
											<?php echo $row['MAVS_VERIF_SUBS']; ?>
										</td>
									</tr>
									<?php } ?>
									<?php } ?>
								</tbody>
							</table>
							<p>Visit www.auditedmedia.com Media Intelligence Center for audit reports</p>
						</div>
						<div class="calculation-header">
							<h2>RATE BASE</h2>
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
					<div class="col-md-6 col-sm-12 p0">
						<div class="calculation-header">
							<h2>NOTES</h2>
						</div>
						<div class="row">
							<?php require 'common/notes.php'; ?>
						</div>

						<div class="table-responsive">
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
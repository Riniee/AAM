<!doctype html>
<html lang="en">

<head>
    <title>::MAG print only Canada::</title>
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
						</h5></div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="calculation-header">
                    <h5>EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION</h5> </div>
                <div class="table-div">
                    <table>
						<thead>
                        <tr>
                            <th> Total
                                <br /> Paid &amp; Verified
                                <br /> Subscriptions </th>
                            <th> Single Copy
                                <br /> Sales </th>
                            <th> Total
                                <br /> Paid &amp; Verified
                                <br /> Circulation </th>
                            <th> Analyzed
                                <br /> Nonpaid </th>
                            <th> Total
                                <br /> Circulation </th>
                            <th> Rate
                                <br /> Base </th>
                            <th> Variance
                                <br /> to Rate Base </th>
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
										<?php echo $row['PARA_1_PAID_VERIF_CIRC'] ?>
									</td>
									<td class="tb">
										<?php echo $row['PARA_1_TOTAL_ANP_CIRC'] ?>
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
            <div class="container-fluid">
                <div class="calculation-header">
                    <h5>TOTAL CIRCULATION BY ISSUE</h5> </div>
                <div class="table-div fontsize">
                    <table >
						<thead>
                        <tr>
                            <th class="fontsize border-none" colspan="2"></th>
                            <th class="fontsize" colspan="3"> Paid Subscriptions </th>
                            <th class="fontsize" colspan="3"> Verified Subscriptions </th>
                            <th class="fontsize" rowspan="2"> Paid &amp; Verified
                                <br /> Subscriptions
                                <br /> - Print </th>
                            <th class="fontsize" rowspan="2"> Paid &amp; Verified
                                <br /> Subscriptions
                                <br /> - Digital Issue </th>
                            <th class="fontsize" rowspan="2"> Total
                                <br /> Paid &amp; Verified
                                <br /> Subscriptions </th>
                            <th class="fontsize" colspan="3"> Single Copy Sales </th>
                            <th class="fontsize" rowspan="2"> Total
                                <br /> Paid &amp; Verified
                                <br /> Circulation
                                <br /> - Print </th>
                            <th class="fontsize" rowspan="2"> Total
                                <br /> Paid &amp; Verified
                                <br /> Circulation
                                <br /> - Digital Issue </th>
                            <th class="fontsize" rowspan="2"> Total
                                <br /> Paid &amp; Verified
                                <br /> Circulation </th>
                            <th class="fontsize" colspan="3"> Analyzed Nonpaid </th>
                            <th class="fontsize" rowspan="2"> Total
                                <br /> Paid, Verified &amp;
                                <br /> Analyzed Nonpaid
                                <br /> Circulation - Print </th>
                            <th class="fontsize" rowspan="2"> Total
                                <br /> Paid, Verified &amp;
                                <br /> Analyzed Nonpaid
                                <br /> Circulation
                                <br /> - Digital Issue </th>
                            <th class="fontsize" rowspan="2"> Total
                                <br /> Paid, Verified &amp;
                                <br /> Analyzed Nonpaid
                                <br /> Issue Print Circulation </th>
                        </tr>
							<tr>
                            <th class="fontsize" colspan="2"> Issue </th>
                            <th class="fontsize"> Print </th>
                            <th class="fontsize"> Digital
                                <br /> Issue </th>
                            <th class="fontsize"> Total
                                <br /> Paid
                                <br /> Subscriptions </th>
                            <th class="fontsize"> Print </th>
                            <th class="fontsize"> Digital
                                <br /> Issue </th>
                            <th class="fontsize"> Total
                                <br /> Paid
                                <br /> Subscriptions </th>
                            <th class="fontsize"> Print </th>
                            <th class="fontsize"> Digital
                                <br /> Issue </th>
                            <th class="fontsize"> Total
                                <br /> Single Copy
                                <br /> Sales </th>
                            <th class="fontsize"> Print </th>
                            <th class="fontsize"> Digital
                                <br /> Issue </th>
                            <th class="fontsize"> Total
                                <br /> Analyzed
                                <br /> Nonpaid </th>
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
										<?php echo $row['TOTAL_PAID_VERIF_SUBS_PRINT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_SUBS_DIGIT'] ?>
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
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['ANP_PRINT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['ANP_DIGIT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['ANP_COUNT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VER_ANP_CIRC_PRINT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VER_ANP_CIRC_DIGIT'] ?>
									</td>
									<td <?php if(isset($tcibold)) { ?> class="tb"
										<?php } ?> >
										<?php echo $row['TOTAL_PAID_VERIF_ANP_CIRC'] ?>
									</td>
								</tr>
								<?php
								}
							?>
                    </table>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="calculation-header">
                            <h5>Prices</h5>
                        </div>
                        <div class="table-div">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="border-none"></th>
                                        <th>Suggested
                                            <br> Retail Prices (1)</th>
                                    </tr>
                                </thead>
								<tbody>
								      <?php 
									$asc = 0;
									$subscription = 0;
									
									foreach ($prices as $row) {
										$asc += $row['AVERAGE_SINGLE_COPY'];
										$subscription += $row['SUBSCRIPTION'];
								
									}
								?>
                                    <tr>
                                        <td class="taj pr4">Average Single Copy</td>
                                        <td>$
											<?php echo $asc; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="taj pr4">Subscription</td>
                                        <td>$
											<?php echo $subscription; ?></td>
                                    </tr>
								</tbody>
                            </table>
                        </div>
                        <div class="container-fluid table-content">
                            <div class="row">
                                <div class="period">
                                    <p>(1) For statement period</p>
                                </div>
                            </div>
                        </div>
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
                        <div class="table-div">
                             <div class="row">
                            <?php require 'common/notes.php'; ?>
                        </div>
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
													</div>>
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
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
                    <div class="col-md-6 col-sm-6 header-lft"> <img src="../assets/images/logo.jpg" alt="aam">
                        <h3>Publisher’s Statement</h3>
                        <h4>6 months ended December 31, 2015, Subject to Audit</h4> </div>
                    <div class="col-md-6 col-sm-6 header-rtl">
                        <h1>Prototype Magazine</h1>
                        <p><strong>Annual Frequency:</strong>10</p>
                        <p><strong>Field Served:</strong> Consumers interested in healthy living.</p>
                        <h5>Published by Magazine Inc.</h5> </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row magazine-table-div">
				   <?php
				    if(count($es)>0) {	
					?>
                    <div class="col-md-12 col-sm-12 p0">
                        <div class="calculation-header">
                            <h2>EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION</h2> </div>
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
					<?php } ?>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row magazine-table-div">
                    <div class="col-md-8 col-sm-8 p0">
                        <div class="calculation-header">
                            <h2>DIGITAL NONREPLICA(STATIC)</h2> </div>
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
                                    <tr>
                                        <td class="tb">21,067</td>
                                        <td class="tb">788</td>
                                        <td class="tb">21,855</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row magazine-table-div">
                    <div class="calculation-header">
                        <h2>TOTAL CIRCULATION BY ISSUE</h2> </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="vbh">&nbsp;</th>
                                    <th class="vbh"></th>
                                    <th colspan="5">Print</th>
                                </tr>
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
										<?php echo $row['VERIF_SUBS_PRINT'] ?>
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
                        <h2>DIGITAL NONREPLICA(STATIC)</h2> </div>
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
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                    <td>July</td>
                                    <td>21,081</td>
                                    <td></td>
                                    <td>21,081</td>
                                    <td>1,529</td>
                                    <td>22,610</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Aug.</td>
                                    <td>21,146</td>
                                    <td></td>
                                    <td>21,146</td>
                                    <td>522</td>
                                    <td>21,668</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Sept.</td>
                                    <td>21,417</td>
                                    <td></td>
                                    <td>21,417</td>
                                    <td>610</td>
                                    <td>22,027</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Oct.</td>
                                    <td>21,468</td>
                                    <td></td>
                                    <td>21,468</td>
                                    <td>839</td>
                                    <td>22,307</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Nov./Dec.</td>
                                    <td>20,223</td>
                                    <td></td>
                                    <td>20,223</td>
                                    <td>438</td>
                                    <td>20,661 </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="tb">Average</td>
                                    <td class="tb">21,067</td>
                                    <td class="tb"></td>
                                    <td class="tb">21,067</td>
                                    <td class="tb">788</td>
                                    <td class="tb">21,885</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row magazine-table-div">
                    <div class="col-md-6 col-sm-12 pl4">
                        <div class="calculation-header">
                            <h2>SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION</h2> </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="vbh">&nbsp;</th>
                                        <th>Print</th>
                                        <th>% of Circulation</th>
                                        <th>Digital Nonreplica</th>
                                    </tr>
								</thead>
								 <tbody>
								<?php if ($psdata) { ?>	
                                    <tr>
                                        <th class="tal" colspan="4">Paid Subscriptions</th>
                                    </tr> 
								    <?php if ($sa['PARA_6_PD_INDV_SUBS_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Individual Subscriptions</td>
											<td><?php echo $sa['PARA_6_PD_INDV_SUBS_PRINT'] ?></td>
											<td><?php echo $sa['PARA_6_PD_INDIV_SUBS_PCT'] ?></td>
											<td><?php echo $sa['PARA_6_PD_INDV_SUBS_DIG_NR'] ?></td>
										</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Association: Deductible</td>
										<td><?php echo $sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_ASSO_SUBS_DED_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Association: Nondeductible</td>
										<td><?php echo $sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_ASSO_SUBS_ND_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Club/Membership: Deductible</td>
										<td><?php echo $sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_CLUB_MEMB_DED_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Club/Membership: Nondeductible</td>
										<td><?php echo $sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_CLUB_MEMB_ND_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_DEFER_SUBS_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Deferred</td>
										<td><?php echo $sa['PARA_6_PD_DEFER_SUBS_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_DEFER_SUBS_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_DEFER_SUBS_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Partnership Deductible Subscriptions</td>
										<td><?php echo $sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_PRTNR_SUB_DED_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_SCHOOL_PRINT']) { ?>
									<tr>
										<td class="taj pr4">School</td>
										<td><?php echo $sa['PARA_6_PD_SCHOOL_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_SCHOOL_SUBS_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_SCHOOL_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_PD_SPONS_SALES_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Sponsored Subscriptions</td>
										<td><?php echo $sa['PARA_6_PD_SPONS_SALES_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_SPONS_SALES_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_PD_SPONS_SALES_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_TOTAL_PAID_SUBS_PRINT']) { ?>
									<tr>
										<td class="taj pr4 tb">Total Paid Subscriptions</td>
										<td><?php echo $sa['PARA_6_TOTAL_PAID_SUBS_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_TOTAL_PAID_SUBS_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_TOTAL_PAID_SUBS_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
								<?php } ?>
								<?php if ($vsdata) { ?>
                                    <tr>
                                        <th class="blue-light-clr p0" colspan="4">Verified Subscriptions</th>
                                    </tr>
 									<?php if ($sa['PARA_6_VERIF_SUBS_PP_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Public Place</td>
										<td><?php echo $sa['PARA_6_VERIF_SUBS_PP_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_VERIF_SUBS_PP_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_VERIF_SUBS_IU_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Individual Use</td>
										<td><?php echo $sa['PARA_6_VERIF_SUBS_IU_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_VERIF_SUBS_IND_USE_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_VERIF_SUBS_IU_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_TOT_VERIF_SUBS_PRINT']) { ?>
									<tr>
										<td class="taj pr4 tb">Total Verified Subscriptions</td>
										<td><?php echo $sa['PARA_6_TOT_VERIF_SUBS_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_TOTAL_VERIF_SUBS_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_TOT_VERIF_SUBS_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT']) { ?>
									<tr>
										<td class="taj pr4 tb">Total Paid & Verified Subscrptions</td>
										<td><?php echo $sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_TOT_PD_VER_SUBS_DIG_NR'] ?></td>
									</tr>
									<?php } ?>								
									<?php } ?>
									<?php if ($scsdata) { ?>
                                    <tr>
                                        <th class="blue-light-clr p0" colspan="4">Single Copy Sales</th>
                                    </tr>
									<?php if ($sa['PARA_6_SCS_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Single Issue</td>
										<td><?php echo $sa['PARA_6_SCS_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_SINGLE_ISSUE_SALES_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_SCS_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_SCS_PARTNER_DED_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Partnership Deductible Single Issue</td>
										<td><?php echo $sa['PARA_6_SCS_PARTNER_DED_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_SCS_PARTNER_DED_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_SCS_SPONS_SALES_PRINT']) { ?>
									<tr>
										<td class="taj pr4">Sponsored Single Issue</td>
										<td><?php echo $sa['PARA_6_SCS_SPONS_SALES_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_SCS_SPONS_SALES_PCT'] ?></td>
										<td><?php echo $sa['para_6_scs_spons_sales_dig_nr'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_TOTAL_SCS_PRINT']) { ?>
									<tr>
										<td class="taj pr4 tb">Total Single Copy Sales</td>
										<td><?php echo $sa['PARA_6_TOTAL_SCS_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_TOTAL_SCS_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_TOTAL_SCS_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php if ($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT']) { ?>
									<tr>
										<td class="taj pr4 tb">Total Paid & Verified Circulation</td>
										<td><?php echo $sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'] ?></td>
										<td><?php echo $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'] ?></td>
										<td><?php echo $sa['PARA_6_TOT_PD_VER_CIRC_DIG_NR'] ?></td>
									</tr>
									<?php } ?>
									<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 p0">
                        <div class="calculation-header">
                            <h2>VARIANCE OF LAST THREE RELEASED AUDIT REPORTS</h2> </div>
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
                            <h2>PRICES</h2> </div>
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
                            <h2>ADDITIONAL ANALYSIS OF VERIFIED</h2> </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="vbh">&nbsp;</th>
                                        <th>Print</th>
                                    </tr>
                                    <tr>
                                        <th class="tal" colspan="2">Public Place</th>
                                    </tr>
                                </thead>
 								<tbody>
									<?php if ($paav) { ?>
									<tr>
										<th class="blue-light-clr p0" colspan="2">Public Place</th>
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
									</tr>
									<?php } ?>
									<?php } ?>
									<?php if ($iaav) { ?>
									<tr>
										<th class="blue-light-clr p0" colspan="2">Individual Use</th>
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
									</tr>
									<?php } 
									} ?>

								</tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 p0">
                        <div class="calculation-header">
                            <h2>ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER</h2> </div>
                        <p>Circulation by Regional, Metro & Demographic Editions
                            <br> Geographic Data
                            <br> Analysis of New & Renewal Paid Individual Subscriptions
                            <br> Trend Analysis</p>
                        <div class="calculation-header">
                            <h2>RATE BASE</h2> 
						</div>
						<p><?php echo $pvctext; ?></p>
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

						<?php if ($rbnotes) { ?> <p> Rate Base Notes: <?php echo $rbnotes; ?> </p> <?php }?>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 pl4">
							<div class="calculation-header">
							   <h2>NOTES</h2>
							</div>
							<div class="row">
							   <?php require 'common/notes.php'; ?>					
							</div>
                            <p><strong>Combination Subscriptions:</strong> Included in Paid Subscriptions Individual are copies served to subscribers who purchased this publication in combination with one or more different publications.</p>
                            <p><strong>Partnership Deductible:</strong> These copies shown in Supplemental Analysis of Average Circulation represent copies served where the subscription was included in purchases of other products or services. The consumer could receive a rebate instead of the subscription.</p>
                            <p><strong>Sponsored Subscriptions:</strong> These copies shown in Supplemental Analysis of Average Circulation represent copies purchased by a third party in quantities of 11 or more for distribution to consumers.</p>
                            <p><strong>Association: Deductible:</strong> These copies shown in Paid Subscriptions represent copies served where the subscription was included in the dues of an association. The subscription was deductible from dues.</p>
                            <p><strong>Post Expiration Copies:</strong> Included in Paid Subscriptions is the following average number of copies served to subscribers post expiration pending renewal: 3,700</p>
                            <p>Pursuant to a review by the AAM Board of Directors, copies distributed through the Next Issue Media Unlimited program are reported as single copy sales based on consumer payment for the program and consumer’s request for a specific magazine. Included in Single Copy Sales Digital is the following average copies per issue from this program: 1,500 </p>
                            <p><strong>Average nonanalyzed nonpaid for period:</strong> 9,500</p>
                            <p>* Special issue circulation not included in averages.</p>
                            <p><strong>(additional disclosures as required will also appear)</strong></p>
                            <div class="table-responsive">
                                <table class="table">
 								<tbody>
									<tr>
										<td>
											<p class="taj pl4">We certify that to the best of our knowledge all data set forth in this publisher’s statement are true and report circulation in accordance with Alliance for Audited Media’s bylaws and rules. </p>
											<p class="taj pl4">Parent Company:
												<?php echo $certify['PARENT_COMPANY'] ?></p>
											<div class="container-fluid">
												<div class="row">
													<div class="col-md-6 col-sm-6">
														<p class="taj p0">NAME : <?php echo $certify['PARA_12_NAME1'] ?></p>
														<p class="taj p0">Director : <?php echo $certify['PARA_12_TITLE1'] ?></p>
														<p class="taj p0">Date Signed: </p>
														<p class="taj p0"><?php echo $certify['PHON_FAX_URL'] ?></p>
														<p class="taj p0">Established: <?php echo $certify['ESTABLISHED'] ?></p>
													</div>
													<div class="col-md-6 col-sm-6 ">
														<p class="taj p0">NAME : <?php echo $certify['PARA_12_NAME2'] ?></p>
														<p class="taj p0">Publisher <?php echo $certify['PARA_12_TITLE2'] ?></p>
														<p class="taj p0">Sales Offices: <?php echo $certify['SALES_OFFICE'] ?></p>
														<p class="taj p0">&nbsp;</p>
														<p class="taj p0">AAM Member since:<?php echo $certify['MEM_SINCE'] ?></p>
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
            </div>
        </section>
    </div>
    <script type="text/javascript" src="../libraries/jquery.js"></script>
    <script type="text/javascript" src="../libraries/bootstrap.js"></script>
    <script type="text/javascript" src="../libraries/custom.js"></script>
</body>

</html>
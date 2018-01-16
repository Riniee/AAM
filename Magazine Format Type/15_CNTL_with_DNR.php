<!doctype html>
<html lang="en">

<head>
    <title>CNTL with DNR</title>
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
                        <p>6 months ended December 31, 2015, Subject to Audit</p>
                    </div>
                    <div class="col-md-6 col-sm-6 header-rtl">
                        <h1>Prototype Magazine</h1>
                        <p><strong>Annual Frequency: </strong>10</p>
                        <p><strong>Field Served:</strong> Consumers interested in healthy living.</p>
                        <h5>Published by Magazine Inc.</h5> </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="flt-lft">
                            <div class="calculation-header">
                                <h5>EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION</h5> </div>
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
                        <div class="flt-lft cmd-width">
                            <div class="calculation-header">
                                <h5>DIGITAL NONREPLICA</h5> </div>
                            <div class="table-div">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Total Analyzed
                                                <br> Nonpaid Circulation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php 										
										foreach ($es as $row) { ?>
										<tr>
											<td class="tb">
												<?php echo $row['NP_PARA_1_A_TOTAL_ANP'] ?>
											</td>																			
										</tr>
										<?php		
										}
									?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flt-lft">
                            <div class="calculation-header">
                                <h5>SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION</h5> </div>
                            <div class="table-div">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="vbh"></th>
                                            <th>Print</th>
                                            <th>% of Circulation</th>
                                            <th>Digital Nonreplica</th>
                                        </tr>
                                        <tr>
                                            <th class="lft" colspan="3">Analyzed Nonpaid</th>
                                            <th></th>
                                        </tr>
                                    </thead>
  									 <tbody>
									<?php  /*if ($psdata) { */ ?>
									<?php if ($sa['NP_PARA_1_LIST_PRINT']) { ?>
                                        <tr>
                                            <td class="lft">List</td>
                                            <td><?php echo $sa['NP_PARA_1_LIST_PRINT'] ?></td>
                                            <td><?php echo $sa['NP_PARA_1_LIST_SOURCE_PCT'] ?></td>
                                            <td><?php //echo $sa['NP_PARA_1_LIST_DIG_NR'] ?></td>
                                        </tr>
									 <?php } ?>
									 <?php if ($sa['NP_PARA_1_MKT_COV_PRINT']) { ?>
                                        <tr>
                                            <td class="lft">Market Coverage</td>
                                            <td><?php echo $sa['NP_PARA_1_MKT_COV_PRINT'] ?></td>   
                                            <td><?php echo $sa['NP_PARA_1_MKT_COV_PCT'] ?></td>
                                            <td><?php //echo $sa['NP_PARA_1_MKT_COV_DIG_NR'] ?></td>
                                        </tr>
									 <?php } ?>	
									 <?php if ($sa['NP_PARA_1_BULK_PRINT']) { ?>
                                        <tr>
                                            <td class="lft">Nonpaid Bulk</td>
                                            <td><?php echo $sa['NP_PARA_1_BULK_PRINT'] ?></td>
                                            <td><?php echo $sa['NP_PARA_1_BULK_PCT'] ?></td>
                                            <td><?php //echo $sa['NP_PARA_1_BULK_DIG_NR'] ?></td>                                          
                                        </tr>
									 <?php } ?>	
									 <?php if ($sa['NP_PARA_1_DEL_HOST_PROD_PRINT']) { ?>
                                        <tr>
                                            <td class="lft">Delivered with Host Product</td>
                                            <td><?php echo $sa['NP_PARA_1_DEL_HOST_PROD_PRINT'] ?></td>
                                            <td><?php echo $sa['NP_PARA_1_DEL_HOST_PROD_PCT'] ?></td>
                                            <td><?php //echo $sa['NP_PARA_1_DEL_HOST_PROD_DIG_NR'] ?></td>
                                        </tr>
									 <?php } ?> 
									 <?php if ($sa['NP_PARA_1_TOTAL_ANP_PRINT']) { ?>
                                        <tr>
                                            <td class="lft">Total Analyzed Nonpaid</td>
                                            <td><?php echo $sa['NP_PARA_1_TOTAL_ANP_PRINT'] ?></td>
                                            <td><?php echo $sa['NP_PARA_1_TOTAL_ANP_PCT'] ?></td>
                                            <td><?php //echo $sa['NP_PARA_1_TOTAL_ANP_DIG_NR'] ?></td>
                                        </tr>
									 <?php } ?>  

									<?php /*}*/ ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flt-lft">
                            <div class="calculation-header">
                                <h5>ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER</h5> </div>
                            <div class="cntl-pring-content">
                                <p>Circulation by Regional, Metro & Demographic Editions</p>
                                <p>Geographic Data</p>
                                <p>Trend Analysis</p>
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
                        <div class="flt-lft">
                            <div class="calculation-header">
                                <h5>NOTES</h5> 
							</div>
							<!--
                            <div class="table-div">
                                <div class="note-div">
                                    <div class="col-md-10 p0">
                                        <p><strong>Average nonanalyzed nonpaid for period:</strong> 9,500</p>
                                        <p>* Special issue circulation not included in averages.</p>
                                        <p>(additional disclosures as required will also appear)</p>
                                    </div>
                                    <div class="col-md-2 p0 right-move">
                                        <button type="button" class=" glyphicon glyphicon-pencil pull-right ml3" data-target="#myModal"></button>
                                        <button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
                                    </div>
                                </div>
                            </div> 
                            -->
							<div class="table-div">
                               <?php require 'common/notes.php'; ?>	
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="flt-lft">
                            <div class="calculation-header">
                                <h5>TOTAL CIRCULATION BY ISSUE</h5> </div>
                            <div class="table-div">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="vbh" colspan="2">&nbsp;</th>
                                            <th>Print</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Issue</th>
                                            <th>Analyzed
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
											<td <?php if(isset($tcibold)) { ?> class="tb"
												<?php } ?> >&nbsp;&nbsp;
												<?php echo $row['NPC_SPECIAL_ISSUE'] ?>
											</td>
											<td <?php if(isset($tcibold)) { ?> class="tb"
												<?php } ?> >
												<?php echo $row['NPC_ISSUE_NAME'] ?>
											</td>
											<td <?php if(isset($tcibold)) { ?> class="tb"
												<?php } ?> >
												<?php echo $row['NPC_TOTAL_ANP_PRINT'] ?>
											</td>
									
										</tr>
										<?php
										}
										?>
							        </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flt-lft">
                            <div class="calculation-header">
                                <h5>DIGITAL NONREPLICA</h5> </div>
                            <div class="table-div">
                                <table>
                                    <thead>
                                        <tr>
                                            <th colspan="2">Issue</th>
                                            <th>Total
                                                <br> Analyzed Nonpaid
                                                <br> Circulation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td class="lft">July</td>
                                            <td>28,515</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="lft">Aug.</td>
                                            <td>28,432</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="lft">Sept.</td>
                                            <td>30,262</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="lft">Oct.</td>
                                            <td>30,215</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="lft">Nov./Dec.</td>
                                            <td>30,439</td>
                                        </tr>
                                        <tr class="fnt-bold">
                                            <td></td>
                                            <td class="lft">Average</td>
                                            <td>29,572</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flt-lft">
                            <div class="calculation-header">
                                <h5>VARIANCE OF LAST THREE RELEASED AUDIT REPORTS</h5> </div>
                            <div class="table-div">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Audit Period
                                                <br> Ended</th>
                                            <th>Rate Base</th>
                                            <th>Audit Report</th>
                                            <th>Publisher’s
                                                <br> Statements</th>
                                            <th>Difference</th>
                                            <th>Percentage
                                                <br> of Difference</th>
                                        </tr>
                                    </thead>
 								 <tbody>
									<?php 
									foreach ($variance as $row) {
								?>
									<tr>
										<td>
											<?php echo $row['DRIVE_DATE']; ?>
										</td>
										<td>
											<?php echo $row['RATE_BASE']; ?>
										</td>
										<td>
											<?php echo $row['AUDIT_REPORT']; ?>
										</td>
										<td>
											<?php echo $row['PUBLISHERS_STATEMENT']; ?>
										</td>
										<td>
											<?php echo $row['DIFFERENCE']; ?>
										</td>
										<td>
											<?php echo $row['PERCENTAGE_OF_DIFFERENCE']; ?>
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
                        <div class="flt-lft">
                            <div class="table-div">
                                <table class="table">
                                    <tbody>
                                        <tr>
											<td>
												<p class="taj pl4">We certify that to the best of our knowledge all data set forth in this publisher’s statement are true and report circulation in accordance with Alliance for Audited Media’s bylaws and rules. </p>
												<p class="taj pl4">Parent Company:
													<?php echo $certify['NP_PARENT_COMPANY'] ?>
												</p>
												<div class="container-fluid">
													<div class="row">
														<div class="col-md-6 col-sm-6">
															<p class="taj p0">NAME :
																<?php echo $certify['NP_PARA_12_NAME1'] ?>
															</p>
															<p class="taj p0">Director :
																<?php echo $certify['NP_PARA_12_TITLE1'] ?>
															</p>
															<p class="taj p0">Date Signed: </p>
															<p class="taj p0">
																<?php echo $certify['NP_P_F_URL'] ?>
															</p>
															<p class="taj p0">Established:
																<?php echo $certify['NP_ESTABLISHED'] ?>
															</p>
														</div>
														<div class="col-md-6 col-sm-6 ">
															<p class="taj p0">NAME :
																<?php echo $certify['NP_PARA_12_NAME2'] ?>
															</p>
															<p class="taj p0">Publisher
																<?php echo $certify['NP_PARA_12_TITLE2'] ?>
															</p>
															<p class="taj p0">Sales Offices:
																<?php //echo $certify['SALES_OFFICE'] ?>
															</p>
															<p class="taj p0">&nbsp;</p>
															<p class="taj p0">AAM Member since:
																<?php echo $certify['NP_MEM_SINCE'] ?>
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
            </div>
        </section>
    </div>
</body>

</html>
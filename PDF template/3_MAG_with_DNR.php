<?PHP
// Include the main TCPDF library 
require_once('../App.php');
require_once('../data/PdfManager.php');
require_once('../libraries/TCPDF/tcpdf_include.php');
require_once('../libraries/TCPDF/tcpdf.php');
$es = PdfManager::p_get_executive_summary($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');

	$variance = PdfManager::p_get_variance($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');
	/*
	 * @var $tci total circulation by issue
	 */
	$tci =  PdfManager::p_get_total_circulation_issue($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');
	
	/*
	 * @var $rb Rate Base Changes
	 */
	$rbc = PdfManager::p_get_ratebase_changes($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');

	$rb = PdfManager::p_get_rate_base($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');

	$prices = PdfManager::p_get_price_summary_layout($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');

	$lheader = PdfManager::p_get_header($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');

	$certify = PdfManager::p_get_certify($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');
	/* @var $sa supplymentory analysis*/
	$sa = PdfManager::p_get_supply_analysis($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');
	
	/*
	 * @var $aav Addtional Analysis verified
	 */
	$aav = PdfManager::p_get_additional_analysis($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');

	$cert = PdfManager::p_get_certify($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');
require_once('../common/commonData.php');

class MYPDF extends TCPDF {
    //Page Header
    public function Header() { 
        if ($this->page == 1) {
            
			
			// Procedure Call
            $respo = PdfManager::p_get_header($member = 405686, $ddate = '31-DEC-2016', $ptype = 'PS');
            // Procedure Call
            // Header Left Side
            $this->Text(15,5,"(3) Paid and Verified with Digital Nonreplica");
			$image_file = '../assets/images/logo.jpg'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,15,10,50);            
			 
            $this->SetFont('helvetica', 'B', 10);
            $this->Text(15,28,"Publisher's Statement");
            
            $this->SetFont('helvetica', '', 10);
            $this->Text(15,33,"6 months ended December 31, 2015, Subject to Audit");
			//$this->Cell(0, 0, "Publisher's Statement", 0, false, 'L', 0, '', 0, false, 'M', 'M');

			// Header Right Side
			$image_file = '../assets/images/ABA.png'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,160,10,50);
            
            //Annual Frequency
			 $AnuFre = $respo['FREQUENCY'];
            $this->SetFont('arial', 'B', 7);
            $this->Text(160,25,"Annual Frequency:".$AnuFre);
			
            //Field Served
            $Field = $respo['FIELD_SERVED'];
            $this->SetFont('arial', 'B', 7);
            $this->Text(160,30,"Field Served: ".$Field); 
			 $this->MultiCell(110,5,"".$Field,'','','','',177,30);
            
         //Published By
            $Publish = $respo['PUBLISHED_BY'];
            $this->SetFont('arial', '', 7);
            $this->Text(160,38,"Published By ".$Publish);
		} else {
			$this->SetMargins(10, 10, 10, true);
		}        
    }
    
    // Page footer
    public function Footer(){
        if($this->page == 1) {
        //position at 25mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 7);
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
        $this->Cell(0, 0, '48 W. Seegers Road lArlington Heights, IL 60005-3913 lT: 224-366-6939 lF: 224-366-6949 lwww.auditedmedia.com', 0, 0, 'C');
        
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
        else {
            //position at 25mm from bottom
            $this->SetY(-25);
            $this->SetFont('helvetica','', 7);
            // Page number
            $this->Cell(0, 10, '                 Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages().' .04-0000-0', 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $this->SetY(-20);
            //AAM
            $this->Cell(0, 10, 'Alliance for Audited Media', 0, false, 'C', 0, '', 0, false, 'T', 'M');
            $this->SetY(-15);
            //copyrights
            $this->Cell(0, 10, 'Copyright © 2015 All rights reserved.', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
        
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sathish Kumar');
$pdf->SetTitle('3mag_with_dnr');
$pdf->SetSubject('3mag_with_dnr');
$pdf->SetKeywords('PDF, 3mag_with_dnr');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 60, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
// $pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('arial', '', 8); 
// *** Very IMP: Please use times font, so that if you send this pdf file in gmail as attachment and if user
//opens it in google document, then all the text within the pdf would be visible properly.

// add a page
$pdf->AddPage('L', 'A4');

$pdf->Ln(-10);
//$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 0, 0)));
//$pdf->Ln(1.0);

$pdf->SetTextColor(0,0,0);
$empty_row = empty_row();
//First Page
//All table heading
$table_1_header = table_cell('EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');


$data = '';
foreach($es as $res) {
	$data .= '<tr>
                        <td width="20%" align="center">'. $res['PARA_1_PAID_VERIF_SUBS'].'</td>
                        <td width="20%" align="center">'. $res['PARA_1_SCS'].'</td>
                        <td width="20%" align="center">'. $res['PARA_1_TOTAL_ANP_CIRC'].'</td>
                        <td width="20%" align="center">'. $res['PARA_1_TOTL_RB'] .'</td>
                        <td width="20%" align="center">'. $res['PARA_1_TOTL_VARIANCE_RB'].'</td>
                    </tr>';	
}

$table_1 = $table_1_header.'<table width="100%" border="1">
                <thead>
                    <tr style="background-color: #bcd4ee;color:#1a1a1a; " >
                        <td width="20%" align="center">
                            <b>Total <br>Paid & Verified <br>Subscriptions</b>
                        </td>
                        <td width="20%" align="center">
                            <b><br>Single<br> CopySales</b>
                        </td>
                        <td width="20%" align="center">
                            <b><br>Total<br> Circulation</b>
                        </td>
                        <td width="20%" align="center">
                            <b><br>Rate<br> Base</b>
                        </td>
                        <td width="20%" align="center">
                            <b><br>Variance<br> to Rate Base</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    ' . $data . '
                </tbody>
            </table>';
$pdf->writeHTML($table_1, true, false, false, false, '');
$pdf->Ln(-1);

$table_2_header = table_cell_3('DIGITAL NONREPLICA','65');
$data = '';
foreach($es as $res) {
	$data .= '<tr align="center">
                       	<td class="tb">'. $res['PAR_1_DIGIT_NR_PD_VER_SUBS'].'</td>
						<td class="tb">'. $res['PARA_1_DIGIT_NON_REPL_SCS'].'</td>
						<td class="tb">'. $res['PARA_1_DIGIT_NON_REPL_TOTAL'].'</td>
                    </tr>';	
}

$table_2 = $table_2_header.'<table width="65%">
								<thead>
									<tr style="background-color: #bcd4ee;color:#1a1a1a; text-align:center; ">
										<th border="1"><b>Total<br>Paid & Verified<br> Subscriptions</b></th>
										<th border="1"><b><br>Single Copy<br>Sales</b></th>
										<th border="1"><b><br>Total<br>Circulation</b></th>
									</tr>
								</thead>
								<tbody>
									' . $data . '
								</tbody>
							</table>';
$pdf->writeHTML($table_2, true, false, false, false, '');
$pdf->Ln(10);
$table_3_header = table_cell('TOTAL CIRCULATION BY ISSUE');

if($tci){
$table_3_data = '';
$len = sizeof($tci);
for ($i=0; $i<=$len-1; $i++) {
 $res = $tci[$i];
    $table_3_data .= 
        '<tr align="center">
            <td border="1"  width="2%">'.$res['SPECIAL_ISSUE'].'</td>
            <td border="1"  width="8%">'.$res['ISSUE_NAME'].'</td>
            <td border="1"  width="15%">'.$res['PAID_SUBS_PRINT'].'</td>
            <td border="1"  width="15%">'.$res['VERIF_SUBS_PRINT'].'</td>
            <td border="1"  width="20%">'.$res['TOTAL_PAID_VERIF_SUBS'].'</td>
            <td border="1"  width="20%">'.$res['SCS_PRINT'].'</td>
            <td border="1"  width="20%">'.$res['TOTAL_PAID_VERIF_CIRC'].'</td>
        </tr>';
}
$table_3_data_avg = '';
for ($i=$len-1; $i<=$len-1; $i++) {
  $res = $tci[$i];
$table_3_data_avg .= 
        '<tr align="center">
            <td border="1"  width="2%">'.$res['SPECIAL_ISSUE'].'</td>
            <td border="1"  width="8%"><b>'.$res['ISSUE_NAME'].'</b></td>
            <td border="1"  width="15%"><b>'.$res['PAID_SUBS_PRINT'].'</b></td>
            <td border="1"  width="15%"><b>'.$res['VERIF_SUBS_PRINT'].'</b></td>
            <td border="1"  width="20%"><b>'.$res['TOTAL_PAID_VERIF_SUBS'].'</b></td>
            <td border="1"  width="20%"><b>'.$res['SCS_PRINT'].'</b></td>
            <td border="1"  width="20%"><b>'.$res['TOTAL_PAID_VERIF_CIRC'].'</b></td>
        </tr>';
}
$table_3 = $table_3_header.'<table width="100%" border="0">
							<thead>
								<tr>
									<th width="10%"></th>
									<th border="1"  width="90%" colspan="5" style="background-color: #bcd4ee;color:#1a1a1a; text-align:center; "><b>Print</b></th>
								</tr>
								<tr style="background-color: #bcd4ee;color:#1a1a1a; text-align:center; ">
									<th border="1"  width="10%" colspan="2"><b><br><br>Issue</b></th>
									<th border="1"  width="15%"><b><br>Paid<br>Subscriptions</b></th>
									<th border="1"  width="15%"><b><br>Verified<br>Subscriptions</b></th>
									<th border="1"  width="20%"><b>Total<br>Paid & Verified<br>Subscriptions</b></th>
									<th border="1"  width="20%"><b><br>Single Copy<br>Sales</b></th>
									<th border="1"  width="20%"><b>Total<br>Paid & Verified<br>Circulation</b></th>
								</tr>
							</thead>
							<tbody>
                                '.$table_3_data.'
								'.$table_3_data_avg.'  
							</tbody>
						</table>';
$pdf->writeHTML($table_3, true, false, false, false, '');
}

$table_4_header = table_cell('DIGITAL NONREPLICA');
if($tci){
$table_4_data = '';
$len = sizeof($tci);
for ($i=0; $i<=$len-1; $i++) {
 $res = $tci[$i];
    $table_4_data .= '<tr align="center">
            <td border="1"  width="2%">'.$res['SPECIAL_ISSUE'].'</td>
            <td border="1"  width="8%">'.$res['ISSUE_NAME'].'</td>
            <td border="1"  width="15%">'.$res['PAID_SUBS_DIG_NR'].'</td>
            <td border="1"  width="15%">'.$res['VERIF_SUBS_DIG_NR'].'</td>
            <td border="1"  width="20%">'.$res['TOTAL_PAID_VERIF_SUBS_DIG_NR'].'</td>
            <td border="1"  width="20%">'.$res['SCS_DIG_NR'].'</td>
            <td border="1"  width="20%">'.$res['TOTAL_PAID_VERIF_CIRC_DIG_NR'].'</td>
        </tr>';
}
$table_4_data_avg = '';
for ($i=$len-1; $i<=$len-1; $i++) {
  $res = $tci[$i];
$table_4_data_avg .= '<tr align="center">
            <td border="1"  width="2%">'.$res['SPECIAL_ISSUE'].'</td>
            <td border="1"  width="8%"><b>'.$res['ISSUE_NAME'].'</b></td>
            <td border="1"  width="15%"><b>'.$res['PAID_SUBS_DIG_NR'].'</b></td>
            <td border="1"  width="15%"><b>'.$res['VERIF_SUBS_DIG_NR'].'</b></td>
            <td border="1"  width="20%"><b>'.$res['TOTAL_PAID_VERIF_SUBS_DIG_NR'].'</b></td>
            <td border="1"  width="20%"><b>'.$res['SCS_DIG_NR'].'</b></td>
            <td border="1"  width="20%"><b>'.$res['TOTAL_PAID_VERIF_CIRC_DIG_NR'].'</b></td>
        </tr>';
}
$table_4 = $table_4_header.'<table width="100%" border="0">
							<thead>
								<tr>
									<th width="10%"></th>
									<th border="1"  width="90%" colspan="5" style="background-color: #bcd4ee;color:#1a1a1a; text-align:center; ">Print</th>
								</tr>
								<tr style="background-color: #bcd4ee;color:#1a1a1a; text-align:center; ">
									<th border="1"  width="10%" colspan="2"><b><br><br>Issue</b></th>
									<th border="1"  width="15%"><b><br>Paid<br>Subscriptions</b></th>
									<th border="1"  width="15%"><b><br>Verified<br>Subscriptions</b></th>
									<th border="1"  width="20%"><b>Total<br>Paid & Verified<br>Subscriptions</b></th>
									<th border="1"  width="20%"><b><br>Single Copy<br>Sales</b></th>
									<th border="1"  width="20%"><b>Total<br>Paid & Verified<br>Circulation</b></th>
								</tr>
							</thead>
							<tbody>
                                '.$table_4_data.'
								'.$table_4_data_avg.'
							</tbody>
						</table>';
$pdf->writeHTML($table_4, true, false, false, false, '');
}


//SECOND PAGE STARTS HERE
$pdf->AddPage('L', 'A4');
//SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION
$table_3_header = table_cell('SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION');
$table_4_header = table_cell('VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$table_5_header = table_cell('PRICES');
$site_1 = p_line('Visit www.auditedmedia.com Media Intelligence Center for audit reports');
$site_2_1 = p_line('(1) For statement period');
$site_2_2 = p_line('(2) Represents subscriptions for the 12 month period ended June 30, 2015');
$site_2_3 = p_line('(3) Based on the following issue per year frequency: 10');
$empty_row = empty_row();

$paidSubscriptions = '';
if ($psdata) {
	$paidSubscriptions = '<tr>
                <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Paid Subscriptions</b></td>
            </tr>';
	
	if ($sa['PARA_6_PD_INDV_SUBS_PRINT']) {
		$paidSubscriptions .= commonSAData('Individual Subscriptions', $sa['PARA_6_PD_INDV_SUBS_PRINT'], $sa['PARA_6_PD_INDV_SUBS_PRINT']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT']) {
		$paidSubscriptions .= commonSAData('Association: Deductible', $sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT']) {
		$paidSubscriptions .= commonSAData('Association: Nondeductible', $sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT']);
	}
	if ($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Deductible', $sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'], $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT']);
	}
	if ($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Nondeductible', $sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'], $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT']);
	}
	if ($sa['PARA_6_PD_DEFER_SUBS_PRINT']) {
		$paidSubscriptions .= commonSAData('Deferred', $sa['PARA_6_PD_DEFER_SUBS_PRINT'], $sa['PARA_6_PD_DEFER_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT']) {
		$paidSubscriptions .= commonSAData('Partnership Deductible Subscriptions', $sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'], $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT']);
	}
	if ($sa['PARA_6_PD_SCHOOL_PRINT']) {
		$paidSubscriptions .= commonSAData('School', $sa['PARA_6_PD_SCHOOL_PRINT'], $sa['PARA_6_PD_SCHOOL_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_SPONS_SALES_PRINT']) {
		$paidSubscriptions .= commonSAData('Sponsored Subscriptions', $sa['PARA_6_PD_SPONS_SALES_PRINT'], $sa['PARA_6_PD_SPONS_SALES_PCT']);
	}
	if ($sa['PARA_6_TOTAL_PAID_SUBS_PRINT']) {
		$paidSubscriptions .= commonSAData('Total Paid Subscriptions', $sa['PARA_6_TOTAL_PAID_SUBS_PRINT'], $sa['PARA_6_TOTAL_PAID_SUBS_PCT'], true);
	}
}


if ($vsdata) {
	$paidSubscriptions .= '<tr>
                <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Verified Subscriptions</b></td>
            </tr>';
	if ($sa['PARA_6_VERIF_SUBS_PP_PRINT']) {
		$paidSubscriptions .= commonSAData('Public Place', $sa['PARA_6_VERIF_SUBS_PP_PRINT'],$sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT']);
	}
	if ($sa['PARA_6_VERIF_SUBS_IU_PRINT']) {
		$paidSubscriptions .= commonSAData('Individual Use', $sa['PARA_6_VERIF_SUBS_IU_PRINT'], $sa['PARA_6_VERIF_SUBS_IND_USE_PCT']);
	}
	if ($sa['PARA_6_TOT_VERIF_SUBS_PRINT']) {
		$paidSubscriptions .= commonSAData('Total Verified Subscriptions', $sa['PARA_6_TOT_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_VERIF_SUBS_PCT'],true);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT']) {
		$paidSubscriptions .= commonSAData('Total Paid & Verified Subscrptions', $sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'], true);
	}
}

if ($scsdata) {
	$paidSubscriptions .= '<tr>
               <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Single Copy Sales</b></td>
            </tr>';
	if ($sa['PARA_6_SCS_PRINT']) {
		$paidSubscriptions .= commonSAData('Single Issue', $sa['PARA_6_SCS_PRINT'], $sa['PARA_6_SINGLE_ISSUE_SALES_PCT']);
	}
	if ($sa['PARA_6_SCS_PARTNER_DED_PRINT']) {
		$paidSubscriptions .= commonSAData('Partnership Deductible Single Issue', $sa['PARA_6_SCS_PARTNER_DED_PRINT'], $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT']);
	}
	if ($sa['PARA_6_SCS_SPONS_SALES_PRINT']) {
		$paidSubscriptions .= commonSAData('Sponsored Single Issue', $sa['PARA_6_SCS_SPONS_SALES_PRINT'], $sa['PARA_6_SCS_SPONS_SALES_PCT']);
	}
	if ($sa['PARA_6_TOTAL_SCS_PRINT']) {
		$paidSubscriptions .= commonSAData('Total Single Copy Sales', $sa['PARA_6_TOTAL_SCS_PRINT'], $sa['PARA_6_TOTAL_SCS_PCT'],true);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT']) {
		$paidSubscriptions .= commonSAData('Total Paid & Verified Circulation', $sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'], true);
	}
}

/* table 3*/

$varianceData = '';
foreach ($variance as $row) {
	$varianceData .= '<tr>
						<td align="center">' . $row['DRIVE_DATE'] . '</td>
						<td align="center">' . $row['RATE_BASE'] . '</td>
						<td align="center">' . $row['AUDIT_REPORT'] . '</td>
						<td align="center">' . $row['PUBLISHERS_STATEMENT'] . '</td>
						<td align="center">' . $row['DIFFERENCE'] . '</td>
						<td align="center">' . $row['PERCENTAGE_OF_DIFFERENCE'] . '</td>
					</tr>';
}
$variancetable = '<table width="100%" border="1">
                <tr style="background-color: #bcd4ee;color:#1a1a1a;">
                    <td align="center"><b>Audit Period<br> Ended</b></td>
                    <td align="center"><b><br>Rate Base</b></td>
                    <td align="center"><b><br>Audit Report</b></td>
                    <td align="center"><b>Publisher’s <br>Statements</b></td>
                    <td align="center"><b><br>Difference</b></td>
                    <td align="center"><b>Percentage<br>of Difference</b></td>
                </tr> ' . $varianceData . ' </table>';
/* Prices datas **/
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

$pricesData = '<tr>
					<td width="50%" align="left" border="1"> Average Single Copy</td>
					<td width="17%" border="1">' . $asc . '</td>
					<td width="17%" rowspan="2" border="1"></td>
					<td width="16%" rowspan="2" border="1"></td>
				</tr>
				<tr>
					<td width="50%" align="left" border="1"> Subscription</td>
					<td width="17%" border="1">' . $subscription . '</td>

				</tr>
				<tr>
					<td width="50%" align="left" border="1"> Average Subscription Price Annualized (3) </td>
					<td width="17%" rowspan="2" border="1"></td>
					<td width="17%" border="1">' . $aspa1net . '</td>
					<td width="16%" border="1">' . $aspa2gross . '</td>
				</tr>
				<tr>
					<td width="50%" align="left" border="1"> Average Subscription Price per Copy</td>
					<td width="17%" border="1">' . $aspa2net . '</td>
					<td width="16%" border="1">' . $asc . '</td>
				</tr>';
$pricestable = '<table width="100%" border="0" style="text-align:center">
                <thead>
                    <tr>
                        <td width="50%" rowspan="2" border="none"></td>
                        <td width="17%" rowspan="2" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b><br>Suggested <br> Retail Prices (1)</b></td>
                        <td width="33%" colspan="2" style="background-color: #bcd4ee;color:#1a1a1a;" border="1">
                            <b>Average Price(2)</b>
                        </td>
                    </tr>
                    <tr>
                        <td width="17%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b><br>Net</b></td>
                        <td width="16%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1">
                            <b>Gross <br> (Optional)</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    ' . $pricesData . '
                </tbody>
            </table>
            <table>
                <tr><td></td></tr>
            </table>';

$main_left = $table_3_header.
    '<table width="100%" border="0" style="text-align:center; color:#1a1a1a;">
        <thead>
            <tr>
                <td width="40%"  border="none"></td>
                <td width="20%" style="background-color:#bcd4ee;color:#1a1a1a;" border="1">Print</td>
                <td width="20%" style="background-color:#bcd4ee;color:#1a1a1a;" border="1">% of Circulation</td>
				 <td width="20%" style="background-color:#bcd4ee;color:#1a1a1a;" border="1">Digital Nonreplica</td>
            </tr>
        </thead>
            <tbody>
                ' . $paidSubscriptions . '                                    
            </tbody>
    </table>'; 
$main_right = '<table width="100%">
                    <tr>
                        <td >
                            ' . $table_4_header . '
                            ' . $variancetable . '
                            <br><br>  Visit www.auditedmedia.com Media Intelligence Center for audit reports<br><br>
                        </td>
                    </tr>
                    '.$empty_row.'
                    '.$empty_row.'
                    <tr>
                        <td>
                            '.$table_5_header.'
                            '.$pricestable.'
                            <br><br>  (1) For statement period<br>
                            (2) Represents subscriptions for the 12 month period ended June 30, 2015<br>
                            (3) Based on the following issue per year frequency: 10<br>
                            
                        </td>
                    </tr>
            </table>';

// $main includes tables 3, 4 & 5
$main = <<<EOD
    <table width="100%" border="0" cellpadding="0" nobr="true">
                    <tr>
                        <td width="49%">
                            $main_left
                        </td>
                         <td width="1%"></td>
                        <td width="50%">
                            $main_right
                        </td>
                    </tr>
            </table>
EOD;

$pdf->writeHTML($main, true, false, false, false, '');



/* additional table title */
$table_6_header = table_cell('ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER');
$table_7_header = table_cell('ADDITIONAL ANALYSIS OF VERIFIED');
$table_8_header = table_cell('RATE BASE');


/* additional table title */

$add_inside_table_public = '';

if ($paav) {
	$add_inside_table_public = '<tr>
		<td colspan="2" style="background-color: #bcd4ee;color:#1a1a1a;" border="1">
		<b> Public Place</b></td>
        </tr>';
	$count = count($paav);
	$i = 0;
	foreach ($paav as $row) {
		if(++$i === $count) {
			$paavbold = true;
			$row['DESCRIPTION'] = '<b>' . $row['DESCRIPTION'] . '</b>';
		} 
		$add_inside_table_public .= '<tr>
            <td width="70%" border="1">' . $row['DESCRIPTION'] . '</td>
            <td width="30%" align="center" border="1">' . $row['MAVS_VERIF_SUBS_PRINT'] . '</td>
        </tr>';
	}
}

$add_inside_table_individual = '';

if ($iaav) {
	$add_inside_table_individual = '<tr>
		<td colspan="2" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b>Individual Use</b></td>
	</tr>';
	$count = count($iaav);
	$i = 0;
	foreach ($iaav as $row) {
		if(++$i === $count) {
			$paavbold = true;
			$row['DESCRIPTION'] = '<b>' . $row['DESCRIPTION'] . '</b>';
		} 
		$add_inside_table_individual .= '<tr>
            <td width="70%" border="1">' . $row['DESCRIPTION'] . '</td>
            <td width="30%" align="center" border="1">' . $row['MAVS_VERIF_SUBS_PRINT'] . '</td>
        </tr>';
	}
}

$table_6 = 
    '<table width="100%" align="left" border="0">
        <tr>
            <td>Circulation by Regional, Metro & Demographic Editions</td>
		</tr>
        <tr>
            <td>Analysis of New & Renewal Paid Individual Subscriptions</td>
        </tr>
        <tr>
            <td>Trend Analysis.</td>
        </tr>
    </table>';
$aavtable = 
    '<table width="50%" border="0">
        <tr>
            <td width="70%" border="none"></td>
            <td width="30%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b> Print </b></td>
        </tr>      
            ' . $add_inside_table_public . ' '.$add_inside_table_individual.'
    </table>';

/* rate base */
$ratebasechange = '';
if ($rbca) {
	$ratebasechange = '<tr>
            <td>Rate Base Change(s):</td>
        </tr>';
	foreach ($rbca as $row) {
		$ratebasechange .= '<tr>
            <td>' . $row['start_rb'] . ' through ' . $row['start_date'] . ', ' . $row['end_rb'] . ' starting ' . $row['end_date'] . '</td>
        </tr>';
	}
}

$ratebasenotes = '';
if ($rbnotes) {
	$ratebasenotes = '<tr>
            <td>Rate Base Notes: ' . $rbnotes . '</td>
		</tr>';
}
$ratebasetable =
    '<table width="100%" align="left" border="0">
        <tr>
            <td>' . $pvctext . '.</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        ' . $ratebasechange . '
        <tr>
            <td></td>
		</tr>' . $ratebasenotes . '                
    </table>';
$additional = '<table width="100%" nobr="true">

                    <tr>
                        <td>
                        '.$table_7_header.'
                        '.$aavtable.'
                        </td>
                    </tr>
					<br><br>
					<tr>
                        <td>'.$table_6_header.'
                        '.$table_6.'
                        </td>
                    </tr>
                        
                    <br><br>
                    <tr style="background-color: #fff;color:#1a1a1a;">
                        <td>
                        ' . $table_8_header . '
                        ' . $ratebasetable . '    
                        </td>
                    </tr>
                </table>';

$table_9_header = table_cell('NOTES');
$table_10_header = '';
$table_9 = '
        <table width="100%" align="left" border="0">
        <tr>
            <td><b>Award Point Subscriptions:</b>Included in Paid Subscriptions Individual is the following average number of copies purchased through the redemption of award points: 10, 450</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td><b>Combination Subscriptions:</b> Included in Paid Subscriptions Individual are copies served to subscribers who purchased this publication in combination with one or more different publications.</td>
        </tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td><b>Partnership Deductible:</b> These copies shown in Supplemental Analysis of Average Circulation represent copies served where the subscription was included in purchases of other products or services. The consumer could receive a rebate instead of the subscription.</td>
        </tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td><b>Sponsored Subscriptions:</b> These copies shown in Supplemental Analysis of Average Circulation represent copies
        purchased by a third party in quantities of 11 or more for distribution to consumers.</td>
        </tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td>Rate Base Notes: Rate base including feature/special issues: 915,000. Feature issues with higher rate bases: 9/29 rate base 900,000; 12/1 rate base 925,000; 12/22 rate base 950,000. Special issues with higher rate bases: Gorgeous at Any Age rate base 950,000.</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td><b>Association: Deductible:</b> These copies shown in Paid Subscriptions represent copies served where the subscription
        was included in the dues of an association. The subscription was deductible from dues.</td>
        </tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td><b>Post Expiration Copies:</b> Included in Paid Subscriptions is the following average number of copies served to
        subscribers post expiration pending renewal: 3,700</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td><b>Pursuant to a review by the AAM Board of Directors,</b> copies distributed through the Next Issue Media Unlimited
        program are reported as single copy sales based on consumer payment for the program and consumer’s request
        for a specific magazine. Included in Single Copy Sales Digital is the following average copies per issue from this program: 1,500</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td><strong>Average nonanalyzed nonpaid for period:</strong> 9,500</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td>* Special issue circulation not included in averages.</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
        <td><strong>(additional disclosures as required will also appear)</strong></td>
        </tr>
        
    </table>';

$table_10 = '<table width="90%" style="border: 1px solid black">
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" style="margin-left:1px;">   We certify that to the best of our knowledge all data set forth in this publisher’s statement are true and report circulation in accordance with Alliance for Audited Media’s bylaws and rules.</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">  Parent Company:</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">  PUB NAME, published by Publisher Address City, ST ZIP</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>  
        <tr>
            <td>  Name ' . $certify['PARA_12_NAME1'] . '</td>
            <td>  Name ' . $certify['PARA_12_NAME2'] . ' </td>
        </tr> 
        <tr>
            <td>  Director ' . $certify['PARA_12_TITLE1'] . '</td>
            <td>  Publisher ' . $certify['PARA_12_TITLE2'] . '</td>
        </tr>
        <tr>
            <td>  Date Signed:</td>
            <td>  Sales Offices: ' . $certify['PARA_12_TITLE2'] . '</td>
        </tr>
        <tr>            
            <td> ' . $certify['PHON_FAX_URL'] . '</td>
            <td></td>
        </tr>
        <tr>            
            <td>  Established: ' . $certify['ESTABLISHED'] . '</td>
            <td>  AAM Member since: ' . $certify['MEM_SINCE'] . '</td>
        </tr>    
        <tr>
            <td></td>
        </tr>
    </table>';

$notes_table = '<table width="100%" nobr="true">
                    <tr>
                        <td>
                        '.$table_9_header.'
                        '.$table_9.'                
                        </td>
                    </tr>        
                    <tr>
                        <td width="1%"></td>
                        <td width="99%">
                        '.$table_10_header.'
                        '.$table_10.'
                        </td>
                    </tr>
                    </table>';
$table = <<<EOD
    <table width="100%" border="0">
                    <tr>
                        <td width="49%">
                            $additional
                        </td>
                        <td width="1%"></td>
                        <td width="50%">
                            $notes_table
                        </td>
                    </tr>
            </table>
EOD;
 $pdf->writeHTML($table, true, false, false, false, '');
//FUNCTIONS
//Table header function
function table_cell($title){
    $td = '<table width="100%"><tr><td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>' .$title.'</b></td></tr><tr style="line-height: 30%;"><td></td></tr></table>';
    return $td;
}
//Table header with small size
function table_cell_2($title){
    $td = '<table width="100%"><tr><td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>' .$title.'</b></td></tr><tr style="line-height: 30%;"><td></td></tr></table>';
    return $td;
}
//Table header with specified width
function table_cell_3($title,$size){
    $td = '<table width="'.$size.'%"><tr><td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>' .$title.'</b></td></tr><tr style="line-height: 30%;"><td></td></tr></table>';
    return $td;
}

function p_line($line){
    $td = '<table width="100%"><tr><td style="color:#1a1a1a; background-color:#fff">'.$line.'</td></tr></table>';
    return $td;
}
function empty_row(){
    $tr='<tr><td></td></tr>';
    return $tr;
}

function commonSAData($title, $print, $circ, $bold = false) {
	if ($bold) {
		$title = '<b>' . $title . '</b>';
	}
	return '<tr>
		<td width="50%" border="1">' . $title . '</td>
		<td width="25%" border="1">' . $print . '</td>
		<td width="25%" border="1">' . $circ . '</td>
	</tr>';
	
}
$pdf->lastPage();
// ---------------------------------------------------------

//Close and output PDF document
/*$pdf_file_name = 'custom_header_footer.pdf';
$pdf->Output($pdf_file_name, 'I');*/
/**
$rand = rand(0,999999);
$filename= "{$rand}.pdf"; 
$filelocation = "C:\\wamp\\www\\test1\\ramu_uploads";

$fileNL = $filelocation."\\".$filename;
echo $fileNL;*/
$pdf->Output('hhhhhh.pdf','I');



//============================================================+
// END OF FILE                                                
//============================================================+

?>
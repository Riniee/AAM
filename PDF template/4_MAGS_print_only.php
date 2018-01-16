<?php
require_once('../App.php');
require_once('../data/PdfManager.php');
require_once('../libraries/TCPDF/tcpdf_include.php');
require_once('../libraries/TCPDF/tcpdf.php');

/* Card Details */

$card['MEMBER_NUMBER'] = $_GET['member_no']; 
$card['DRIVE_DATE'] = $_GET['drive_date'];
$card['PRODUCT_TYPE'] = $_GET['product_type'];

/* Card Details */

// Procedure Calls to Oracle Database Stored Procedure

$head = PdfManager::p_get_header($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$es = PdfManager::p_get_executive_summary($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$tci = PdfManager::p_get_total_circulation_issue($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$price = PdfManager::p_get_price_summary_layout($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$variance = PdfManager::p_get_variance($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$aa = PdfManager::p_get_additional_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);

$rb = PdfManager::p_get_rate_base($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$rbc = PdfManager::p_get_ratebase_changes($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$certify = PdfManager::p_get_certify($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$aav = []; // Empty Additional Analysis 
$sa = []; // Empty Supplement Analysis

// Procedure Calls to Oracle Database Stored Procedure

require_once('../common/commonData.php');
class MYPDF extends TCPDF {
    
    public function Header() { 
        if ($this->page == 1) {
            
             global $head;
            
            // Header Left Side
            $this->Text(15,5,"(4) Paid, Verified, Analyzed Nonpaid - Print Only");
			$image_file = '../assets/images/logo.jpg'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,15,10,50);            
			 
            $this->SetFont('arialnarrow', 'B', 10);
            $this->Text(15,28,"Publisher's Statement");
            
            $this->SetFont('arialnarrow', '', 10);
            $this->Text(15,33,"6 months ended December 31, 2015, Subject to Audit");

			// Header Right Side
			$image_file = '../assets/images/ABA.png'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,160,10,50);
            
            //Annual Frequency
            $this->SetFont('arialnarrow', 'B', 7);
            $this->Text(160,25,"Annual Frequency: ");
            
            //Anu Frequency Value
            $AnuFre = $head['FREQUENCY'];
            $this->SetFont('helvetica', '', 7);
            $this->Text(183,25,"".$AnuFre);
            
            //Field Served
            $this->SetFont('arialnarrowb', 'B', 7);
            $this->Text(160,30,"Field Served: ");
            
            //Field Served Value
            $Field = $head['FIELD_SERVED'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(177,30,"".$Field);
            
            //Published By
            $Publish = $head['PUBLISHED_BY'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(160,35,"Published by ".$Publish);
			
		} else {
			$this->SetMargins(10, 10, 10, true);
		}        
    }
    
    // Page footer
    public function Footer(){
        
        if($this->page == 1) {
        //position at  from bottom
        $this->SetY(-12);
            
        // Set font
        $this->SetFont('arialnarrow', 'I', 6.75);
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
            
        $this->Cell(0, 0, '151 Bloor Street West, Suite 850 lToronto, ON M5S 1S4 lT: 416-962-5840 lF: 416-962-5844 lwww.auditedmedia.ca', 0, 0, 'C');
        }
        else {
            //position at 25mm from bottom
            $this->SetY(-25);
            $this->SetFont('arialnarrow','I', 6.75);
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
$pdf->SetTitle('4mags_print_only');
$pdf->SetSubject('4mags_print_only');
$pdf->SetKeywords('PDF, 4mags_print_only');

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
$pdf->SetFont('arialnarrow', '', 6.6); 

// add a page
$pdf->AddPage('L', 'A4');

$pdf->Ln(-20);

// -----------------Table Properties -----------------------------------------------------------------------------

/* Setting up the Title */

$table_1_header = table_cell('  EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$table_2_header = table_cell('  TOTAL CIRCULATION BY ISSUE');
$table_3_header = table_cell_3(' SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION','97');
$table_4_header = table_cell(' VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$table_5_header = table_cell(' PRICES');
$table_6_header = table_cell_with_percentage(' ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER ','97');
$table_7_header = table_cell_with_percentage(' ADDITIONAL ANALYSIS OF VERIFIED ','98');
$table_8_header = table_cell_with_percentage(' RATE BASE ','98');
$table_9_header = table_cell('NOTES');
$table_10_header = '';

/* Setting up the Title */

/* Styling up the Title */

function table_cell($title){
    $td = '
    <table width="100%">
        <tr>
            <td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>' .$title.'</b></td>
        </tr>
        <tr style="line-height: 30%;">
            <td></td>
        </tr>
    </table>';
    return $td;
}
//Table header with small size
function table_cell_2($title){
    $td = '
    <table width="100%">
        <tr>
            <td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>' .$title.'</b></td>
        </tr>
        <tr style="line-height: 30%;">
            <td></td>
        </tr>
    </table>';
    return $td;
}
//Table header with specified width
function table_cell_with_percentage($title,$size){
    $td = '
    <table width="'.$size.'%">
        <tr>
            <td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>' .$title.'</b></td>
        </tr>
        <tr style="line-height: 30%;">
            <td></td>
        </tr>
    </table>';
    return $td;
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

function empty_row(){
    $tr='<tr><td></td></tr>';
    return $tr;
}

/* Styling up the Title */

// Table Properties -----------------------------------------------------------------------------

// ---------------------- pAGE 1 START---------------------------------------------------------------------------
    
//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

if($es) {
    $data = '';
    foreach($es as $res) {
        $data .= '
        <tr>
            <td align="center">'. number_format($res['PARA_1_PAID_VERIF_SUBS']) .'</td>
            <td align="center">'. number_format($res['PARA_1_SCS']) .'</td>
            <td align="center">'. number_format($res['PARA_1_PAID_VERIF_CIRC']) .'</td>
            <td align="center">'. number_format($res['PARA_1_TOTAL_ANP_CIRC']) .'</td>
            <td align="center">'. number_format($res['PARA_1_PAID_VERIF_ANP_CIRC']) .'</td>
            <td align="center">'. number_format($res['PARA_1_TOTL_RB']) .'</td>
            <td align="center">'. number_format($res['PARA_1_TOTL_VARIANCE_RB']) .'</td>
        </tr>';	
    }
}
$Executive_Summary = 
    $table_1_header.'<table width="100%" border="1">
          <thead>
            <tr style="background-color:#bcd4ee;" >
                <td align="center"><b>Total <br>Paid & Verified <br>Subscriptions</b></td>
                <td align="center"><br><br><b>Single Copy<br>Sales</b></td>
                <td align="center"><br><b>Total<br>Paid & Verified<br>Circulation</b></td>
                <td align="center"><br><br><b>Analyzed<br>Nonpaid</b></td>
                <td align="center"><br><br><b>Total<br> Circulation</b></td>
                <td align="center"><br><br><b>Rate Base</b></td>
                <td align="center"><br><br><b>Variance<br> to Rate Base</b></td>
            </tr>
          </thead>
          <tbody>
            ' . $data . '
          </tbody>
    </table>';
$pdf->Ln(-1);
//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------------

//------- TOTAL CIRCULATION BY ISSUE --------------------------------------------------------------------------------
if($tci) {

    $len = sizeof($tci);
    $data='';
    for ($i=0; $i<$len-1; $i++) {
        $res = $tci[$i];
        $data .= '<tr>
                    <td border="1"  width="1.5%" align="center">' . number_format($res['SPECIAL_ISSUE']) . ' </td>
                    <td border="1"  width="11%" align="center">' . $res['ISSUE_NAME'] . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['PAID_SUBS_PRINT']) . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['VERIF_SUBS_PRINT']) . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['TOTAL_PAID_VERIF_SUBS']) . '</td>
                    <td border="1"  width="12.5%" align="center">' . $res['SCS_PRINT'] . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['TOTAL_PAID_VERIF_CIRC']) . '</td>  
                    <td border="1"  width="12.5%" align="center">' . number_format($res['ANP_PRINT']) . '</td>  
                    <td border="1"  width="12.5%" align="center">' . number_format($res['TOTAL_PAID_VERIF_ANP_CIRC']) . '</td>  
                </tr>';
    }

    $avg = '';
        for ($i=$len-1; $i<=$len-1; $i++) {
            $res = $tci[$i];
            $avg .= '<tr style="font-weight:bold;">
                        <td border="1"  width="1.5%" align="center">' . $res['SPECIAL_ISSUE'] . ' </td>
                    <td border="1"  width="11%" align="center">' . $res['ISSUE_NAME'] . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['PAID_SUBS_PRINT']) . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['VERIF_SUBS_PRINT']) . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['TOTAL_PAID_VERIF_SUBS']) . '</td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['SCS_PRINT']) . ' </td>
                    <td border="1"  width="12.5%" align="center">' . number_format($res['TOTAL_PAID_VERIF_CIRC']) . '</td>  
                    <td border="1"  width="12.5%" align="center">' . number_format($res['ANP_PRINT']) . '</td>  
                    <td border="1"  width="12.5%" align="center">' . number_format($res['TOTAL_PAID_VERIF_ANP_CIRC']) . '</td>  
                </tr>';
        }
}
$Total_Circulation = $table_2_header.'<table width="100%" border="0">
                <thead>
                <tr>
                    <td width="12.5%"></td>
                    <td border="1"  width="87.5%" style="background-color: #bcd4ee;color:#1a1a1a;" align="center"><b>Print</b></td>
                </tr>
                <tr style="background-color: #bcd4ee;color:#1a1a1a;">
                    <td border="1"  width="12.5%" align="center" colspan="2"><b><br><br>Issue</b></td>
                    <td border="1"  width="12.5%" align="center"><b><br>Paid<br> Subscriptions</b></td>
                    <td border="1"  width="12.5%" align="center"><b><br>Verified<br> Subscriptions</b></td>
                    <td border="1"  width="12.5%" align="center"><b>Total <br>Paid & Verified<br> Subscriptions</b></td>
                    <td border="1"  width="12.5%" align="center"><b><br>Single Copy<br> Sales</b></td>
                    <td border="1"  width="12.5%" align="center"><b>Total<br> Paid & Verified<br> Circulation</b></td>
                    <td border="1"  width="12.5%" align="center"><b><br>Analyzed <br> Nonpaid</b></td>
                    <td border="1"  width="12.5%" align="center"><b>Total Paid, Verified & <br> Analyzed Nonpaid <br> Circulation</b></td>
                </tr>
                <thead>
                <tbody>
                '.$data.'
                '.$avg.'
                </tbody>
            </table>';
$tbl = '<table border="0" width="100%">
            <tr>
                <td >'.$Executive_Summary.'</td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td >'.$Total_Circulation.'</td>
            </tr>
         </table>';
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Ln(-1);
//------- TOTAL CIRCULATION--------------------------------------------------------------------------

//------- SUPPLEMENTAL ANALYSIS --------------------------------------------------------------------------------         

$paidSubscriptions = '';
$verified = '';
$single = '';
$analyzed = '';
if ($sa) {
    //Paid Subs
	
	if($sa['PARA_6_PD_INDV_SUBS_PRINT']  || $sa['PARA_6_PD_INDIV_SUBS_PCT']) {
		$paidSubscriptions .= commonSAData('Individual Subscriptions', $sa['PARA_6_PD_INDV_SUBS_PRINT'], $sa['PARA_6_PD_INDV_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT']) {
		$paidSubscriptions .= commonSAData('Association: Deductible', $sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT']) {
		$paidSubscriptions .= commonSAData('Association: Nondeductible', $sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT']);
	}
	if ($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Deductible', $sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'], $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT']);
	}
	if ($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Nondeductible', $sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'], $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT']);
	}
	if ($sa['PARA_6_PD_DEFER_SUBS_PRINT'] || $sa['PARA_6_PD_DEFER_SUBS_PCT']) {
		$paidSubscriptions .= commonSAData('Deferred', $sa['PARA_6_PD_DEFER_SUBS_PRINT'], $sa['PARA_6_PD_DEFER_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] || $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT']) {
		$paidSubscriptions .= commonSAData('Partnership Deductible Subscriptions', $sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'], $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT']);
	}
	if ($sa['PARA_6_PD_SCHOOL_PRINT'] || $sa['PARA_6_PD_SCHOOL_SUBS_PCT']) {
		$paidSubscriptions .= commonSAData('School', $sa['PARA_6_PD_SCHOOL_PRINT'], $sa['PARA_6_PD_SCHOOL_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_SPONS_SALES_PRINT'] || $sa['PARA_6_PD_SPONS_SALES_PCT']) {
		$paidSubscriptions .= commonSAData('Sponsored Subscriptions', $sa['PARA_6_PD_SPONS_SALES_PRINT'], $sa['PARA_6_PD_SPONS_SALES_PCT']);
	}
	if ($sa['PARA_6_TOTAL_PAID_SUBS_PRINT'] || $sa['PARA_6_TOTAL_PAID_SUBS_PCT']) {
		$paidSubscriptions .= commonSAData('Total Paid Subscriptions', $sa['PARA_6_TOTAL_PAID_SUBS_PRINT'], $sa['PARA_6_TOTAL_PAID_SUBS_PCT'], true);
	}
//Verified
	
	if ($sa['PARA_6_VERIF_SUBS_PP_PRINT'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT']) {
		$verified .= commonSAData('Public Place', $sa['PARA_6_VERIF_SUBS_PP_PRINT'],$sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT']);
	}
	if ($sa['PARA_6_VERIF_SUBS_IU_PRINT'] || $sa['PARA_6_VERIF_SUBS_IND_USE_PCT']) {
		$verified .= commonSAData('Individual Use', $sa['PARA_6_VERIF_SUBS_IU_PRINT'], $sa['PARA_6_VERIF_SUBS_IND_USE_PCT']);
	}
	if ($sa['PARA_6_TOT_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOTAL_VERIF_SUBS_PCT']) {
		$verified .= commonSAData('Total Verified Subscriptions', $sa['PARA_6_TOT_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_VERIF_SUBS_PCT']);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT']) {
		$verified .= commonSAData('Total Paid & Verified Subscrptions', $sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'], true);
	}
//Single
	
	if ($sa['PARA_6_SCS_PRINT'] || $sa['PARA_6_SINGLE_ISSUE_SALES_PCT']) {
		$single .= commonSAData('Single Issue', $sa['PARA_6_SCS_PRINT'], $sa['PARA_6_SINGLE_ISSUE_SALES_PCT']);
	}
	if ($sa['PARA_6_SCS_PARTNER_DED_PRINT'] || $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT']) {
		$single .= commonSAData('Partnership Deductible Single Issue', $sa['PARA_6_SCS_PARTNER_DED_PRINT'], $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT']);
	}
	if ($sa['PARA_6_SCS_SPONS_SALES_PRINT'] || $sa['PARA_6_SCS_SPONS_SALES_PCT']) {
		$single .= commonSAData('Sponsored Single Issue', $sa['PARA_6_SCS_SPONS_SALES_PRINT'], $sa['PARA_6_SCS_SPONS_SALES_PCT']);
	}
	if ($sa['PARA_6_TOTAL_SCS_PRINT'] || $sa['PARA_6_TOTAL_SCS_PCT']) {
		$single .= commonSAData('Total Single Copy Sales', $sa['PARA_6_TOTAL_SCS_PRINT'], $sa['PARA_6_TOTAL_SCS_PCT']);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'] || $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT']) {
		$single .= commonSAData('Total Paid & Verified Circulation', $sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'], true);
	}
//Analyzed
	
	if ($sa['PARA_6_ANP_LIST_SOURCE_PRINT']) {
		$analyzed .= commonSAData('List', $sa['PARA_6_SCS_PRINT'], $sa['PARA_6_ANP_LIST_SOURCE_PCT']);
	}
	if ($sa['PARA_6_ANP_MKT_COV_PRINT']) {
		$analyzed .= commonSAData('Market Coverage', $sa['PARA_6_ANP_MKT_COV_PRINT'], $sa['PARA_6_ANP_MKT_COV_PCT']);
	}
	if ($sa['PARA_6_ANP_BULK_PRINT']) {
		$analyzed .= commonSAData('Nonpaid Bulk', $sa['PARA_6_ANP_BULK_PRINT'], $sa['PARA_6_ANP_BULK_PCT']);
	}
	if ($sa['PARA_6_ANP_DEL_HOST_PROD_PRINT']) {
		$analyzed .= commonSAData('Delivered with Host Product', $sa['PARA_6_ANP_DEL_HOST_PROD_PRINT'], $sa['PARA_6_ANP_DEL_HOST_PROD_PCT']);
	}
	if ($sa['PARA_6_TOTAL_ANP_PRINT']) {
		$analyzed .= commonSAData('Total analyzed Nonpaid', $sa['PARA_6_TOTAL_ANP_PRINT'], $sa['PARA_6_TOTAL_ANP_PCT'], true);
	}
    if ($sa['PARA_6_TOT_PD_VERIF_ANP_PRINT']) {
		$analyzed .= commonSAData('Total circulation', $sa['PARA_6_TOT_PD_VERIF_ANP_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_ANP_PCT'], true);
	}
}


$Supplemental = $table_3_header.'<table width="97%" border="" style="text-align:center; color:#1a1a1a;">
                <thead>
                    <tr style="background-color: #bcd4ee;color:#1a1a1a;">
                        <td width="50%" style="background-color: #fff;">
                        </td>
                        <td  width="25%"  border="1">
                            <b>Print</b></td>
                        <td width="25%" border="1">
                            <b>% of Circulation</b>
                        </td>
                    </tr>
                </thead>
                <tbody >
                    <tr>
                        <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Paid Subscriptions</b></td>
                    </tr>
                    ' . $paidSubscriptions . '
                    <tr>
                        <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Verified Subscriptions</b></td>
                    </tr>
                    ' . $verified . '
                    <tr>
                        <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Single Copy Sales</b></td>
                    </tr>
                    ' . $single . '
                    <tr>
                        <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Analyzed Nonpaid</b></td>
                    </tr>
                    ' . $analyzed . '
                </tbody>
            </table>';

$empty_row = empty_row();
//------- SUPPLEMENTAL ANALYSIS --------------------------------------------------------------------------------         

//------- VARIANCE --------------------------------------------------------------------------------


if($variance) {
    $data = '';
    foreach($variance as $res) {
        $data .= 
            '<tr>
                <td align="center">' .$res['DRIVE_DATE']. '</td>
                <td align="center">' .$res['RATE_BASE']. '</td>
                <td align="center">' .number_format($res['AUDIT_REPORT']). '</td>
                <td align="center">' .number_format($res['PUBLISHERS_STATEMENT']). '</td>
                <td align="center">' .number_format($res['DIFFERENCE']). '</td>
                <td align="center">' .number_format($res['PERCENTAGE_OF_DIFFERENCE']). '</td>
            </tr>';	
    }
}
$Variance = 
    '<table width="100%" border="1">
                <thead>
                    <tr style="background-color: #bcd4ee;color:#1a1a1a;">
                        <td align="center">
                            <b>Audit Period<br> Ended</b>
                        </td>
                        <td align="center">
                            <b><br> Rate Base</b>
                        </td>
                        <td align="center">
                            <b><br> Audit Report</b>
                        </td>
                        <td align="center">
                            <b>Publisher’s <br>Statements</b>
                        </td>
                        <td align="center">
                            <b><br>Difference</b>
                        </td>
                        <td align="center">
                            <b>Percentage<br>of Difference</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                '.$data.'
                </tbody>
            </table>';
//------- VARIANCE --------------------------------------------------------------------------------

//------- PRICES --------------------------------------------------------------------------------

if($price) {
    $asc = 0;
    $subscription = 0;
    $aspa1net = 0;
    $aspa1gross = 0;
    $aspa2net = 0;
    $aspa2gross = 0;
    foreach ($price as $row) {
        $asc += $row['AVERAGE_SINGLE_COPY'];
        $subscription += $row['SUBSCRIPTION'];
        $aspa1net += $row['AVG_SUB_PRI_NET'];
        $aspa1gross += $row['AVG_SUBCRB_PRI_GROSS'];
        $aspa2net += $row['AVG_SUBCRB_PCPY_NET'];
        $aspa2gross += $row['AVG_SUBCRB_PCPY_GROSS'];
    }
}
$Prices = 
            '<table width="100%" border="0" style="text-align:center">
                <thead>
                    <tr>
                        <td width="50%" rowspan="2" ></td>
                        <td border="1"  width="17%" rowspan="2" style="background-color: #bcd4ee;color:#1a1a1a;"><b><br>Suggested <br> Retail Prices (1)</b></td>
                        <td border="1"  colspan="2" width="33%" style="background-color: #bcd4ee;color:#1a1a1a;">
                            <b>Average Price(2)</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="background-color: #bcd4ee;color:#1a1a1a;">
                        <td border="1"  width="17%"><b><br>Net</b></td>
                        <td border="1"  width="16%">
                            <b>Gross <br> (Optional)</b>
                        </td>
                    </tr>
                    <tr style="font-weight:thin;">
                        <td border="1"   width="50%" align="left"> Average Single Copy</td>
                        <td border="1"   width="17%">' .$asc. '</td>
                        <td border="1"  rowspan="2" width="17%"></td>
                        <td border="1"  rowspan="2" width="16%"></td>
                    </tr>
                    <tr>
                        <td border="1"  width="50%" align="left"> Subscription</td>
                        <td border="1"  width="17%">' .$subscription. '</td>

                    </tr>
                    <tr>
                        <td border="1"  width="50%" align="left"> Average Subscription Price Annualized (3)
                        </td>
                        <td border="1"  rowspan="2" width="17%"></td>
                        <td border="1"  width="17%">' .$aspa1net. '</td>
                        <td border="1"  width="16%">' .$aspa1gross. '</td>
                    </tr>
                    <tr>
                        <td border="1"  width="50%" align="left"> Average Subscription Price per Copy
                        </td>

                        <td border="1"  width="17%">' .$aspa2net. '</td>
                        <td border="1"  width="16%">' .$aspa2gross. '
                        
                        </td>
                    </tr>
                </tbody>
            </table>';


$main_right = '<table width="100%">
                    <tr>
                        <td>
                            '.$table_4_header.'
                            '.$Variance.'
                            <br><br>  Visit www.auditedmedia.com Media Intelligence Center for audit reports<br><br>
                        </td>
                    </tr>
                    <br><br>
                    <tr>
                        <td width="0.5%"></td>
                        <td width="99.5%">
                            '.$table_5_header.'
                            '.$Prices.'
                            <br><br>  (1) For statement period<br>
                            (2) Represents subscriptions for the 12 month period ended June 30, 2015<br>
                            (3) Based on the following issue per year frequency: 10<br>

                        </td>
                    </tr>
            </table>';
//------- PRICES --------------------------------------------------------------------------------
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

// $main includes tables 3, 4 & 5
$tbl = '
    <table width="100%" border="0" nobr="true">
                    <tr>
                        <td width="50%">
                            '.$Supplemental.'
                        </td>
                        <td width="50%">
                            '.$main_right.'
                        </td>
                    </tr>
            </table>';
$pdf->writeHTML($tbl, true, false, false, false, '');
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------
// ---------------------- PAGE 1 END---------------------------------------------------------------------------
    
$pdf->AddPage('L','A4');
    
// ---------------------- PAGE 2 START---------------------------------------------------------------------------
//------- ADDITIONAL DATA --------------------------------------------------------------------------------

$AdditionalData = 
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
//-------  ADDITIONAL DATA  --------------------------------------------------------------------------------

//------- ADDITIONAL ANALYSIS --------------------------------------------------------------------------------

$mavs_6A = '';
$mavs_6B = '';
if($aa) {
foreach($aa as $res) {
    if($res['MAVS_PARAGRAPH'] === '6A') {
        $mavs_6A .= '<tr>
                            <td  border="1" style="text-align:left;"  width="80%">'.$res['DESCRIPTION'].'</td>
                            <td  border="1" style="text-align:center;"  width="20%">'.number_format($res['MAVS_VERIF_SUBS_PRINT']).'</td>
                        </tr>';
    }
}

foreach($aa as $res) {
    if($res['MAVS_PARAGRAPH'] === '6B') {
        $mavs_6B .= '<tr>
                            <td  border="1" style="text-align:left;"  width="80%">'.$res['DESCRIPTION'].'</td>
                            <td  border="1" style="text-align:center;"  width="20%">'.number_format($res['MAVS_VERIF_SUBS_PRINT']).'</td>
                        </tr>';
    }
}
}
$AdditionalAnalysis = 
    '<table width="70%" border="0">
        <tr style="text-align:center;">
            <td width="80%"></td>
            <td width="20%" border="1"  style="background-color: #bcd4ee;">  
                <b><br>Print</b>
            </td>
        </tr>
        <tr>
            <td  border="1"   colspan="2" style="background-color: #bcd4ee;color:#1a1a1a;">
                <b>Public Place</b>
            </td>
        </tr>
        '.$mavs_6A.'
        <tr>
            <td   border="1"   colspan="2" style="background-color: #bcd4ee;color:#1a1a1a;">
                <b>Individual Use</b>
            </td>
        </tr>
        '.$mavs_6B.'
    </table>';

//------- ADDITIONAL ANALYSIS --------------------------------------------------------------------------------

//------- RATE BASE --------------------------------------------------------------------------------
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

$Rate_Base =
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
        </tr>
        ' . $ratebasenotes . '
                
    </table>';
//------- RATE BASE--------------------------------------------------------------------------------
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$main_left = '<table width="100%" >
                    <tr>
                        <td>'.$table_6_header.'
                        '.$AdditionalData.'
                        </td>
                    </tr>
                        <br><br>
                    <tr>
                        <td width="1%"></td>
                        <td width="99%">
                        '.$table_7_header.'
                        '.$AdditionalAnalysis.'
                        </td>
                    </tr>
                    <br><br>
                    <tr style="background-color: #fff;color:#1a1a1a;">
                        <td width="1%"></td>
                        <td width="99%">
                        '.$table_8_header.'
                        '.$Rate_Base.'    
                        </td>
                    </tr>
                </table>';


//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

//------- NOTES ----------------------------------------------------------------------------------

$Notes = 
    '<table width="100%" align="left" border="0">
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
//------- NOTES ----------------------------------------------------------------------------------

//------- CERTIFICATE --------------------------------------------------------------------------------

$Certificate = 
    '<table width="90%" style="border: 1px solid black">
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
            <td colspan="2">  PUB NAME, published by Publisher Address City, PROV PC</td>
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
//------- CERTIFICATE --------------------------------------------------------------------------------

$main_right = '<table width="100%" style="background-color: #fff;color:#1a1a1a;">
                    <tr>
                        <td>
                            '.$table_9_header.'
                            '.$Notes.'
                        </td>
                    </tr>
                    <br><br><br>
                    <tr>
                        <td width="1%"></td>
                        <td width="99%">
                        '.$table_10_header.'
                        '.$Certificate.'
                        </td>
                    </tr>
                </table>';
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$table = <<<EOD
    <table width="100%" border="0" nobr="true">
                    <tr>
                        <td width="50%">
                            $main_left
                        </td>

                        <td width="50%">
                            $main_right
                        </td>
                    </tr>
            </table>;
EOD;
 $pdf->writeHTML($table, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------
// ---------------------- PAGE 2 END---------------------------------------------------------------------------

$pdf->lastPage();
$pdf->Output('hhhhhh.pdf','I');

?>
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
			$image_file = '../assets/images/logo.jpg'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,20,10,50);            
			 
            $this->SetFont('arialnarrow', 'B', 10);
            $this->Text(20,30,"Publisher's Statement");
            
            $this->SetFont('arialnarrow', '', 10);
            $this->Text(20,36,"6 months ended December 31, 2015, Subject to Audit");
			//$this->Cell(0, 0, "Publisher's Statement", 0, false, 'L', 0, '', 0, false, 'M', 'M');

			// Header Right Side
			$image_file = '../assets/images/ABA.png'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,160,10,50);
            
            //Annual Frequency
            $this->SetFont('arialnarrow', 'B', 7);
            $this->Text(160,25,"Annual Frequency: ");
            //Anu Frequency Value
            $AnuFre = $head['FREQUENCY'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(183,25,"".$AnuFre);
            
            //Field Served
            $this->SetFont('arialnarrow', 'B', 7);
            $this->Text(160,30,"Field Served: ");
            //Field Served Value
            $Field = "Consumers interested in healthy living.";
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(177,30,"".$Field);
            
            //Published By
            $Publish = $head['PUBLISHED_BY'];
            $this->SetFont('helvetica', '', 7);
            $this->Text(160,35,"Published by ".$Publish);
		} else {
            $this->SetMargins(10, 10, 10, true);
        }

    }

    // Page footer
    public function Footer() {
        
        if($this->page == 1) {
        //position at  from bottom
        $this->SetY(-12);
            
        // Set font
        $this->SetFont('arialnarrow', 'I', 6.75);
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
            
        $this->Cell(0, 0, '48 W. Seegers Road lArlington Heights, IL 60005-3913 lT: 224-366-6939 lF: 224-366-6949 lwww.auditedmedia.com', 0, 0, 'C');
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
$pdf->SetAuthor('kesavan');
$pdf->SetTitle('5 MAGS print digital');
$pdf->SetSubject('5 MAGS print digital');
$pdf->SetKeywords('PDF, 5 MAGS print digital');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 42, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('arialnarrow', '', 6); 

// Landscape and A4 is the recommended Page Attributes
$pdf->AddPage('L', 'A4');

$pdf->Ln();


// ---------------Table Properties -----------------------------------------------------------------------------

/* Setting up the Title */

$title_1 = table_cell('  EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$title_2 = table_cell('TOTAL CIRCULATION BY ISSUE');
$title_3 = table_cell('SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION');
$title_4 = table_cell('VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$title_5 = table_cell('  PRICES');
$title_6 = table_cell_3(' ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER ','97');
$title_7 = table_cell_3(' ADDITIONAL ANALYSIS OF VERIFIED ','98');
$title_8 = table_cell_3(' RATE BASE ','98');
$title_9 = table_cell('NOTES');
$empty_row = empty_row();
/* Setting up the Title */


/* Styling up the Title */
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
/* Styling up the Title */

/* Supplemental Analysis fn*/
function commonSAData($title, $print, $digital, $total, $circ, $bold = false) {
	if ($bold) {
		$title = '<b>' . $title . '</b>';
	}
	return '<tr>
		
                    <td border="1"  width="50%" >' . $title . '</td>
                    <td  border="1" width="12.5%" align="center">' . $print . '</td>
                    <td border="1"  width="12.5%" align="center">' . $digital . '</td>
                    <td border="1"  width="12.5%" align="center">' . $total . '</td>
                    <td border="1"  width="12.5%" align="center">' . $circ . '</td>
    </tr>';
	
}
/* Supplemental Analysis fn*/

function empty_row(){
    $tr='<tr><td></td></tr>';
    return $tr;
}

// Table Properties -----------------------------------------------------------------------------

// ---------------------- PAGE 1 START---------------------------------------------------------------------------
    
//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------
$Executive_Summary = '';
$data = '';
$avg = '';
if($es){
    foreach($es as $res) {
        $data .= 
            '<tr>
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
      $title_1 . '<table width="100%"  align="center" border="1" nobr="true">
                <thead>
                     <tr>
                          <td width="14%" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Subscriptions</b></td>
                          <td width="14%" style="background-color: #bcd4ee;"><b><br>Single Copy<br>Sales</b></td>
                          <td width="14%" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Circulation</b></td>                           
                          <td width="14%" style="background-color: #bcd4ee;"><b><br>Analyzed<br>Nonpaid</b></td>                           
                          <td width="14%" style="background-color: #bcd4ee;"><b><br>Total<br>Circulation</b></td>                           
                          <td width="15%" style="background-color: #bcd4ee;"><b><br>Rate<br>Base</b></td>                           
                          <td width="15%" style="background-color: #bcd4ee;"><b><br>Variance<br>to Rate Base</b></td>                           
                     </tr>				 
				</thead>
                <tbody>
                ' . $data . '
              </tbody>
    </table>';           

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------------

//------- TOTAL CIRCULATION BY ISSUE --------------------------------------------------------------------------------
$data='';
if($tci) {
$len = sizeof($tci);

for ($i=0; $i<$len-1; $i++) {
    $res = $tci[$i];
    $data .=
        '<tr style=" text-align:center;">
                            <td  border="1"  width="2%"></td>
                            <td border="1"  width="6%"><b>'.$res['ISSUE_NAME'].'</b></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['PAID_SUBS_PRINT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['PAID_SUBS_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['SUBSCRIPTION_COUNT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['VERIF_SUBS_PRINT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['VERIF_SUBS_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['VERIF_SUBS']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_SUBS']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['SCS_PRINT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['SCS_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['SINGLE_COPY_COUNT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_CIRC_PRINT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_CIRC_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_CIRC']).'</h4></td>
                        </tr>';
}

for ($i=$len-1; $i<=$len-1; $i++) {
     $res = $tci[$i];
    $avg .=
        '<tr style=" text-align:center;">
                            <td  border="1"  width="2%"></td>
                            <td border="1"  width="6%"><b>'.$res['ISSUE_NAME'].'</b></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['PAID_SUBS_PRINT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['PAID_SUBS_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['SUBSCRIPTION_COUNT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['VERIF_SUBS_PRINT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['VERIF_SUBS_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['VERIF_SUBS']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_SUBS']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['SCS_PRINT']).'</h4></td>
                            <td border="1"  width="6%"><h4>'.number_format($res['SCS_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['SINGLE_COPY_COUNT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_CIRC_PRINT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_CIRC_DIGIT']).'</h4></td>
                            <td border="1"  width="8%"><h4>'.number_format($res['TOTAL_PAID_VERIF_CIRC']).'</h4></td>
            </tr>';
    }
}
$Total_Circulation= $title_2.'<table width="100%" border="0">
                <thead >
                    <tr style="text-align:center;">
                        <td colspan="2"  width="8%">
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1" colspan="3" width="20%">
                            <b>Paid Subscriptions</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  colspan="3" width="20%">
                            <b>Verified Subscriptions</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  rowspan="2" width="8%">
                            <b><br>Total <br>Paid & Verified <br>Subscriptions</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  colspan="3" width="20%">
                            <b>Single Copy Sales</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  rowspan="2" width="8%">
                            <b>Total <br>Paid & Verified<br> Circulation - Print</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  rowspan="2" width="8%">
                            <b>Total<br> Paid & Verified<br> Circulation<br> - Digital Issue</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  rowspan="2" width="8%">
                            <b><br>Total<br> Paid & Verified<br> Circulation</b>
                        </td>
                    </tr>
                    <tr >
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="8%" colspan="2">
                            <b><br><br>Issue</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="6%">
                            <b><br><br>Print</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="6%">
                            <b><br>Digital<br>Issue</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="8%">
                            <b>Total<br>Paid<br>Subscriptions</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="6%">
                            <b><br><br>Print</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="6%">
                            <b><br>Digital<br>Issue</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="8%">
                            <b>Total<br>Verified<br> Subscriptions</b>
                        </td>
                        
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="6%">
                            <b><br><br>Print</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="6%">
                            <b><br>Digital<br>Issue</b>
                        </td>
                        <td style="background-color: #bcd4ee;color:#1a1a1a; text-align:center;" border="1"  width="8%">
                            <b>Total<br>Single Copy<br> Sales</b>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                        '.$data.'
                        '.$avg.'  
                    </tbody>
                </table>';




//------- TOTAL CIRCULATION--------------------------------------------------------------------------

//------- SUPPLEMENTAL ANALYSIS --------------------------------------------------------------------------------         
$paidSubscriptions = '';
$verified = '';
$single = '';
$analyzed = '';

if($sa) {
	//pAID
	if ($sa['PARA_6_PD_INDV_SUBS_PRINT'] || $sa['PARA_6_PD_INDV_SUBS_DIGIT'] || $sa['PARA_6_PD_INDV_SUBS'] || $sa['PARA_6_PD_INDV_SUBS_PCT'] ) {
		$paidSubscriptions .= commonSAData('Individual Subscriptions', $sa['PARA_6_PD_INDV_SUBS_PRINT'], $sa['PARA_6_PD_INDV_SUBS_DIGIT'],$sa['PARA_6_PD_INDV_SUBS'],$sa['PARA_6_PD_INDV_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_DIGIT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT']) {
		$paidSubscriptions .= commonSAData('Association: Deductible', $sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_DED_DIGIT'],$sa['PARA_6_PD_ASSOC_SUBS_DED'],$sa['PARA_6_PD_ASSOC_SUBS_DED_PCT']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_DIGIT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT']) {
		$paidSubscriptions .= commonSAData('Association: Nondeductible', $sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_ND_DIGIT'],$sa['PARA_6_PD_ASSOC_SUBS_ND'],$sa['PARA_6_PD_ASSOC_SUBS_ND_PCT']);
	}
	if ($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBR_DED_DIGIT'] || $sa['PARA_6_PD_CLUB_MEMBER_DED'] || $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Deductible', $sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'], $sa['PARA_6_PD_CLUB_MEMBR_DED_DIGIT'],$sa['PARA_6_PD_CLUB_MEMBER_DED'],$sa['PARA_6_PD_CLUB_MEMBER_DED_PCT']);
	}
	if (isset($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT']) || $sa['PARA_6_PD_CLUB_MEMBR_ND_DIGIT'] || $sa['PARA_6_PD_CLUB_MEMBER_ND'] || $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Nondeductible', $sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'], $sa['PARA_6_PD_CLUB_MEMBR_ND_DIGIT'],$sa['PARA_6_PD_CLUB_MEMBER_ND'],$sa['PARA_6_PD_CLUB_MEMBER_ND_PCT']);
	}
	if ($sa['PARA_6_PD_DEFER_SUBS_PRINT'] || $sa['PARA_6_PD_DEFER_SUBS_DIGIT'] || $sa['PARA_6_PD_DEFER_SUBS'] || $sa['PARA_6_PD_DEFER_SUBS_PCT']) {
		$paidSubscriptions .= commonSAData('Deferred', $sa['PARA_6_PD_DEFER_SUBS_PRINT'], $sa['PARA_6_PD_DEFER_SUBS_DIGIT'],$sa['PARA_6_PD_DEFER_SUBS'],$sa['PARA_6_PD_DEFER_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] || $sa['PARA_6_PD_PARTNER_SUBS_DED_DIGIT'] || $sa['PARA_6_PD_PRTNR_SUBS_DED'] || $sa['PARA_6_PD_PRTNR_SUBS_DED_PCT'] ) {
		$paidSubscriptions .= commonSAData('Partnership Deductible Subscriptions', $sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'], $sa['PARA_6_PD_PARTNER_SUBS_DED_DIGIT'],$sa['PARA_6_PD_PRTNR_SUBS_DED'],$sa['PARA_6_PD_PRTNR_SUBS_DED_PCT']);
	}
	if ($sa['PARA_6_PD_SCHOOL_PRINT'] || $sa['PARA_6_PD_SCHOOL_SUBS_DIGIT'] || $sa['PARA_6_PD_SCHOOL'] || $sa['PARA_6_PD_SCHOOL_PCT']) {
		$paidSubscriptions .= commonSAData('School', $sa['PARA_6_PD_SCHOOL_PRINT'], $sa['PARA_6_PD_SCHOOL_SUBS_DIGIT'],$sa['PARA_6_PD_SCHOOL'],$sa['PARA_6_PD_SCHOOL_PCT']);
	}
	if ($sa['PARA_6_PD_SPONS_SALES_PRINT'] || $sa['PARA_6_PD_SPONS_SALES_DIGIT'] || $sa['PARA_6_PD_SPONS_SALES'] || $sa['PARA_6_PD_SPONS_SALES_PCT']) {
		$paidSubscriptions .= commonSAData('Sponsored Subscriptions', $sa['PARA_6_PD_SPONS_SALES_PRINT'], $sa['PARA_6_PD_SPONS_SALES_DIGIT'],$sa['PARA_6_PD_SPONS_SALES'],$sa['PARA_6_PD_SPONS_SALES_PCT']);
	}
	if ($sa['PARA_6_TOTAL_PAID_SUBS_PRINT'] && isset($sa['PARA_6_TOTAL_PAID_SUBS_DIGIT']) || $sa['PARA_6_TOTAL_PAID_SUBS_DIGIT'] || $sa['PARA_6_TOTAL_PAID_SUBS'] || $sa['PARA_6_TOTAL_PAID_SUBS_PCT']) {
		$paidSubscriptions .= commonSAData('Total Paid Subscriptions', $sa['PARA_6_TOTAL_PAID_SUBS_PRINT'], $sa['PARA_6_TOTAL_PAID_SUBS_DIGIT'],$sa['PARA_6_TOTAL_PAID_SUBS'],$sa['PARA_6_TOTAL_PAID_SUBS_PCT'], true);
	}

    //Verified
    if ($sa['PARA_6_VERIF_SUBS_PP_PRINT'] || $sa['PARA_6_VERIF_SUBS_PP_DIGIT'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT']) {
		$verified .= commonSAData('Public Place', $sa['PARA_6_VERIF_SUBS_PP_PRINT'],$sa['PARA_6_VERIF_SUBS_PP_DIGIT'],$sa['PARA_6_VERIF_SUBS_PUBL_PL'],$sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT']);
	}
	if ($sa['PARA_6_VERIF_SUBS_IU_PRINT'] && isset($sa['PARA_6_VERIF_SUBS_IU_DIGIT']) || $sa['PARA_6_VERIF_SUBS_IU_DIGIT'] || $sa['PARA_6_VERIF_SUBS_IND_USE'] || $sa['PARA_6_VERIF_SUBS_IU_PCT']) {
		$verified .= commonSAData('Individual Use', $sa['PARA_6_VERIF_SUBS_IU_PRINT'], $sa['PARA_6_VERIF_SUBS_IU_DIGIT'],$sa['PARA_6_VERIF_SUBS_IND_USE'],$sa['PARA_6_VERIF_SUBS_IU_PCT']);
	}
	if ($sa['PARA_6_TOT_VERIF_SUBS_PRINT'] && isset($sa['PARA_6_TOTAL_VERIF_SUBS_DIGIT']) || $sa['PARA_6_TOTAL_VERIF_SUBS_DIGIT'] || $sa['PARA_6_TOT_VERIF_SUBS'] || $sa['PARA_6_TOT_VERIF_SUBS_PCT']) {
		$verified .= commonSAData('Total Verified Subscriptions', $sa['PARA_6_TOT_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_VERIF_SUBS_DIGIT'],$sa['PARA_6_TOT_VERIF_SUBS'],$sa['PARA_6_TOT_VERIF_SUBS_PCT']);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'] && isset($sa['PARA_6_TOTAL_PD_VERIF_SUBS_DIGIT']) || $sa['PARA_6_TOTAL_PD_VERIF_SUBS_DIGIT'] || $sa['PARA_6_TOT_PD_VERIF_SUBS'] || $sa['PARA_6_TOT_PD_VERIF_SUBS_PCT']) {
		$verified .= commonSAData('Total Paid & Verified Subscrptions', $sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_SUBS_DIGIT'],$sa['PARA_6_TOT_PD_VERIF_SUBS'],$sa['PARA_6_TOT_PD_VERIF_SUBS_PCT'], true);
	}

//Single
//
 
	if ($sa['PARA_6_SCS_PRINT'] || $sa['PARA_6_SCS_DIGIT'] || $sa['PARA_6_SINGLE_ISSUE_SALES'] || $sa['PARA_6_SCS_PCT']) {
		$single .= commonSAData('Single Issue', $sa['PARA_6_SCS_PRINT'], $sa['PARA_6_SCS_DIGIT'],$sa['PARA_6_SINGLE_ISSUE_SALES'],$sa['PARA_6_SCS_PCT']);
	}
	if ($sa['PARA_6_SCS_PARTNER_DED_PRINT'] || $sa['PARA_6_SCS_PARTNERSHIP_DED_DIGIT'] || $sa['PARA_6_SCS_PARTNERSHIP_DED'] || $sa['PARA_6_SCS_PARTNER_DED_PCT']) {
		$single .= commonSAData('Partnership Deductible Single Issue', $sa['PARA_6_SCS_PARTNER_DED_PRINT'], $sa['PARA_6_SCS_PARTNERSHIP_DED_DIGIT'],$sa['PARA_6_SCS_PARTNERSHIP_DED'],$sa['PARA_6_SCS_PARTNER_DED_PCT']);
	}
	if ($sa['PARA_6_SCS_SPONS_SALES_PRINT'] || $sa['PARA_6_SCS_SPONS_SALES_DIGIT'] || $sa['PARA_6_SCS_SPONS_SALES'] || $sa['PARA_6_SCS_SPONS_SALES_PCT']) {
		$single .= commonSAData('Sponsored Single Issue', $sa['PARA_6_SCS_SPONS_SALES_PRINT'], $sa['PARA_6_SCS_SPONS_SALES_DIGIT'],$sa['PARA_6_SCS_SPONS_SALES'],$sa['PARA_6_SCS_SPONS_SALES_PCT']);
	}
	if ($sa['PARA_6_TOTAL_SCS_PRINT'] || $sa['PARA_6_TOTAL_SCS_DIGIT'] || $sa['PARA_6_TOTAL_SCS'] || $sa['PARA_6_TOTAL_SCS_PCT']) {
		$single .= commonSAData('Total Single Copy Sales', $sa['PARA_6_TOTAL_SCS_PRINT'], $sa['PARA_6_TOTAL_SCS_DIGIT'],$sa['PARA_6_TOTAL_SCS'],$sa['PARA_6_TOTAL_SCS_PCT']);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'] && isset($sa['PARA_6_TOTAL_PD_VERIF_CIRC_DIGIT']) || $sa['PARA_6_TOTAL_PD_VERIF_CIRC_DIGIT'] || $sa['PARA_6_TOTAL_PD_VERIF_CIRC'] || $sa['PARA_6_TOT_PD_VERIF_CIRC_PCT']) {
		$single .= commonSAData('Total Paid & Verified Circulation', $sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_CIRC_DIGIT'],$sa['PARA_6_TOTAL_PD_VERIF_CIRC'],$sa['PARA_6_TOT_PD_VERIF_CIRC_PCT'], true);
	}

//Analyzed
	
	if ($sa['PARA_6_ANP_LIST_SOURCE_PRINT'] || $sa['PARA_6_ANP_LIST_SOURCE_DIGIT'] || $sa['PARA_6_ANP_LIST_SOURCE'] || $sa['PARA_6_ANP_LIST_SOURCE_PCT']) {
		$analyzed .= commonSAData('List', $sa['PARA_6_ANP_LIST_SOURCE_PRINT'], $sa['PARA_6_ANP_LIST_SOURCE_DIGIT'],$sa['PARA_6_ANP_LIST_SOURCE'],$sa['PARA_6_ANP_LIST_SOURCE_PCT']);
	}
	if ($sa['PARA_6_ANP_MKT_COV_PRINT'] || $sa['PARA_6_ANP_MKT_COV_DIGIT'] || $sa['PARA_6_ANP_MKT_COV'] || $sa['PARA_6_ANP_MKT_COV_PCT']) {
		$analyzed .= commonSAData('Market Coverage', $sa['PARA_6_ANP_MKT_COV_PRINT'], $sa['PARA_6_ANP_MKT_COV_DIGIT'],$sa['PARA_6_ANP_MKT_COV'],$sa['PARA_6_ANP_MKT_COV_PCT']);
	}
	if ($sa['PARA_6_ANP_BULK_PRINT'] || $sa['PARA_6_ANP_BULK_DIGIT'] || $sa['PARA_6_ANP_BULK'] || $sa['PARA_6_ANP_BULK_PCT']) {
		$analyzed .= commonSAData('Nonpaid Bulk', $sa['PARA_6_ANP_BULK_PRINT'], $sa['PARA_6_ANP_BULK_DIGIT'],$sa['PARA_6_ANP_BULK'],$sa['PARA_6_ANP_BULK_PCT']);
	}
	if ($sa['PARA_6_ANP_DEL_HOST_PROD_PRINT'] || $sa['PARA_6_ANP_DEL_HOST_PROD_DIGIT'] || $sa['PARA_6_ANP_DEL_HOST_PROD'] || $sa['PARA_6_ANP_DEL_HOST_PROD_PCT']) {
		$analyzed .= commonSAData('Delivered with Host Product', $sa['PARA_6_ANP_DEL_HOST_PROD_PRINT'], $sa['PARA_6_ANP_DEL_HOST_PROD_DIGIT'],$sa['PARA_6_ANP_DEL_HOST_PROD'],$sa['PARA_6_ANP_DEL_HOST_PROD_PCT']);
	}
	if ($sa['PARA_6_TOTAL_ANP_PRINT'] || $sa['PARA_6_TOTAL_ANP_DIGIT'] || $sa['PARA_6_TOTAL_ANP'] || $sa['PARA_6_TOTAL_ANP_PCT']) {
		$analyzed .= commonSAData('Total analyzed Nonpaid', $sa['PARA_6_TOTAL_ANP_PRINT'], $sa['PARA_6_TOTAL_ANP_DIGIT'],$sa['PARA_6_TOTAL_ANP'],$sa['PARA_6_TOTAL_ANP_PCT']);
	}
    if ($sa['PARA_6_TOT_PD_VERIF_ANP_PRINT'] || $sa['PARA_6_TOTAL_PD_VERIF_ANP_DIGIT'] || $sa['PARA_6_TOT_PD_VERIF_ANP'] || $sa['PARA_6_TOT_PD_VERIF_ANP_PCT']) {
		$analyzed .= commonSAData('Total circulation', $sa['PARA_6_TOT_PD_VERIF_ANP_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_ANP_DIGIT'],$sa['PARA_6_TOT_PD_VERIF_ANP'],$sa['PARA_6_TOT_PD_VERIF_ANP_PCT'], true);
	}


 }

$Supplemental =  $title_3 . '<table width="100%" border="0" style="text-align:center;" nobr="true">
                <thead>
                    <tr>
                        <td  width="50%"></td>
                        <td border="1"  width="12.5%" align="center" style="background-color: #bcd4ee;">
                            <b><br>Print</b>
                        </td>
                        <td border="1"  width="12.5%" align="center" style="background-color: #bcd4ee;">
                            <b>Digital<br>Issue</b>
                        </td>
                        <td border="1"  width="12.5%" align="center" style="background-color: #bcd4ee;">
                            <b><br>Total</b>
                        </td>
                        <td border="1"  width="12.5%" align="center" style="background-color: #bcd4ee;">
                            <b>% of Circulation</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td align="left" colspan="5" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Paid Subscriptions</b></td>
                </tr>
                    '.$paidSubscriptions.'
                    <tr>
                    <td align="left" colspan="5" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Verified Subscriptions</b></td>
                </tr>
                    '.$verified.'
                    <tr>
                    <td align="left" colspan="5" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Single Copy Sales</b></td>
                </tr>
                    '.$single.'
                    <tr>
                    <td align="left" colspan="5" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Analyzed Nonpaid</b></td>
                </tr>
                    '.$analyzed.'
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
$Variance = $title_4. 
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
$asc = '';
$subscription = '';
$aspa1net = '';
$aspa1gross = '';
$aspa2net = '';
$aspa2gross = '';
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
$Prices = $title_5.
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

//------- PRICES --------------------------------------------------------------------------------
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$table = 
    '<table width="100%" cellpadding="0" border="0" nobr="true">
        <tr>
            <td width="100%">
                ' . $Executive_Summary . '  
				<br><br>
            </td>  
        </tr> 
		
		<tr>
            <td width="100%">                
                ' . $Total_Circulation . '  
				<br><br><br>
            </td>  
        </tr>
		<tr>
            <td width="49%">			    
                ' . $Supplemental . '                    
                <br><br><br>
            </td>
			<td width="1%"></td>
            <td width="50%">
                ' . $Variance . '
                <br><br>
                ' . $Prices . '	
            </td> 
        </tr>
        
		
    </table>';
$pdf->writeHTML($table, true, false, false, false, '');
//$pdf->writeHTML($tbl, true, false, false, false, '');
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------
// ---------------------- PAGE 1 END---------------------------------------------------------------------------

//-------SECOND PAGE STARTS HERE--------------------------------------------------------------------------------

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
                            <td  border="1" style="text-align:left;"  width="50%">'.$res['DESCRIPTION'].'</td>
                            <td  border="1" style="text-align:center;"  width="16%">'.number_format($res['MAVS_VERIF_SUBS_PRINT']).'</td>
                            <td  border="1" style="text-align:center;"  width="16%">'.number_format($res['MAVS_VERIF_SUBS_DIGIT']).'</td>
                            <td  border="1" style="text-align:center;" width="18%">'.number_format($res['MAVS_VERIF_SUBS']).'</td>
                        </tr>';
    }
}

foreach($aa as $res) {
    if($res['MAVS_PARAGRAPH'] === '6B') {
        $mavs_6B .= '<tr>
                            <td  border="1" style="text-align:left;"  width="50%">'.$res['DESCRIPTION'].'</td>
                            <td  border="1" style="text-align:center;"  width="16%">'.number_format($res['MAVS_VERIF_SUBS_PRINT']).'</td>
                            <td  border="1" style="text-align:center;"  width="16%">'.number_format($res['MAVS_VERIF_SUBS_DIGIT']).'</td>
                            <td  border="1" style="text-align:center;" width="18%">'.number_format($res['MAVS_VERIF_SUBS']).'</td>
                        </tr>';
    }
}
}
$AdditionalAnalysis = 
    '<table width="98%" border="0">
        <tr style="text-align:center;">
            <td width="50%"></td>
            <td  border="1"  width="16%" style="background-color: #bcd4ee;">  
                <b><br>Print</b>
            </td>
            <td  border="1"   width="16%" style="background-color: #bcd4ee;color:#1a1a1a;">  
                <b>Digital<br>Issue</b>
            </td>
            <td  border="1"   width="18%" style="background-color: #bcd4ee;color:#1a1a1a;">
                <b><br>Total</b>
            </td>
        </tr>
        <tr>
            <td  border="1"   colspan="4" style="background-color: #bcd4ee;color:#1a1a1a;">
                <b>Public Place</b>
            </td>
        </tr>
        '.$mavs_6A.'
        <tr>
            <td   border="1"   colspan="4" style="background-color: #bcd4ee;color:#1a1a1a;">
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

$Rate_Base ='';
if($ratebasechange || $ratebasenotes || $pvctext) {
$table_8 =
     $table_8_header.'<table width="100%" align="left" border="0">
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
    }
//------- RATE BASE--------------------------------------------------------------------------------
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------


$main_left = '<table width="100%" >
                    <tr>
                        <td>'.$title_6.'
                        '.$AdditionalData.'
                        </td>
                    </tr>
                        <br><br>
                    <tr>
                        <td>
                        '.$title_7.'
                        '.$AdditionalAnalysis.'
                        </td>
                    </tr>
                    <br><br>
                    <tr style="background-color: #fff;color:#1a1a1a;">
                        <td>
                        '.$title_8.'
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
                            '.$title_9.'
                            '.$Notes.'
                        </td>
                    </tr>
                    <br><br><br>
                    <tr>
                        <td width="1%"></td>
                        <td width="99%">
                        
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
<?php
require_once('../App.php');
require_once('../data/PdfManager.php');
require_once('../libraries/TCPDF/tcpdf_include.php');
require_once('../libraries/TCPDF/tcpdf.php');

/* Card Details */

$card['MEMBER_NUMBER'] = 415072; 
$card['DRIVE_DATE'] =  '31-DEC-2016';
$card['PRODUCT_TYPE'] = 'PS';

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

class MYPDF extends TCPDF {
    
    public function Header() { 
        if ($this->page == 1) {
            
            global $head;
                        
            // Header Left Side
			$image_file = '../assets/images/logo.jpg'; // *** Very IMP:
			$this->Image($image_file,20,10,50);            
			 
            $this->SetFont('arialnarrow', 'B', 10);
            $this->Text(20,30,"Publisher's Statement");
            
            $this->SetFont('arialnarrow', '', 10);
            $this->Text(20,36,"6 months ended December 31, 2015, Subject to Audit");			

			// Header Right Side
			$image_file = '../assets/images/ABA.png'; // *** Very IMP:
			$this->Image($image_file,160,10,50);
            
            //Annual Frequency
            $AnuFre = $head['FREQUENCY'];
            $this->SetFont('arial', 'B', 7);
            $this->Text(160,25,"Annual Frequency: ".$AnuFre);
            
            //Field Served
            $this->SetFont('arialnarrow', 'B', 7);
            $this->Text(160,30,"Field Served: ");
            
            //Field Served Value
            $Field = $head['FIELD_SERVED'];
            $this->SetFont('arialnarrow', '', 7);
            $this->MultiCell(110,5,"".$Field,'','','','',177,30);
            
            //Published By
            $Publish = $head['PUBLISHED_BY'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(160,38,"Published By ".$Publish);
            
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
        $this->SetFont('arialnarrow', 'I', 7);
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
            
        $this->Cell(0, 0, '151 Bloor Street West, Suite 850 lToronto, ON M5S 1S4 lT: 416-962-5840 lF: 416-962-5844 lwww.auditedmedia.ca', 0, 0, 'C');
        }
        else {
            //position at 25mm from bottom
            $this->SetY(-25);
            $this->SetFont('arialnarrow','I', 7);
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

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('6 MAGS with DNR');
$pdf->SetTitle('6 MAGS with DNR');
$pdf->SetSubject('6 MAGS with DNR');
$pdf->SetKeywords('PDF, 6 MAGS with DNR');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('arialnarrow', '', 7); 

// Landscape and A4 is the recommended Page Attributes
$pdf->AddPage('L', 'A4');

$pdf->Ln();

// -----------------Table Properties -----------------------------------------------------------------------------

/* Setting up the Title */
$title_1 = table_cell('  EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$title_2 = table_cell_with_percentage('  DIGITAL NONREPLICA','70%');
$title_3 = table_cell('  TOTAL CIRCULATION BY ISSUE');
$title_4 = table_cell('  DIGITAL NONREPLICA');
$title_5 = table_cell('  SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION');
$title_6 = table_cell('  VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$title_7 = table_cell('  PRICES');
$title_8 = table_cell('  ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER');
$title_9 = table_cell('  ADDITIONAL ANALYSIS OF VERIFIED');
$title_10 = table_cell('  RATE BASE');
$title_11 = table_cell('  NOTES');
/* Setting up the Title */

/* Styling up the Title */
function table_cell($title){
    $td = '<table width="100%"><tr style="line-height: 150%;"><td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>'.$title.'</b></td></tr><tr style="line-height: 30%;"><td></td></tr></table>';
    return $td;
}
function table_cell_with_percentage($title,$percentage){
    $td = '<table width="'.$percentage.'"><tr style="line-height: 150%;"><td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>'.$title.'</b></td></tr><tr style="line-height: 30%;"><td></td></tr></table>';
    return $td;
}
/* Styling up the Title */

/* Supplemental Analysis */
function commonSAData($title, $print, $circ, $nr, $bold = false) {
	if ($bold) {
		$title = '<b>' . $title . '</b>';
	}
	return '<tr>
		<td width="55%" border="1">' . $title . '</td>
		<td width="15%" border="1">' . $print . '</td>
		<td width="15%" border="1">' . $circ . '</td>
		<td width="15%" border="1">' . $nr . '</td>
	</tr>';
	
}
/* Supplemental Analysis */

// Table Properties -----------------------------------------------------------------------------

// ---------------------- PAGE 1 START--------------------------------------------------

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
    '<table width="100%" border="1">
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

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------------

//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

if($es) {
    $data = '';
    foreach($es as $row) {
        $data .= '<tr>
                        <td width="14%">'. number_format($row['PAR_1_DIGIT_NR_PD_VER_SUBS']) .'</td>
                        <td width="14%">'. number_format($row['PARA_1_DIGIT_NON_REPL_SCS']) .'</td>
                        <td width="14%">'. number_format($row['PAR_1_DIGIT_NR_PD_VER_CIRC']) .'</td> 
                        <td width="14%">'. number_format($row['PARA_1_DIGIT_NON_REPL_ANP']) .'</td> 
                        <td width="14%">'. number_format($row['PARA_1_DIGIT_NON_REPL_TOTAL']) .'</td> 
                    </tr>';	

    }
}
    
$Executive_Digital_Nonreplica = 
    '<table width="100%"  align="center" border="1">
                <thead>
                     <tr>
                          <td width="14%" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Subscriptions</b></td>
                          <td width="14%" style="background-color: #bcd4ee;"><b><br>Single Copy<br>Sales</b></td>
                          <td width="14%" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Circulation</b></td>
                          <td width="14%" style="background-color: #bcd4ee;"><b><br>Analyzed<br>Nonpaid</b></td>
                          <td width="14%" style="background-color: #bcd4ee;"><b><br>Total<br>Circulation</b></td>
                     </tr>				 
				</thead>
                
				<tbody>
                ' . $data . '
              </tbody>

    </table>';
    
//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

//------- TOTAL CIRCULATION--------------------------------------------------------------------------
    
if($tci) {
    
    $len = sizeof($tci);
    $data = '';
    for ($i=0; $i<$len-1; $i++) {
        $row = $tci[$i];
        $data.='
          <tr align="center">
                <td border="1" width="2%">'.$row['SPECIAL_ISSUE'].'</td>                
                <td border="1" width="7%">' . $row['ISSUE_NAME'] . '</td>
                <td border="1" width="13%">' . number_format($row['PAID_SUBS_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['VERIF_SUBS_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_SUBS']) . '</td>
                <td border="1" width="13%">' . number_format($row['SCS_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_CIRC']) . '</td>
                <td border="1" width="13%">' . number_format($row['ANP_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_ANP_CIRC']) . '</td>
          </tr>';
    }

    $avg = '';
    for ($i=$len-1; $i<=$len-1; $i++) {
            $row = $tci[$i];
            $avg .= '
            <tr style="font-weight:bold;" align="center">                
                <td border="1" width="2%">'.$row['SPECIAL_ISSUE'].'</td>                
                <td border="1" width="7%">' . $row['ISSUE_NAME'] . '</td>
                <td border="1" width="13%">' . number_format($row['PAID_SUBS_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['VERIF_SUBS_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_SUBS']) . '</td>
                <td border="1" width="13%">' . number_format($row['SCS_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_CIRC']) . '</td>
                <td border="1" width="13%">' . number_format($row['ANP_PRINT']) . '</td>
                <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_ANP_CIRC']) . '</td>
            </tr>';    
    }
    
}
    
$Total_Circulation = 
	'<table width="100%" border="0">
    
	  <thead>	
		  <tr>
			<td border="none" width="9%">&nbsp;</td>
			<td border="1" colspan="7" width="91%" style="background-color: #bcd4ee;"><div align="center"><b>Print</b></div></td>
		  </tr>
		  <tr style="background-color: #bcd4ee;">
				<td border="1" width="9%" ><div align="center"><br><br><br><b>Issue</b></div></td>
				<td border="1" width="13%"><div align="center"><br><br><b>Paid<br> Subscriptions</b></div></td>
				<td border="1" width="13%"><div align="center"><br><br><b>Verified<br> Subscriptions</b></div></td>
				<td border="1" width="13%"><div align="center"><br><b>Total<br>Paid &amp; Verified<br>Subscriptions</b></div></td>
				<td border="1" width="13%"><div align="center"><br><br><b>Single Copy<br>Sales</b></div></td>
				<td border="1" width="13%"><div align="center"><br><b>Total<br>Paid &amp; Verified<br> Circulation</b></div></td>
				<td border="1" width="13%"><div align="center"><br><br><b>Analyzed<br> Nonpaid</b></div></td>
				<td border="1" width="13%"><div align="center"><b>Total<br>Paid, Verified &amp;<br>   Analyzed Nonpaid<br> Circulation</b></div></td>
		  </tr>
	  </thead>
      
	  <tbody>
            ' . $data . '
            ' . $avg . '
      </tbody>
      
	</table>';
    
//------- TOTAL CIRCULATION--------------------------------------------------------------------------

//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

if($tci) {
    
    $len = sizeof($tci);
    $data='';
    for ($i=0; $i<$len-1; $i++) {
        $row = $tci[$i];
        $data.='
          <tr align="center">
              <td border="1" width="2%">'  . $row['SPECIAL_ISSUE'].'</td>                
              <td border="1" width="7%" >' . $row['ISSUE_NAME'] . '</td>
              <td border="1" width="13%">' . number_format($row['PAID_SUBS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['VERIF_SUBS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_SUBS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['SCS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_CIRC_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['ANP_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VER_ANP_CIRC_DIG_NR']) . '</td>
          </tr>';
    }

    $avg = '';
    for ($i=$len-1; $i<=$len-1; $i++) {
        $row = $tci[$i];
        $avg .= '
          <tr style="font-weight:bold;">
              <td border="1" width="2%">'  . $row['SPECIAL_ISSUE'].'</td>                
              <td border="1" width="7%">'  . $row['ISSUE_NAME'] . '</td>
              <td border="1" width="13%">' . number_format($row['PAID_SUBS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['VERIF_SUBS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_SUBS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['SCS_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VERIF_CIRC_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['ANP_DIG_NR']) . '</td>
              <td border="1" width="13%">' . number_format($row['TOTAL_PAID_VER_ANP_CIRC_DIG_NR']) . '</td>
          </tr>';
    }
    
}

$Total_Circulation_Digital_Nonreplica = 
    '<table width="100%" border="1">
    
	  <thead>	
		  <tr style="background-color: #bcd4ee;">
				<td width="9%" ><div align="center"><br><br><br><b>Issue</b></div></td>
				<td width="13%"><div align="center"><br><br><b>Paid<br> Subscriptions</b></div></td>
				<td width="13%"><div align="center"><br><br><b>Verified<br> Subscriptions</b></div></td>
				<td width="13%"><div align="center"><br><b>Total<br>Paid &amp; Verified<br>Subscriptions</b></div></td>
				<td width="13%"><div align="center"><br><br><b>Single Copy<br>Sales</b></div></td>
				<td width="13%"><div align="center"><br><b>Total<br>Paid &amp; Verified<br> Circulation</b></div></td>
				<td width="13%"><div align="center"><br><br><b>Analyzed<br> Nonpaid</b></div></td>
				<td width="13%"><div align="center"><b>Total<br>Paid, Verified &amp;<br>   Analyzed Nonpaid<br> Circulation</b></div></td>
		  </tr>
	  </thead>
      
	  <tbody>
	     ' .$data. '
	    ' .$avg. '
    </tbody>
      
	</table>';
    
//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td>
                ' . $title_1 . '
                ' . $Executive_Summary . '                 
            </td>  
        </tr>        
		<tr>
            <td>               
                <br> <br>
                ' . $title_2 . '
                ' . $Executive_Digital_Nonreplica . '             
                
            </td>  
        </tr>        
		<tr>
            <td>
			     <br><br><br>
                ' . $title_3 . '                 
                ' . $Total_Circulation . '
                
            </td> 
        </tr>        
		<tr>
            <td>
			     <br><br>
                ' . $title_4 . '
                ' . $Total_Circulation_Digital_Nonreplica . '    
                <br><br><br><br>
            </td> 
        </tr>		
    </table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

// ---------------------- PAGE 1 END--------------------------------------------------

// ---------------------- PAGE 2 START--------------------------------------------------

//------- SUPPLEMENTAL ANALYSIS --------------------------------------------------------------------------------         

$paidSubscriptions = '';
$verified = '';
$single = '';
$analyzed = '';
if ($sa) {
    //Paid Subs
	
	if($sa['PARA_6_PD_INDV_SUBS_PRINT']  || $sa['PARA_6_PD_INDIV_SUBS_PCT'] || $sa['PARA_6_PD_INDV_SUBS_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Individual Subscriptions', $sa['PARA_6_PD_INDV_SUBS_PRINT'], $sa['PARA_6_PD_INDV_SUBS_PCT'], $sa['PARA_6_PD_INDV_SUBS_DIG_NR']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT'] || $sa['PARA_6_PD_ASSO_SUBS_DED_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Association: Deductible', $sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT'], $sa['PARA_6_PD_ASSO_SUBS_DED_DIG_NR']);
	}
	if ($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT'] || $sa['PARA_6_PD_ASSO_SUBS_ND_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Association: Nondeductible', $sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'], $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT'], $sa['PARA_6_PD_ASSO_SUBS_ND_DIG_NR']);
	}
	if ($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT'] || $sa['PARA_6_PD_CLUB_MEMB_DED_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Deductible', $sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'], $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT'], $sa['PARA_6_PD_CLUB_MEMB_DED_DIG_NR']);
	}
	if ($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT'] || $sa['PARA_6_PD_CLUB_MEMB_ND_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Club/Membership: Nondeductible', $sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'], $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT'], $sa['PARA_6_PD_CLUB_MEMB_ND_DIG_NR']);
	}
	if ($sa['PARA_6_PD_DEFER_SUBS_PRINT'] || $sa['PARA_6_PD_DEFER_SUBS_PCT'] || $sa['PARA_6_PD_DEFER_SUBS_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Deferred', $sa['PARA_6_PD_DEFER_SUBS_PRINT'], $sa['PARA_6_PD_DEFER_SUBS_DIG_NR'], $sa['PARA_6_PD_INDV_SUBS_PCT']);
	}
	if ($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] || $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'] || $sa['PARA_6_PD_PRTNR_SUB_DED_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Partnership Deductible Subscriptions', $sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'], $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'], $sa['PARA_6_PD_PRTNR_SUB_DED_DIG_NR']);
	}
	if ($sa['PARA_6_PD_SCHOOL_PRINT'] || $sa['PARA_6_PD_SCHOOL_SUBS_PCT'] || $sa['PARA_6_PD_SCHOOL_DIG_NR']) {
		$paidSubscriptions .= commonSAData('School', $sa['PARA_6_PD_SCHOOL_PRINT'], $sa['PARA_6_PD_SCHOOL_SUBS_PCT'], $sa['PARA_6_PD_SCHOOL_DIG_NR']);
	}
	if ($sa['PARA_6_PD_SPONS_SALES_PRINT'] || $sa['PARA_6_PD_SPONS_SALES_PCT'] || $sa['PARA_6_PD_SPONS_SALES_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Sponsored Subscriptions', $sa['PARA_6_PD_SPONS_SALES_PRINT'], $sa['PARA_6_PD_SPONS_SALES_PCT'], $sa['PARA_6_PD_SPONS_SALES_DIG_NR']);
	}
	if ($sa['PARA_6_TOTAL_PAID_SUBS_PRINT'] || $sa['PARA_6_TOTAL_PAID_SUBS_PCT'] || $sa['PARA_6_TOTAL_PAID_SUBS_DIG_NR']) {
		$paidSubscriptions .= commonSAData('Total Paid Subscriptions', $sa['PARA_6_TOTAL_PAID_SUBS_PRINT'], $sa['PARA_6_PD_INDV_SUBS_PCT'], $sa['PARA_6_TOTAL_PAID_SUBS_DIG_NR'], true);
	}
//Verified
	
	if ($sa['PARA_6_VERIF_SUBS_PP_PRINT'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT'] || $sa['PARA_6_VERIF_SUBS_PP_DIG_NR']) {
		$verified .= commonSAData('Public Place', $sa['PARA_6_VERIF_SUBS_PP_PRINT'],$sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT'], $sa['PARA_6_VERIF_SUBS_PP_DIG_NR']);
	}
	if ($sa['PARA_6_VERIF_SUBS_IU_PRINT'] || $sa['PARA_6_VERIF_SUBS_IND_USE_PCT'] || $sa['PARA_6_VERIF_SUBS_IU_DIG_NR']) {
		$verified .= commonSAData('Individual Use', $sa['PARA_6_VERIF_SUBS_IU_PRINT'], $sa['PARA_6_VERIF_SUBS_IND_USE_PCT'], $sa['PARA_6_VERIF_SUBS_IU_DIG_NR']);
	}
	if ($sa['PARA_6_TOT_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOTAL_VERIF_SUBS_PCT'] || $sa['PARA_6_TOT_VERIF_SUBS_DIG_NR']) {
		$verified .= commonSAData('Total Verified Subscriptions', $sa['PARA_6_TOT_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_VERIF_SUBS_PCT'], $sa['PARA_6_TOT_VERIF_SUBS_DIG_NR']);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'] || $sa['PARA_6_TOT_PD_VER_SUBS_DIG_NR']) {
		$verified .= commonSAData('Total Paid & Verified Subscrptions', $sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'], $sa['PARA_6_TOT_PD_VER_SUBS_DIG_NR'], true);
	}
//Single
	
	if ($sa['PARA_6_SCS_PRINT'] || $sa['PARA_6_SINGLE_ISSUE_SALES_PCT'] || $sa['PARA_6_SCS_DIG_NR']) {
		$single .= commonSAData('Single Issue', $sa['PARA_6_SCS_PRINT'], $sa['PARA_6_SINGLE_ISSUE_SALES_PCT'], $sa['PARA_6_SCS_DIG_NR']);
	}
	if ($sa['PARA_6_SCS_PARTNER_DED_PRINT'] || $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT'] || $sa['PARA_6_SCS_PARTNER_DED_DIG_NR']) {
		$single .= commonSAData('Partnership Deductible Single Issue', $sa['PARA_6_SCS_PARTNER_DED_PRINT'], $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT'], $sa['PARA_6_SCS_PARTNER_DED_DIG_NR']);
	}
	if ($sa['PARA_6_SCS_SPONS_SALES_PRINT'] || $sa['PARA_6_SCS_SPONS_SALES_PCT'] || $sa['PARA_6_SCS_SPONS_SALES_DIG_NR']) {
		$single .= commonSAData('Sponsored Single Issue', $sa['PARA_6_SCS_SPONS_SALES_PRINT'], $sa['PARA_6_SCS_SPONS_SALES_PCT'], $sa['PARA_6_SCS_SPONS_SALES_DIG_NR']);
	}
	if ($sa['PARA_6_TOTAL_SCS_PRINT'] || $sa['PARA_6_TOTAL_SCS_PCT'] || $sa['PARA_6_TOTAL_SCS_DIG_NR']) {
		$single .= commonSAData('Total Single Copy Sales', $sa['PARA_6_TOTAL_SCS_PRINT'], $sa['PARA_6_TOTAL_SCS_PCT'], $sa['PARA_6_TOTAL_SCS_DIG_NR']);
	}
	if ($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'] || $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'] || $sa['PARA_6_TOT_PD_VER_CIRC_DIG_NR']) {
		$single .= commonSAData('Total Paid & Verified Circulation', $sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'], $sa['PARA_6_TOT_PD_VER_CIRC_DIG_NR'], true);
	}
//Analyzed
	
	if ($sa['PARA_6_ANP_LIST_SOURCE_PRINT'] || $sa['PARA_6_ANP_LIST_SOURCE_PCT'] || $sa['PARA_6_ANP_LIST_SOURCE_DIG_NR']) {
		$analyzed .= commonSAData('List', $sa['PARA_6_SCS_PRINT'], $sa['PARA_6_ANP_LIST_SOURCE_PCT'], $sa['PARA_6_ANP_LIST_SOURCE_DIG_NR']);
	}
	if ($sa['PARA_6_ANP_MKT_COV_PRINT'] || $sa['PARA_6_ANP_MKT_COV_PCT'] || $sa['PARA_6_ANP_MKT_COV_DIGIT_NR']) {
		$analyzed .= commonSAData('Market Coverage', $sa['PARA_6_ANP_MKT_COV_PRINT'], $sa['PARA_6_ANP_MKT_COV_PCT'], $sa['PARA_6_ANP_MKT_COV_DIGIT_NR']);
	}
	if ($sa['PARA_6_ANP_BULK_PRINT'] || $sa['PARA_6_ANP_BULK_PCT'] || $sa['PARA_6_ANP_BULK_DIG_NR']) {
		$analyzed .= commonSAData('Nonpaid Bulk', $sa['PARA_6_ANP_BULK_PRINT'], $sa['PARA_6_ANP_BULK_PCT'], $sa['PARA_6_ANP_BULK_DIG_NR']);
	}
	if ($sa['PARA_6_ANP_DEL_HOST_PROD_PRINT'] || $sa['PARA_6_ANP_DEL_HOST_PROD_PCT'] || $sa['PARA_6_ANP_DEL_HOST_PRD_DIG_NR']) {
		$analyzed .= commonSAData('Delivered with Host Product', $sa['PARA_6_ANP_DEL_HOST_PROD_PRINT'], $sa['PARA_6_ANP_DEL_HOST_PROD_PCT'], $sa['PARA_6_PD_INDV_SUBS_PCT'] || $sa['PARA_6_PD_INDIV_SUBS_PCT'] || $sa['PARA_6_ANP_DEL_HOST_PRD_DIG_NR']);
	}
	if ($sa['PARA_6_TOTAL_ANP_PRINT'] || $sa['PARA_6_TOTAL_ANP_PCT'] || $sa['PARA_6_TOTAL_ANP_DIG_NR']) {
		$analyzed .= commonSAData('Total analyzed Nonpaid', $sa['PARA_6_TOTAL_ANP_PRINT'], $sa['PARA_6_TOTAL_ANP_PCT'], $sa['PARA_6_TOTAL_ANP_DIG_NR'], true);
	}
    if ($sa['PARA_6_TOT_PD_VERIF_ANP_PRINT'] || $sa['PARA_6_TOTAL_PD_VERIF_ANP_PCT'] || $sa['PARA_6_TOT_PD_VERIF_ANP_DIG_NR']) {
		$analyzed .= commonSAData('Total circulation', $sa['PARA_6_TOT_PD_VERIF_ANP_PRINT'], $sa['PARA_6_TOTAL_PD_VERIF_ANP_PCT'], $sa['PARA_6_TOT_PD_VERIF_ANP_DIG_NR'], true);
	}
}

$Supplemental='
	<table width="100%" border="0">
		<tr style="line-height:200%;">
			<td width="45%">&nbsp;</td>
			<td width="15%" border="1" style="background-color: #bcd4ee;text-align:center"><b>Print</b></td>
			<td width="15%" border="1" style="background-color: #bcd4ee;text-align:center"><b>% of Circulation</b></td>
			<td width="15%" border="1" style="background-color: #bcd4ee;text-align:center"><b>Digital Nonreplica</b></td>
		</tr>
		<tr>
			<td border="1" colspan="3" style="background-color: #bcd4ee;text-align:left;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paid Subscriptions</strong></td>
			
		</tr>
        '.$paidSubscriptions.'
		
		<tr>
			<td border="1" colspan="3" style="background-color: #bcd4ee;text-align:left;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Verified Subscriptions</strong></td>
			
		</tr>
        '.$verified.'
		
		<tr>
			<td border="1" colspan="3" style="background-color: #bcd4ee;text-align:left;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Single Copy Sales</strong></td>
			
		</tr>
        '.$single.'
		
		<tr>
			<td border="1" colspan="3" style="background-color: #bcd4ee;text-align:left;"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Analyzed Nonpaid</strong></td>
			
		</tr>
        '.$analyzed.'
	</table>';

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

//------- PRICES --------------------------------------------------------------------------------
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
		<tr>
			<td width="60%">
				' . $title_5 . '
				' . $Supplemental . '
                <br><br><br><br><br><br>			
			</td>
		</tr>	
		<tr>
			<td width="49%">
				' . $title_6 . '
				' . $Variance . '	
                <br><br>
				Visit www.auditedmedia.com Media Intelligence Center for audit reports				
			</td>
			
			<td width="2%"></td>
					  
			<td width="49%">	
				' . $title_7 . '
				' . $Prices . '	
				<br><br>
				(1) For statement period<br>
				(2) Represents subscriptions for the 12 month period ended June 30, 2015<br>
				(3) Based on the following issue per year frequency: 10<br>
				<br><br>
				<br><br>
				<br><br>
			
			</td>        
		</tr>		
 </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

// ---------------------- pAGE 2 END--------------------------------------------------
          
// ---------------------- pAGE 3 START--------------------------------------------------

//------- ADDITIONAL DATA --------------------------------------------------------------------------------

$AdditionalData = 
    '<table width="100%" align="left" border="0">   
         <tr>
            <td></td>
		 </tr>    
         <tr>
			<td>Circulation by Regional, Metro & Demographic Editions</td>
         </tr>  		
         <tr>
            <td>Geographic Data
           </td>
         </tr>		 
         <tr>
            <td>Analysis of New & Renewal Paid Individual Subscriptions</td>           
         </tr> 		
         <tr>
            <td>Trend Analysis</td>           
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

require_once('../common/commonData.php');

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
     $title_10.'<table width="100%" align="left" border="0">
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

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="49%">
                ' . $title_8 . '
                ' . $AdditionalData . ' 
				<br><br>
				 ' . $title_9 . '
                 ' . $AdditionalAnalysis . ' 
				 <br><br>
				 ' . $title_10 . '
                ' . $Rate_Base . ' 
            </td>            
            
            <td width="2%"></td>

            <td width="49%">
			' . $title_11 . '
			' . $Notes . ' 
             <br><br><br> 
			' . $Certificate . 			 
            '</td>                
        </tr>        
    </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

// ---------------------- pAGE 3 END--------------------------------------------------

$pdf->lastPage();

// ---------------------------------------------------------

$pdf->Output('hhhhhh.pdf','I');

//============================================================+
// END OF FILE                                                
//============================================================+
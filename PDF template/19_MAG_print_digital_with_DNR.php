<?php

// Include the main TCPDF library (search for installation path).
require_once('../App.php');
require_once('../data/PdfManager.php');
require_once('../libraries/TCPDF/tcpdf_include.php');
require_once('../libraries/TCPDF/tcpdf.php');

/* Card Details */

$card['MEMBER_NUMBER'] = 402610; 
$card['DRIVE_DATE'] = '31-DEC-2016';
$card['PRODUCT_TYPE'] = 'PS';

/* Card Details */

//Procedure Call
$head = PdfManager::p_get_header($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$es = PdfManager::p_get_executive_summary($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$tci = PdfManager::p_get_total_circulation_issue($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$sa = PdfManager::p_get_supply_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$vari = PdfManager::p_get_variance($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$prc = PdfManager::p_get_price_summary_layout($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$aa = PdfManager::p_get_additional_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$cert = PdfManager::p_get_certify($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);


class MYPDF extends TCPDF {
    
    public function Header() { 
        if ($this->page == 1) {
            
            global $head;
            
            // Header Left Side
			$image_file = '../assets/images/logo.jpg'; // *** Very IMP:
			$this->Image($image_file,20,10,50);            
			 
            $this->SetFont('helvetica', 'B', 10);
            $this->Text(20,30,"Publisher's Statement");
            
            $this->SetFont('helvetica', '', 10);
            $this->Text(20,36,"6 months ended December 31, 2015, Subject to Audit");			

			// Header Right Side
			$image_file = '../assets/images/ABA.png'; // *** Very IMP:
			$this->Image($image_file,160,10,50);
            
            //Annual Frequency            
            $this->SetFont('arialnarrowb', '', 7);
            $this->Text(160,25,"Annual Frequency: ");
            
            //Annual Frequency
            $AnuFre = $head['FREQUENCY'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(180,25,"".$AnuFre);
            
            //Field Served
            $this->SetFont('arialnarrowb', '', 7);
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
        
        //Address
        
        $this->SetFont('arialnarrow', 'B', 7);
        $this->Text(80,200,"48 W. Seegers Road lArlington Heights, IL 60005-3913 lT: 224-366-6939 lF: 224-366-6949 lwww.auditedmedia.com");
        
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rinesh Bharath');
$pdf->SetTitle('19 MAG print digital with DNR');
$pdf->SetSubject('19 MAG print digital with DNR');
$pdf->SetKeywords('PDF, 19 MAG print digital with DNR');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set font
$pdf->SetFont('arialnarrow', '', 7); 

// Landscape and A4 is the recommended Page Attributes
$pdf->AddPage('L', 'A4');

$pdf->Ln();

/* Building up the title */

$title_1 = table_cell('  EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$title_2 = table_cell_with_percentage('  DIGITAL NONREPLICA','60%');
$title_3 = table_cell('  TOTAL CIRCULATION BY ISSUE');
$title_4 = table_cell('  DIGITAL NONREPLICA');
$title_5 = table_cell('  SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION');
$title_6 = table_cell('  VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$title_7 = table_cell('  PRICES');
$title_8 = table_cell('  ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER');
$title_9 = table_cell('  ADDITIONAL ANALYSIS OF VERIFIED');
$title_10 = table_cell('  RATE BASE');
$title_11 = table_cell('  NOTES');

/* Building up the title */

/* Styling up the Title */

function table_cell($title){
    $td = '<table width="100%"><tr><td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>'.$title.'</b></td></tr><tr style="line-height: 30%;"><td></td></tr></table>';
    return $td;
}

function table_cell_with_percentage($title, $percentage){
    $td = '<table width="'.$percentage.'"><tr><td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>'.$title.'</b></td></tr><tr style="line-height: 30%;"><td></td></tr></table>';
    return $td;
}

/* Styling up the Title */


//EXEC
if($es) {
$data = '';
$data1 = '';
foreach($es as $res) {
    $data .= '<tr>
                    <td width="20%">'.number_format($res['PARA_1_PAID_VERIF_SUBS']).'</td>
                    <td width="20%">'.number_format($res['PARA_1_SCS']).'</td>
                    <td width="20%">'.number_format($res['PARA_1_PAID_VERIF_ANP_CIRC']).'</td>                  
                    <td width="20%">'.number_format($res['PARA_1_TOTL_RB']).'</td>                  
                    <td width="20%">'.number_format($res['PARA_1_TOTL_VARIANCE_RB']).'</td>                  
				</tr>';
    $data1 .= '<tr>
                    <td width="20%">'.number_format($res['PAR_1_DIGIT_NR_PD_VER_SUBS']).'</td>
                    <td width="20%">'.number_format($res['PARA_1_DIGIT_NON_REPL_SCS']).'</td>
                    <td width="20%">'.number_format($res['PARA_1_DIGIT_NON_REPL_TOTAL']).'</td> 
				</tr>';
    }
}
$Executive_Summary = 
    '<table width="100%"  align="center" border="1">
                <thead>
                     <tr>
                          <td width="20%" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Subscriptions</b></td>
                          <td width="20%" style="background-color: #bcd4ee;"><b><br>Single Copy<br>Sales</b></td>
                          <td width="20%" style="background-color: #bcd4ee;"><b><br>Total<br>Circulation</b></td>                           
                          <td width="20%" style="background-color: #bcd4ee;"><b><br>Rate<br>Base</b></td>                           
                          <td width="20%" style="background-color: #bcd4ee;"><b><br>Variance<br>to Rate Base</b></td>                           
                     </tr>				 
				</thead>
				<tbody>
                    '.$data.'
                </tbody>

    </table>';

$Executive_Summary_Non_Replica = 
    '<table width="100%"  align="center" border="1">
                <thead>
                     <tr>
                          <td width="20%" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Subscriptions</b></td>
                          <td width="20%" style="background-color: #bcd4ee;"><b><br>Single Copy<br>Sales</b></td>
                          <td width="20%" style="background-color: #bcd4ee;"><b><br>Total<br>Circulation</b></td>
                     </tr>				 
				</thead>
				<tbody>
                    '.$data1.'
                </tbody>

    </table>';

//PRINT EXEC
$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="100%">
                ' . $title_1 . '
                ' . $Executive_Summary . '                 
            </td>  
        </tr> 
		<tr>
            <td width="100%">               
                <br><br>
                ' . $title_2 . '
                ' . $Executive_Summary_Non_Replica . '               
            </td>  
        </tr>
		
    </table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//TOTAL CIRC
if($tci){
$table_3_loop ='';
$table_3_loop_avg ='';
$table_3_loop_dn ='';
$table_3_loop_avg_dn ='';
$len = sizeof($tci);
for ($i=0; $i<$len-1; $i++) {
 $res = $tci[$i];
    $table_3_loop .='<tr>
		                  <td border="1"  width="2%">'.$res['SPECIAL_ISSUE'].'</td>
                        <td border="1"  width="11.35%">'.$res['ISSUE_NAME'].'</td>
                        <td border="1"  width="6.65%">'.number_format($res['PAID_SUBS_PRINT']).'</td>
                        <td border="1"  width="6.66%">'.number_format($res['PAID_SUBS_DIGIT']).'</td>
                        <td border="1"  width="6.67%">'.number_format($res['SUBSCRIPTION_COUNT']).'</td>
                        <td border="1"  width="6.68%">'.number_format($res['VERIF_SUBS_PRINT']).'</td>
                        <td border="1"  width="6.68%">'.number_format($res['VERIF_SUBS_DIGIT']).'</td>
                        <td border="1"  width="6.65%">'.number_format($res['VERIF_SUBS']).'</td>
                        <td border="1"  width="6.65%">'.number_format($res['TOTAL_PAID_VERIF_SUBS']).'</td>
                        <td border="1"  width="6.65%">'.number_format($res['SCS_PRINT']).'</td>
                        <td border="1"  width="6.66%">'.number_format($res['SCS_DIGIT']).'</td>
                        <td border="1"  width="6.67%">'.number_format($res['SINGLE_COPY_COUNT']).'</td>
                        <td border="1"  width="6.66%">'.number_format($res['TOTAL_PAID_VERIF_CIRC_PRINT']).'</td>
                        <td border="1"  width="6.68%">'.number_format($res['TOTAL_PAID_VERIF_CIRC_DIGIT']).'</td>
                        <td border="1"  width="6.68%">'.number_format($res['TOTAL_PAID_VERIF_CIRC']).'</td>
    </tr> ';
    $table_3_loop_dn  .= '<tr>
                            <td width="3%">'.$res['SPECIAL_ISSUE'].'</td>
                            <td width="13%">'.$res['ISSUE_NAME'].'</td>
                            <td width="17%">'.number_format($res['PAID_SUBS_DIG_NR']).'</td>
                            <td width="17%">'.number_format($res['VERIF_SUBS_DIG_NR']).'</td>                 
                            <td width="17%">'.number_format($res['TOTAL_PAID_VERIF_SUBS_DIG_NR']).'</td>
                            <td width="17%">'.number_format($res['SCS_DIG_NR']).'</td>
                            <td width="16%">'.number_format($res['TOTAL_PAID_VERIF_CIRC_DIG_NR']).'</td>
                        </tr>';	
    
}
for ($i=$len-1; $i<=$len-1; $i++) {
  $res = $tci[$i];
    $table_3_loop_avg .='<tr>
		                      <td border="1"  width="2%">'.$res['SPECIAL_ISSUE'].'</td>
                            <td border="1"  width="11.35%"><b>'.$res['ISSUE_NAME'].'</b></td>
                            <td border="1"  width="6.65%"><b>'.number_format($res['PAID_SUBS_PRINT']).'</b></td>
                            <td border="1"  width="6.66%"><b>'.number_format($res['PAID_SUBS_DIGIT']).'</b></td>
                            <td border="1"  width="6.67%"><b>'.number_format($res['SUBSCRIPTION_COUNT']).'</b></td>
                            <td border="1"  width="6.68%"><b>'.number_format($res['VERIF_SUBS_PRINT']).'</b></td>
                            <td border="1"  width="6.68%"><b>'.number_format($res['VERIF_SUBS_DIGIT']).'</b></td>
                            <td border="1"  width="6.65%"><b>'.number_format($res['VERIF_SUBS']).'</b></td>
                            <td border="1"  width="6.65%"><b>'.number_format($res['TOTAL_PAID_VERIF_SUBS']).'</b></td>
                            <td border="1"  width="6.65%"><b>'.number_format($res['SCS_PRINT']).'</b></td>
                            <td border="1"  width="6.66%"><b>'.number_format($res['SCS_DIGIT']).'</b></td>
                            <td border="1"  width="6.67%"><b>'.number_format($res['SINGLE_COPY_COUNT']).'</b></td>
                            <td border="1"  width="6.66%"><b>'.number_format($res['TOTAL_PAID_VERIF_CIRC_PRINT']).'</b></td>
                            <td border="1"  width="6.68%"><b>'.number_format($res['TOTAL_PAID_VERIF_CIRC_DIGIT']).'</b></td>
                            <td border="1"  width="6.68%"><b>'.number_format($res['TOTAL_PAID_VERIF_CIRC']).'</b></td>
    </tr> ';
    $table_3_loop_avg_dn  .= '<tr>
                                    <td width="3%"><b>'.$res['SPECIAL_ISSUE'].'</b></td>
                                    <td width="13%"><b>'.$res['ISSUE_NAME'].'</b></td>
                                    <td width="17%"><b>'.number_format($res['PAID_SUBS_DIG_NR']).'</b></td>
                                    <td width="17%"><b>'.number_format($res['VERIF_SUBS_DIG_NR']).'</b></td>                 
                                    <td width="17%"><b>'.number_format($res['TOTAL_PAID_VERIF_SUBS_DIG_NR']).'</b></td>
                                    <td width="17%"><b>'.number_format($res['SCS_DIG_NR']).'</b></td>
                                    <td width="16%"><b>'.number_format($res['TOTAL_PAID_VERIF_CIRC_DIG_NR']).'</b></td>
                            </tr>';	
}
}

$Total_Circulation = 
    '<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
    
<thead>	
  <tr>
    <td border="none" colspan="2">&nbsp;</td>
    <td border="1" colspan="3" style="background-color: #bcd4ee;"><b>Paid Subscriptions</b></td>
    <td border="1" colspan="3" style="background-color: #bcd4ee;"><b>Verified Subscriptions</b></td>
    <td border="1" rowspan="2" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Subscriptions</b></td>
    <td border="1" colspan="3" style="background-color: #bcd4ee;"><b>Single Copy Sales</b></td>
    <td border="1" rowspan="2" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Circulation - Print</b></td>
    <td border="1" rowspan="2" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Circulation<br>- Digital Issue</b></td>
    <td border="1" rowspan="2" style="background-color: #bcd4ee;"><b>Total<br>Paid & Verified<br>Issue Print Circulation</b></td>
  </tr>
  
  <tr>
    <td border="1" colspan="2" style="background-color: #bcd4ee;"><b>Issue</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Print</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Digital<br>Issue</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Total<br>Paid<br>Subscriptions</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Print</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Digital<br>Issue</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Total<br>Verified<br>Subscriptions</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Print</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Digital<br>Issue</b></td>
    <td border="1" style="background-color: #bcd4ee;"><b>Total<br>Single Copy<br>Sales</b></td>
  </tr> 
  </thead>  
  
  <tbody>
    '.$table_3_loop.'
    '.$table_3_loop_avg.'
  </tbody>  
  
</table>';

$Total_Circulation_Non_Replica = 
    '<table align="center" width="100%" border="1" >
                <thead>
                    <tr style="background-color: #bcd4ee; line-Hieght: 12px">
				        <td width="16%"><b><br><br><br>Issue</b></td>
                        <td width="17%"><b><br><br>Paid<br>Subscriptions</b></td>
                        <td width="17%"><b><br><br>Verified<br>Subscriptions</b></td>
                        <td width="17%"><b><br>Total<br>Paid & Verified<br>Subscriptions</b></td>
                        <td width="17%"><b><br><br>Single Copy<br>Sales</b></td>
                        <td width="16%"><b><br>Total<br>Paid & Verified<br>Circulation</b></td>				        
                    </tr>                     			 
				</thead>
				<tbody>
                    '.$table_3_loop_dn.'
                    '.$table_3_loop_avg_dn.'
				</tbody>
    </table>';           



$tot = '
    <table width="100%" cellpadding="0" border="0" >
        <tr>
            <td width="100%">
			    <br><br>
                ' . $title_3 . '
                ' . $Total_Circulation . '                    
                <br>
            </td> 
        </tr>
    </table>';
$totdn = '
    <table width="100%" cellpadding="0" border="0">
		<tr>
            <td width="100%">
                ' . $title_4 . '
                ' . $Total_Circulation_Non_Replica . '                 
            </td> 
        </tr>
		
    </table>';


$totprnt = <<<EOD
    <table width="100%" cellpadding="0" border="0" nobr="true">
        <tr>
            <td width="100%">
			    <br><br>
                $tot            
                <br>
            </td> 
        </tr>
		
    </table>

EOD;
$pdf->writeHTML($totprnt, true, false, false, false, '');

$dnprnt = <<<EOD
    <table width="100%" cellpadding="0" border="0" nobr="true">
		<tr>
            <td width="100%">
               $totdn              
            </td> 
        </tr>
		
    </table>

EOD;
$pdf->writeHTML($dnprnt, true, false, false, false, '');

//Suppli
$paid = '';
$verified = '';
$single = '';
if($sa) {
    
    //PaidSubs ='';
    if($sa['PARA_6_PD_INDV_SUBS_PRINT'] || $sa['PARA_6_PD_INDV_SUBS_DIGIT'] || $sa['PARA_6_PD_INDIV_SUBS'] || $sa['PARA_6_PD_INDIV_SUBS_PCT']){
    $paid .= '<tr>
                    <td border="1" align="left" width="30%">Individual Subscriptions</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_INDV_SUBS_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_INDV_SUBS_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_INDIV_SUBS'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_INDIV_SUBS_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    
    if($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_DIGIT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT']){
      $paid .= '  <tr>
                    <td border="1" align="left" width="30%">Association: Deductible</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_DIGIT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Association: Nondeductible</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBR_DED_DIGIT'] || $sa['PARA_6_PD_CLUB_MEMBER_DED'] || $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Club/Membership: Deductible</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_CLUB_MEMBR_DED_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_CLUB_MEMBER_DED'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_CLUB_MEMBER_DED_PCT'].'</td>
                   <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBR_ND_DIGIT'] || $sa['PARA_6_PD_CLUB_MEMBER_ND'] || $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Club/Membership: Nondeductible</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_CLUB_MEMBR_ND_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_CLUB_MEMBER_ND'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_CLUB_MEMBER_ND_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_PD_DEFER_SUBS_PRINT'] || $sa['PARA_6_PD_DEFER_SUBS_DIGIT'] || $sa['PARA_6_PD_DEFER_SUBS'] || $sa['PARA_6_PD_DEFER_SUBS_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Deferred</td>
                   <td border="1" width="14%">'.$sa['PARA_6_PD_DEFER_SUBS_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_DEFER_SUBS_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_DEFER_SUBS'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_DEFER_SUBS_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    
    if($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] || $sa['PARA_6_PD_PRTNR_SUBS_DED_DIGIT'] || $sa['PARA_6_PD_PARTNER_SUBS_DED'] || $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'] ){
    $paid .= '<tr>
                    <td border="1" align="left" width="30%">Partnership Deductible Subscriptions</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_PRTNR_SUBS_DED_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_PARTNER_SUBS_DED'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_PD_SCHOOL_PRINT'] || $sa['PARA_6_PD_SCHOOL_DIGIT'] || $sa['PARA_6_PD_SCHOOL_SUBS'] || $sa['PARA_6_PD_SCHOOL_SUBS_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">School</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_SCHOOL_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_SCHOOL_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_SCHOOL_SUBS'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_SCHOOL_SUBS_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_PD_SPONS_SALES_PRINT'] || $sa['PARA_6_PD_SPONS_SALES_DIGIT'] || $sa['PARA_6_PD_SPONS_SALES'] || $sa['PARA_6_PD_SPONS_SALES_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Sponsored Subscriptions</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_SPONS_SALES_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_SPONS_SALES_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_PD_SPONS_SALES'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_PD_SPONS_SALES_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_TOTAL_PAID_SUBS_PRINT'] || $sa['PARA_6_TOTAL_PAID_SUBS_DIGIT'] || $sa['PARA_6_TOTAL_PAID_SUBS'] || $sa['PARA_6_TOTAL_PAID_SUBS_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Paid Subscriptions</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS_PRINT'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS_DIGIT'].'</b></td>
                    <td border="1" width="12%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS_PCT'].'</b></td>
                   <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_VERIF_SUBS_PP_PRINT'] || $sa['PARA_6_VERIF_SUBS_PP_DIGIT'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%">Public Place</td>
                    <td border="1" width="14%">'.$sa['PARA_6_VERIF_SUBS_PP_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_VERIF_SUBS_PP_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_VERIF_SUBS_PUBL_PL'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_VERIF_SUBS_IU_PRINT'] || $sa['PARA_6_VERIF_SUBS_IU_DIGIT'] || $sa['PARA_6_VERIF_SUBS_IND_USE'] || $sa['PARA_6_VERIF_SUBS_IND_USE_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%">Individual Use</td>
                    <td border="1" width="14%">'.$sa['PARA_6_VERIF_SUBS_IU_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_VERIF_SUBS_IU_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_VERIF_SUBS_IND_USE'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_VERIF_SUBS_IND_USE_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_TOT_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOT_VERIF_SUBS_DIGIT'] || $sa['PARA_6_TOTAL_VERIF_SUBS'] || $sa['PARA_6_TOTAL_VERIF_SUBS_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Verified Subscriptions</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOT_VERIF_SUBS_PRINT'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOT_VERIF_SUBS_DIGIT'].'</b></td>
                    <td border="1" width="12%"><b>'.$sa['PARA_6_TOTAL_VERIF_SUBS'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_VERIF_SUBS_PCT'].'</b></td>
                   <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOT_PD_VERIF_SUBS_DIGIT'] || $sa['PARA_6_TOTAL_PD_VERIF_SUBS'] || $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Paid & Verified Subscrptions</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOT_PD_VERIF_SUBS_DIGIT'].'</b></td>
                    <td border="1" width="12%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_SUBS'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'].'</b></td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_SCS_PRINT'] || $sa['PARA_6_SCS_DIGIT'] || $sa['PARA_6_SINGLE_ISSUE_SALES'] || $sa['PARA_6_SINGLE_ISSUE_SALES_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%">Single Issue</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_SINGLE_ISSUE_SALES'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SINGLE_ISSUE_SALES_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>
';
    }
    if($sa['PARA_6_SCS_PARTNER_DED_PRINT'] || $sa['PARA_6_SCS_PARTNER_DED_DIGIT'] || $sa['PARA_6_SCS_PARTNERSHIP_DED'] || $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%">Partnership Deductible Single Issue</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_PARTNER_DED_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_PARTNER_DED_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_SCS_PARTNERSHIP_DED'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_PARTNERSHIP_DED_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_SCS_SPONS_SALES_PRINT'] || $sa['PARA_6_SCS_SPONS_SALES_DIGIT'] || $sa['PARA_6_SCS_SPONS_SALES'] || $sa['PARA_6_SCS_SPONS_SALES_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%">Sponsored Single Issue</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_SPONS_SALES_PRINT'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_SPONS_SALES_DIGIT'].'</td>
                    <td border="1" width="12%">'.$sa['PARA_6_SCS_SPONS_SALES'].'</td>
                    <td border="1" width="14%">'.$sa['PARA_6_SCS_SPONS_SALES_PCT'].'</td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_TOTAL_SCS_PRINT'] || $sa['PARA_6_TOTAL_SCS_DIGIT'] || $sa['PARA_6_TOTAL_SCS'] || $sa['PARA_6_TOTAL_SCS_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Single Copy Sales</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_SCS_PRINT'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_SCS_DIGIT'].'</b></td>
                    <td border="1" width="12%"><b>'.$sa['PARA_6_TOTAL_SCS'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_SCS_PCT'].'</b></td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    if($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'] || $sa['PARA_6_TOT_PD_VERIF_CIRC_DIGIT'] || $sa['PARA_6_TOTAL_PD_VERIF_CIRC'] || $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Paid & Verified Circulation</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOT_PD_VERIF_CIRC_DIGIT'].'</b></td>
                    <td border="1" width="12%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_CIRC'].'</b></td>
                    <td border="1" width="14%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'].'</b></td>
                    <td border="1" width="16%"></td>
                </tr>';
    }
    
    
}
$Suppli_Analy ='
	<table width="100%"  align="center" border="0">
    
        <thead>
             <tr>
                  <td border="1" width="30%" border="none"></td>
                  <td border="1" width="14%" border="1" style="background-color: #bcd4ee;"><b><br>Print</b></td>
                  <td border="1" width="14%" border="1" style="background-color: #bcd4ee;"><b>Digital<br>Issue</b></td>
                  <td border="1" width="12%" border="1" style="background-color: #bcd4ee;"><b><br>Total</b></td>
                  <td border="1" width="14%" border="1" style="background-color: #bcd4ee;"><b><br>% of Circulation</b></td>
                  <td border="1" width="16%" border="1" style="background-color: #bcd4ee;"><b><br>Digital Nonreplica</b></td>
             </tr>
             
             <tr>
                  <td border="1" border="1" colspan="4" width="100%" style="background-color: #bcd4ee;" align="left">Paid Subscriptions</td>			                          
             </tr>				 
        </thead>

        <tbody>
          '.$paid.'
            <tr>
                    <td border="1" colspan="4" width="100%" style="background-color: #bcd4ee;" align="left">Verified Subscriptions</td>
            </tr>
            '.$verified.'
            <tr>
                    <td border="1" colspan="4" width="100%" style="background-color: #bcd4ee;" align="left">Single Copy Sales</td>
            </tr>
            '.$single.'
       </tbody>
    
	</table>';

//Variance

if($vari) {
$data = '';
foreach($vari as $res) {
    $data .='<tr>
                <td align="center">'.$res['DRIVE_DATE'].'</td>
                <td align="center">'.number_format($res['RATE_BASE']).'</td>
                <td align="center">'.number_format($res['AUDIT_REPORT']).'</td>
                <td align="center">'.number_format($res['PUBLISHERS_STATEMENT']).'</td>
                <td align="center">'.number_format($res['DIFFERENCE']).'</td>
                <td align="center">'.number_format($res['PERCENTAGE_OF_DIFFERENCE']).'s</td>
            </tr>';
}	 
}

$Variance ='<table width="100%"  align="center" border="1">

        <thead>
             <tr>
                  <td width="30%" style="background-color: #bcd4ee;"><b>Audit Period<br>Ended</b></td>
                  <td width="14%" style="background-color: #bcd4ee;"><b><br>Rate Base</b></td>
                  <td width="14%" style="background-color: #bcd4ee;"><b><br>Audit Report</b></td>             
                  <td width="12%" style="background-color: #bcd4ee;"><b>Publisher’s<br>Statements</b></td>
                  <td width="14%" style="background-color: #bcd4ee;"><b><br>Difference</b></td>
                  <td width="16%" style="background-color: #bcd4ee;"><b>Percentage<br>of Difference</b></td>                 
             </tr>		 
        </thead>

        <tbody>
            '.$data.'
        </tbody>  
    
	</table>';	
	
//Prices

if($prc) {
$avg_single_cpy = 0;
$subscription = 0;
$avg_subs_price_net = 0;
$avg_subs_price_gross = 0;
$avg_subs_price_copy_net = 0;
$avg_subs_price_copy_gross = 0;

foreach($prc as $res) {
    $avg_single_cpy += $res['AVERAGE_SINGLE_COPY'];
    $subscription += $res['SUBSCRIPTION'];
    $avg_subs_price_net += $res['AVG_SUB_PRI_NET'];
    $avg_subs_price_gross += $res['AVG_SUBCRB_PRI_GROSS'];
    $avg_subs_price_copy_net += $res['AVG_SUBCRB_PCPY_NET'];
    $avg_subs_price_copy_gross += $res['AVG_SUBCRB_PCPY_GROSS'];
}
}
$prices='';
$prices .='<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" border="none" width="50%" >&nbsp;</td>
    <td rowspan="2" border="1" width="17%" style="background-color: #bcd4ee;"><b><br>Suggested<br>Retail Prices (1)</b></td>
    <td colspan="2" border="1"  border="1" width="33%" style="background-color: #bcd4ee;"><b>Average Price (2)</b></td>
  </tr>
  <tr>
    <td border="1"  style="background-color: #bcd4ee;"><b><br>Net</b></td>
    <td border="1"  style="background-color: #bcd4ee;"><b>Gross<br>(Optional)</b></td>
  </tr>
  <tr>
    <td border="1" >Average Single Copy</td>
    <td border="1" >'.number_format($avg_single_cpy).'</td>
    <td border="1"  rowspan="2">&nbsp;</td>
    <td border="1"  rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td border="1" >Subscription</td>
    <td border="1" >'.number_format($subscription).'</td>
  </tr>
  <tr>
    <td border="1" >Average Subscription Price Annualized (3)</td>
    <td border="1"  rowspan="2">&nbsp;</td>
    <td border="1" >'.number_format($avg_subs_price_net).'</td>
    <td border="1" >'.number_format($avg_subs_price_gross).'</td>
  </tr>
  <tr>
    <td border="1" >Average Subscription Price per Copy</td>
    <td border="1" >'.number_format($avg_subs_price_copy_net).'</td>
    <td border="1" >'.number_format($avg_subs_price_copy_gross).'</td>
  </tr>
</table>';

//Additional Data

$additional_data = 
    '<table width="100%" align="left" border="0">
        <tr>
            <td>Circulation by Regional, Metro & Demographic Editions</td>
		</tr>
        <tr>
            <td>Geographic Data</td>
		</tr>
        <tr>
            <td>Analysis of New & Renewal Paid Individual Subscriptions</td>
        </tr>
        <tr>
            <td>Trend Analysis.</td>
        </tr>
    </table>';

//Additional Analysis
if($aa) {
$mavs_6A = '';
$mavs_6B = '';
foreach($aa as $res) {
    if($res['MAVS_PARAGRAPH'] === '6A') {
        $mavs_6A .= '<tr>
                            <td  border="1" style="text-align:left;"  width="30.7%">'.$res['DESCRIPTION'].'</td>
                            <td  border="1" style="text-align:center;"  width="23%">'.number_format($res['MAVS_VERIF_SUBS_PRINT']).'</td>
                            <td  border="1" style="text-align:center;"  width="23%">'.number_format($res['MAVS_VERIF_SUBS_DIGIT']).'</td>
                            <td  border="1" style="text-align:center;" width="23%">'.number_format($res['MAVS_VERIF_SUBS']).'</td>
                        </tr>';
    }
}

foreach($aa as $res) {
    if($res['MAVS_PARAGRAPH'] === '6B') {
        $mavs_6B .= '<tr>
                            <td  border="1" style="text-align:left;"  width="30.7%">'.$res['DESCRIPTION'].'</td>
                            <td  border="1" style="text-align:center;"  width="23%">'.number_format($res['MAVS_VERIF_SUBS_PRINT']).'</td>
                            <td  border="1" style="text-align:center;"  width="23%">'.number_format($res['MAVS_VERIF_SUBS_DIGIT']).'</td>
                            <td  border="1" style="text-align:center;" width="23%">'.number_format($res['MAVS_VERIF_SUBS']).'</td>
                        </tr>';
    }
}
}
$additional_analy =	'';
$additional_analy .='<table width="100%"  align="center" border="0">
				<thead>
				 <tr>
					  <td border="none" width="30.7%"></td>
					  <td border="1" width="23%" style="background-color: #bcd4ee;"><b><br>Print</b></td>
					  <td border="1" width="23%" style="background-color: #bcd4ee;"><b>Digital<br>Issue</b></td>                           
					  <td border="1" width="23%" style="background-color: #bcd4ee;"><b><br>Total</b></td> 
				 </tr>
				 <tr>
					  <td border="1" colspan="4" style="background-color: #bcd4ee;" align="left">  Public Place</td>			                          
				 </tr>				 
				</thead>
				<tbody>	
				    '.$mavs_6A.'
                    <tr>
					  <td border="1" colspan="4" style="background-color: #bcd4ee;" align="left">  Individual Use</td>			                          
				    </tr>	
                     '.$mavs_6A.'	
				</tbody>
				</table>';

//Rate Base
$rate_base = '<table width="100%" align="left" border="0">
        <tr>
            <td>Rate base shown in Executive Summary is for combined paid and verified & analyzed nonpaid circulation.</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td>Rate Base Change(s):</td>
        </tr>
        <tr>
            <td>100,000 through August 2015, 150,000 starting September 2015</td>
        </tr>
        <tr>
            <td>150,000 through October 2015, 200,000 starting November 2015</td>
        </tr>
         <tr>
            <td></td>
		</tr>
        <tr>
            <td>Additional Rate Bases:</td>
		</tr>
        <tr>
            <td>Paid and Verified: 700,000</td>
		</tr>
        <tr>
            <td>Analyzed Nonpaid: 100,000</td>
		</tr>
        <tr>
            <td></td>
		</tr>
        <tr>
            <td>Rate Base Notes: Rate base including feature/special issues: 915,000. Feature issues with higher rate bases: 9/29 rate base 900,000; 12/1 rate base 925,000; 12/22 rate base 950,000. Special issues with higher rate bases: Gorgeous at Any Age rate base 950,000.</td>
		</tr>        
    </table>';

$sup_right = <<<EOD
    <table width="100%" cellpadding="0" border="0" nobr="true">
		<tr>
			<td width="49%">
                    $title_5
                    $Suppli_Analy					
			</td>
			
			<td width="2%"></td>
					  
			<td width="49%">				
                    $title_6
                    $Variance
				<br><br>
				    Visit www.auditedmedia.com Media Intelligence Center for audit reports
				<br><br>
                    $title_7
                    $prices
				<br><br>
                    (1) For statement period<br>
                    (2) Represents subscriptions for the 12 month period ended June 30, 2015<br>
                    (3) Based on the following issue per year frequency: 10<br>
				<br><br>
                    $title_8
                    $additional_data
			</td>        
		</tr>
            <br>
 </table>
EOD;
$pdf->writeHTML($sup_right, true, false, false, false, '');

$base_additional = <<<EOD
    <table width="100%" cellpadding="0" border="0" nobr="true">
		<tr>
			<td width="49%">
				$title_9
                <br><br>
                $additional_analy				
			</td>
			
			<td width="2%"></td>
					  
			<td width="49%">				
				    $title_10
					$rate_base
				<br><br>
			</td>        
		</tr>
 </table>
EOD;
$pdf->writeHTML($base_additional, true, false, false, false, '');

          
//Notes

$table11 = 
    '<table width="100%" align="left" border="0" nobr="true">       
         <tr>
			<td><b>Award Point Subscriptions:</b> Included in Paid Subscriptions Individual is the following average number of copies<br>
			purchased through the redemption of award points: 10, 450
			</td>
         </tr>  
		 <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>Combination Subscriptions:</b>Included in Paid Subscriptions Individual are copies served to subscribers who<br>
purchased this publication in combination with one or more different publications.
           </td>
         </tr>
		 <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>Partnership Deductible:</b> These copies shown in Supplemental Analysis of Average Circulation represent copies<br>
served where the subscription was included in purchases of other products or services. The consumer could receive<br>
a rebate instead of the subscription.</td>           
         </tr> 
		 <tr>
            <td></td>
		</tr>
		
         <tr>
            <td><b>Sponsored Subscriptions:</b> These copies shown in Supplemental Analysis of Average Circulation represent copies<br>
purchased by a third party in quantities of 11 or more for distribution to consumers.</td>           
         </tr>
		 <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>Association: Deductible:</b> These copies shown in Paid Subscriptions represent copies served where the subscription<br>
was included in the dues of an association. The subscription was deductible from dues.</td>           
         </tr> 
		 <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>Post Expiration Copies:</b> Included in Paid Subscriptions is the following average number of copies served to<br>
subscribers post expiration pending renewal: 3,700</td>           
         </tr>  
		 <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>Pursuant to a review by the AAM Board of Directors,</b> copies distributed through the Next Issue Media Unlimited<br>
program are reported as single copy sales based on consumer payment for the program and consumer’s request<br>
for a specific magazine. Included in Single Copy Sales Digital is the following average copies per issue from this<br>
program: 1,500</td>           
         </tr> 
		 <tr>
            <td></td>
		</tr>
		 <tr>
            <td><b>Average nonanalyzed nonpaid for period: </b>9,500</td>           
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
            <td><b>(additional disclosures as required will also appear)</b></td>           
        </tr>   
    </table>';


//Certify


$table12 = '<table width="90%" style="border: 1px solid black">
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
            <td colspan="2"> Parent Company: '.$cert['PARENT_COMPANY'].'</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"> '.$cert['PUBL_ADDR'].'</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>  
        <tr>
            <td> Name: '.$cert['PARA_12_NAME1'].' </td>
            <td> Name: '.$cert['PARA_12_NAME2'].'</td>
        </tr> 
        <tr>
            <td> Director: '.$cert['PARA_12_TITLE1'].'</td>
            <td> Publisher: '.$cert['PARA_12_TITLE2'].'</td>
        </tr>
        <tr>
            <td> Date Signed:</td>
            <td> Sales Offices: '.$cert['SALES_OFFICE'].'</td>
        </tr>
        <tr>            
            <td> '.$cert['PHON_FAX_URL'].'</td>
            <td></td>
        </tr>
        <tr>            
            <td> Established: '.$cert['ESTABLISHED'].'</td>
            <td> AAM Member since: '.$cert['MEM_SINCE'].'</td>
        </tr>    
        <tr>
            <td></td>
        </tr>
    </table>';

$notes_certify = <<<EOD
    <table width="100%" cellpadding="0" border="0" nobr="true">
        <tr>
            <td width="49%">
			<br>
                $title_11
                $table11                 
                    <br><br>               
            </td>            
            
            <td width="2%"></td>

            <td width="49%">
                     $table12         
            </td>                
        </tr>        
    </table>
EOD;
$pdf->writeHTML($notes_certify, true, false, false, false, '');


$pdf->lastPage();

$pdf->Output('hhhhhh.pdf','I');

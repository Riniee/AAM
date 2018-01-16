<?PHP
// Include the main TCPDF library 
require_once('../App.php');
require_once('../data/PdfManager.php');
require_once('../libraries/TCPDF/tcpdf_include.php');
require_once('../libraries/TCPDF/tcpdf.php');

/* Card Details */

$card['MEMBER_NUMBER'] = 411550; 
$card['DRIVE_DATE'] = '30-JUN-2016';
$card['PRODUCT_TYPE'] = 'PS';

/* Card Details */

// Procedure Calls to Oracle Database Stored Procedure
$head = PdfManager::p_get_header($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$es = PdfManager::p_get_executive_summary($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$tci = PdfManager::p_get_total_circulation_issue($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$sa = PdfManager::p_get_supply_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$vari = PdfManager::p_get_variance($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$prc = PdfManager::p_get_price_summary_layout($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$aa = PdfManager::p_get_additional_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$rb = PdfManager::p_get_rate_base($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$rbc = PdfManager::p_get_ratebase_changes($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$cert = PdfManager::p_get_certify($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);


class MYPDF extends TCPDF {
    //Page Header
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
        
        $this->SetFont('arialnarrow', 'B', 7);
        $this->Text(115,200,"48 W. Seegers Road,Arlington Heights, IL 60005-3913.");
        
        //Contact Website
        $this->SetFont('arialnarrow', 'B', 7);
        $this->Text(113,203,"T: 224-366-6939 F: 224-366-6949 www.auditedmedia.com");
    
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sathish Kumar');
$pdf->SetTitle('2mag_print_digital');
$pdf->SetSubject('2mag_print_digital');
$pdf->SetKeywords('PDF, 2mag_print_digital');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('arialnarrow', '', 7); 

// add a page
$pdf->AddPage('L', 'A4');

/* Setting up the Title */
$table_1_header = table_cell('EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$table_2_header = table_cell('TOTAL CIRCULATION BY ISSUE');
$table_3_header = table_cell_3('SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION','97');
$table_4_header = table_cell('VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$table_5_header = table_cell('PRICES');
$table_6_header = table_cell_3('ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER','98');
$table_7_header = table_cell('ADDITIONAL ANALYSIS OF VERIFIED');
$table_8_header = table_cell('RATE BASE');
$table_9_header = table_cell('NOTES');
$table_10_header = '';
/* Setting up the Title */


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

function empty_row(){
    $tr='<tr><td></td></tr>';
    return $tr;
}


//Executive_Summary
if($es) {
$data = '';
foreach($es as $res) {
        $data .= ' <tr>
                        <td width="20%" align="center">'.number_format($res['PARA_1_PAID_VERIF_SUBS']).' </td>
                        <td width="20%" align="center">'.number_format($res['PARA_1_SCS']).'</td>
                        <td width="20%" align="center">'.number_format($res['PARA_1_PAID_VERIF_ANP_CIRC']).'</td>
                        <td width="20%" align="center">'.number_format($res['PARA_1_TOTL_RB']).'</td>
                        <td width="20%" align="center">'.number_format($res['PARA_1_TOTL_VARIANCE_RB']).'</td>
                    </tr>';
}
}
$Executive_Summary = '<table width="100%" border="1">
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
                   '.$data.'
                </tbody>
            </table>';

//Total_Circlulation
if($tci) {
$table_2_loop ='';
$len = sizeof($tci);
for ($i=0; $i<$len-1; $i++) {
 $res = $tci[$i];
 $table_2_loop .='<tr style="background-color: #fff; color:#1a1a1a; text-align:center;">
                        <td border="1"  width="2%"></td>
                        <td border="1"  width="6%">'.$res['ISSUE_NAME'].'</td>
                        <td border="1"  width="6%">'.number_format($res['PAID_SUBS_PRINT']).'</td>
                        <td border="1"  width="6%">'.number_format($res['PAID_SUBS_DIGIT']).'</td>
                        <td border="1"  width="8%">'.number_format($res['SUBSCRIPTION_COUNT']).'</td>
                        <td border="1"  width="6%">'.number_format($res['VERIF_SUBS_PRINT']).'</td>
                        <td border="1"  width="6%">'.number_format($res['VERIF_SUBS_DIGIT']).'</td>
                        <td border="1"  width="8%">'.number_format($res['VERIF_SUBS']).'</td>
                        <td border="1"  width="8%">'.number_format($res['TOTAL_PAID_VERIF_SUBS']).'</td>
                        <td border="1"  width="6%">'.number_format($res['SCS_PRINT']).'</td>
                        <td border="1"  width="6%">'.number_format($res['SCS_DIGIT']).'</td>
                        <td border="1"  width="8%">'.number_format($res['SINGLE_COPY_COUNT']).'</td>
                        <td border="1"  width="8%">'.number_format($res['TOTAL_PAID_VERIF_CIRC_PRINT']).'</td>
                        <td border="1"  width="8%">'.number_format($res['TOTAL_PAID_VERIF_CIRC_DIGIT']).'</td>
                        <td border="1"  width="8%">'.number_format($res['TOTAL_PAID_VERIF_CIRC']).'</td>
                    </tr>';
}

$table_2_loop_avg = '';
for ($i=$len-1; $i<=$len-1; $i++) {
  $res = $tci[$i];
  $table_2_loop_avg .= '<tr style=" text-align:center;">
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
$Total_Circulation = '<table width="100%" border="0">
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
                    <tbody>
                        '.$table_2_loop.'
                        '.$table_2_loop_avg.'  
                    </tbody>
                </table>';


$tbl1 = '<table width="100%" cellpadding="0" border="0" >
        <tr>
            <td>
                ' . $table_1_header . '
                ' . $Executive_Summary . '
                <br>
            </td>
        </tr>
        <tr>
            <td>
                ' . $table_2_header . '
                ' . $Total_Circulation . '
            </td>
        </tr>
    </table>';

$pdf->writeHTML($tbl1, true, false, false, false, '');



$empty_row = empty_row();

//Suppli
$paid = '';
$verified = '';
$single = '';
if($sa) {
    
    //PaidSubs ='';
    if($sa['PARA_6_PD_INDV_SUBS_PRINT'] || $sa['PARA_6_PD_INDV_SUBS_DIGIT'] || $sa['PARA_6_PD_INDIV_SUBS'] || $sa['PARA_6_PD_INDIV_SUBS_PCT']){
    $paid .= '<tr>
                    <td border="1" align="left" width="30%">Individual Subscriptions</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_INDV_SUBS_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_INDV_SUBS_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_INDIV_SUBS'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_INDIV_SUBS_PCT'].'</td>
                </tr>';
    }
    
    if($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_DIGIT'] || $sa['PARA_6_PD_ASSOC_SUBS_DED'] || $sa['PARA_6_PD_ASSOC_SUBS_DED_PCT']){
      $paid .= '  <tr>
                    <td border="1" align="left" width="30%">Association: Deductible</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_ASSOC_SUBS_DED_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_DIGIT'] || $sa['PARA_6_PD_ASSOC_SUBS_ND'] || $sa['PARA_6_PD_ASSOC_SUBS_ND_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Association: Nondeductible</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_ASSOC_SUBS_ND_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBR_DED_DIGIT'] || $sa['PARA_6_PD_CLUB_MEMBER_DED'] || $sa['PARA_6_PD_CLUB_MEMBER_DED_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Club/Membership: Deductible</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_CLUB_MEMBR_DED_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_CLUB_MEMBER_DED'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_CLUB_MEMBER_DED_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'] || $sa['PARA_6_PD_CLUB_MEMBR_ND_DIGIT'] || $sa['PARA_6_PD_CLUB_MEMBER_ND'] || $sa['PARA_6_PD_CLUB_MEMBER_ND_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Club/Membership: Nondeductible</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_CLUB_MEMBR_ND_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_CLUB_MEMBER_ND'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_CLUB_MEMBER_ND_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_PD_DEFER_SUBS_PRINT'] || $sa['PARA_6_PD_DEFER_SUBS_DIGIT'] || $sa['PARA_6_PD_DEFER_SUBS'] || $sa['PARA_6_PD_DEFER_SUBS_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Deferred</td>
                   <td border="1" width="18%">'.$sa['PARA_6_PD_DEFER_SUBS_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_DEFER_SUBS_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_DEFER_SUBS'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_DEFER_SUBS_PCT'].'</td>
                </tr>';
    }
    
    if($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] || $sa['PARA_6_PD_PRTNR_SUBS_DED_DIGIT'] || $sa['PARA_6_PD_PARTNER_SUBS_DED'] || $sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'] ){
    $paid .= '<tr>
                    <td border="1" align="left" width="30%">Partnership Deductible Subscriptions</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_PRTNR_SUBS_DED_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_PARTNER_SUBS_DED'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_PARTNER_SUBS_DED_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_PD_SCHOOL_PRINT'] || $sa['PARA_6_PD_SCHOOL_DIGIT'] || $sa['PARA_6_PD_SCHOOL_SUBS'] || $sa['PARA_6_PD_SCHOOL_SUBS_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">School</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_SCHOOL_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_SCHOOL_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_SCHOOL_SUBS'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_SCHOOL_SUBS_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_PD_SPONS_SALES_PRINT'] || $sa['PARA_6_PD_SPONS_SALES_DIGIT'] || $sa['PARA_6_PD_SPONS_SALES'] || $sa['PARA_6_PD_SPONS_SALES_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%">Sponsored Subscriptions</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_SPONS_SALES_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_SPONS_SALES_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_PD_SPONS_SALES'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_PD_SPONS_SALES_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_TOTAL_PAID_SUBS_PRINT'] || $sa['PARA_6_TOTAL_PAID_SUBS_DIGIT'] || $sa['PARA_6_TOTAL_PAID_SUBS'] || $sa['PARA_6_TOTAL_PAID_SUBS_PCT']){
        $paid .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Paid Subscriptions</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS_PRINT'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS_DIGIT'].'</b></td>
                    <td border="1" width="16%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_PAID_SUBS_PCT'].'</b></td>
                </tr>';
    }
    if($sa['PARA_6_VERIF_SUBS_PP_PRINT'] || $sa['PARA_6_VERIF_SUBS_PP_DIGIT'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL'] || $sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%">Public Place</td>
                    <td border="1" width="18%">'.$sa['PARA_6_VERIF_SUBS_PP_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_VERIF_SUBS_PP_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_VERIF_SUBS_PUBL_PL'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_VERIF_SUBS_PUBL_PL_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_VERIF_SUBS_IU_PRINT'] || $sa['PARA_6_VERIF_SUBS_IU_DIGIT'] || $sa['PARA_6_VERIF_SUBS_IND_USE'] || $sa['PARA_6_VERIF_SUBS_IND_USE_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%">Individual Use</td>
                    <td border="1" width="18%">'.$sa['PARA_6_VERIF_SUBS_IU_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_VERIF_SUBS_IU_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_VERIF_SUBS_IND_USE'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_VERIF_SUBS_IND_USE_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_TOT_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOT_VERIF_SUBS_DIGIT'] || $sa['PARA_6_TOTAL_VERIF_SUBS'] || $sa['PARA_6_TOTAL_VERIF_SUBS_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Verified Subscriptions</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOT_VERIF_SUBS_PRINT'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOT_VERIF_SUBS_DIGIT'].'</b></td>
                    <td border="1" width="16%"><b>'.$sa['PARA_6_TOTAL_VERIF_SUBS'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_VERIF_SUBS_PCT'].'</b></td>
                </tr>';
    }
    if($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'] || $sa['PARA_6_TOT_PD_VERIF_SUBS_DIGIT'] || $sa['PARA_6_TOTAL_PD_VERIF_SUBS'] || $sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT']){
        $verified .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Paid & Verified Subscrptions</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOT_PD_VERIF_SUBS_DIGIT'].'</b></td>
                    <td border="1" width="16%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_SUBS'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_SUBS_PCT'].'</b></td>
                </tr>';
    }
    if($sa['PARA_6_SCS_PRINT'] || $sa['PARA_6_SCS_DIGIT'] || $sa['PARA_6_SINGLE_ISSUE_SALES'] || $sa['PARA_6_SINGLE_ISSUE_SALES_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%">Single Issue</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_SINGLE_ISSUE_SALES'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SINGLE_ISSUE_SALES_PCT'].'</td>
                </tr>
';
    }
    if($sa['PARA_6_SCS_PARTNER_DED_PRINT'] || $sa['PARA_6_SCS_PARTNER_DED_DIGIT'] || $sa['PARA_6_SCS_PARTNERSHIP_DED'] || $sa['PARA_6_SCS_PARTNERSHIP_DED_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%">Partnership Deductible Single Issue</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_PARTNER_DED_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_PARTNER_DED_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_SCS_PARTNERSHIP_DED'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_PARTNERSHIP_DED_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_SCS_SPONS_SALES_PRINT'] || $sa['PARA_6_SCS_SPONS_SALES_DIGIT'] || $sa['PARA_6_SCS_SPONS_SALES'] || $sa['PARA_6_SCS_SPONS_SALES_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%">Sponsored Single Issue</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_SPONS_SALES_PRINT'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_SPONS_SALES_DIGIT'].'</td>
                    <td border="1" width="16%">'.$sa['PARA_6_SCS_SPONS_SALES'].'</td>
                    <td border="1" width="18%">'.$sa['PARA_6_SCS_SPONS_SALES_PCT'].'</td>
                </tr>';
    }
    if($sa['PARA_6_TOTAL_SCS_PRINT'] || $sa['PARA_6_TOTAL_SCS_DIGIT'] || $sa['PARA_6_TOTAL_SCS'] || $sa['PARA_6_TOTAL_SCS_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Single Copy Sales</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_SCS_PRINT'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_SCS_DIGIT'].'</b></td>
                    <td border="1" width="16%"><b>'.$sa['PARA_6_TOTAL_SCS'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_SCS_PCT'].'</b></td>
                </tr>';
    }
    if($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'] || $sa['PARA_6_TOT_PD_VERIF_CIRC_DIGIT'] || $sa['PARA_6_TOTAL_PD_VERIF_CIRC'] || $sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT']){
        $single .= '<tr>
                    <td border="1" align="left" width="30%"><b>Total Paid & Verified Circulation</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOT_PD_VERIF_CIRC_DIGIT'].'</b></td>
                    <td border="1" width="16%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_CIRC'].'</b></td>
                    <td border="1" width="18%"><b>'.$sa['PARA_6_TOTAL_PD_VERIF_CIRC_PCT'].'</b></td>
                </tr>';
    }
    
    
}
    

$suppl_analy ='
	<table width="97%"  align="center" border="0">
    
        <thead>
             <tr>
                  <td border="1" width="30%" border="none"></td>
                  <td border="1" width="18%" border="1" style="background-color: #bcd4ee;"><b><br>Print</b></td>
                  <td border="1" width="18%" border="1" style="background-color: #bcd4ee;"><b>Digital<br>Issue</b></td>
                  <td border="1" width="16%" border="1" style="background-color: #bcd4ee;"><b><br>Total</b></td>
                  <td border="1" width="18%" border="1" style="background-color: #bcd4ee;"><b><br>% of Circulation</b></td>
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
$variance = '<table width="100%" border="1">
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


$Prices = '<table width="100%" border="0" style="text-align:center">
                <thead>
                    <tr>
                        <td width="50%" rowspan="2"></td>
                        <td border="1"  width="17%"rowspan="2" style="background-color: #bcd4ee;"><b><br>Suggested <br> Retail Prices (1)</b></td>
                        <td border="1"  colspan="2" width="33%" style="background-color: #bcd4ee;">
                            <b>Average Price(2)</b>
                        </td>
                    </tr>
                    <tr style="background-color: #bcd4ee;">
                        <td border="1"  width="17%"><b><br>Net</b></td>
                        <td border="1"  width="16%">
                            <b>Gross <br> (Optional)</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-weight:thin;">
                        <td border="1"   width="50%" align="left"> Average Single Copy</td>
                        <td border="1"   width="17%">$'.number_format($avg_single_cpy).'</td>
                        <td border="1"  rowspan="2" width="17%"></td>
                        <td border="1"  rowspan="2" width="16%"></td>
                    </tr>
                    <tr>
                        <td border="1"  width="50%" align="left"> Subscription</td>
                        <td border="1"  width="17%">$'.number_format($subscription).'</td>

                    </tr>
                    <tr>
                        <td border="1"  width="50%" align="left"> Average Subscription Price Annualized (3) </td>
                        <td border="1"  rowspan="2" width="17%"></td>
                        <td border="1"  width="17%">$'.number_format($avg_subs_price_net).'</td>
                        <td border="1"  width="16%">$'.number_format($avg_subs_price_gross).'</td>
                    </tr>
                    <tr>
                        <td border="1"  width="50%" align="left"> Average Subscription Price per Copy</td>
                        <td border="1"  width="17%">$'.number_format($avg_subs_price_copy_net).'</td>
                        <td  border="1" width="16%">$'.number_format($avg_subs_price_copy_gross).'</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tr><td></td></tr>
            </table>';
$main_left = '<table width="97%" border="0" style="text-align:left;">
                <thead>
                    '.$table_3_header.'
                </thead>
                <tbody>
                    '.$suppl_analy.'
                  
                </tbody>
            </table>';

$main_right = '<table width="100%">
                    <tr>
                        <td>
                            '.$table_4_header.'
                            '.$variance.'
                            <br><br>  Visit www.auditedmedia.com Media Intelligence Center for audit reports<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            '.$table_5_header.'
                            '.$Prices.'
                            <br><br>  (1) For statement period<br>
                            (2) Represents subscriptions for the 12 month period ended June 30, 2015<br>
                            (3) Based on the following issue per year frequency: 10<br>
                        </td>
                    </tr>
            </table>';
// $main includes tables 3, 4 & 5
$main = <<<EOD
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
$pdf->writeHTML($main, true, false, false, false, '');


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
$additional_analy = 
    '<table width="100%" border="0">
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
//Rate Base
$rate_base =
    '<table width="100%" align="left" border="0">
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
            <td>Rate Base Notes: Rate base including feature/special issues: 915,000. Feature issues with higher rate bases: 9/29 rate base 900,000; 12/1 rate base 925,000; 12/22 rate base 950,000. Special issues with higher rate bases: Gorgeous at Any Age rate base 950,000.</td>
		</tr>        
    </table>';

$additional = <<<EOD
        <table width="100%" border="0" nobr="true">
                    <tr>
                        <td>$table_6_header
                        $additional_data
                        </td>
                        <td>
                        $table_8_header
                        $rate_base   
                        </td>
                    </tr>
                        <br><br>
                    <tr>
                        <td>
                        $table_7_header
                        $additional_analy
                        </td>
                    </tr>
                    <br><br>
                    
                </table>
EOD;
 $pdf->writeHTML($additional, true, false, false, false, '');


//Notes
$notes = '<table width="100%" align="left" border="0">
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



//Certify

$certify = '<table width="90%" style="border: 1px solid black">
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

$notes_table = '<table width="100%" style="background-color: #fff;color:#1a1a1a;">
                    <tr>
                        <td>
                            '.$table_9_header.'
                            '.$notes.'
                        </td>
                    </tr>
                    <br><br><br>
                    <tr>
                        <td width="1%"></td>
                        <td width="99%">
                        '.$table_10_header.'
                        '.$certify.'
                        </td>
                    </tr>
                </table>';


$notesprint = <<<EOD
    <table width="100%" border="0" nobr="true">
                    <tr>
                        <td width="50%">
                            $notes_table
                        </td>
                    </tr>
            </table>;
EOD;
 $pdf->writeHTML($notesprint, true, false, false, false, '');

$pdf->lastPage();

$pdf->Output('hhhhhh.pdf','I');

?>

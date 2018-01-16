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
$sup = PdfManager::p_get_supply_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$var = PdfManager::p_get_variance($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$rb = PdfManager::p_get_rate_base($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$rbc = PdfManager::p_get_ratebase_changes($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
$cert = PdfManager::p_get_certify($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
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
            $AnuFre = $head['NP_FREQUENCY'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(180,25,"".$AnuFre);
            
            //Field Served
            $this->SetFont('arialnarrowb', '', 7);
            $this->Text(160,30,"Field Served: ");
            
            //Field Served Value
            $Field = $head['NP_FIELD_SERVED'];
            $this->SetFont('arialnarrow', '', 7);
            $this->MultiCell(110,5,"".$Field,'','','','',177,30);                
            
            //Published By
            $Publish = $head['NP_PUBLISHED_BY'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(160,38,"Published By ".$Publish);
            
		} else {}

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

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rinesh Bharath');
$pdf->SetTitle('14 CNTL print digital');
$pdf->SetSubject('TcPdf');
$pdf->SetKeywords('PDF, 14 CNTL print digital');


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

// Table Properties -----------------------------------------------------------------------------

/* Setting up the Title */
$title_1 = table_cell('  EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$title_2 = table_cell('  TOTAL CIRCULATION BY ISSUE');
$title_3 = table_cell('  SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION');
$title_4 = table_cell('  VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$title_5 = table_cell('  ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER');
$title_6 = table_cell('  NOTES');
$title_7 = table_cell('  RATE BASE');
/* Setting up the Title */

/* Styling up the Title */
function table_cell($title){
    $td = '
    <table width="100%">
        <tr>
            <td style="color:#fff; background-color:#0244A1; font-size: 10px;"><b>'.$title.'</b></td>
        </tr>
        <tr style="line-height: 30%;">
            <td></td>
        </tr>
    </table>';
    return $td;
}
/* Styling up the Title */

/* Supplemental Analysis - Common dAtA Appending*/
function commonSAData($title, $print, $digi, $total, $circ, $bold = false) {
	if ($bold) {
		$title = '<b>' . $title . '</b>';
	}
	return '
    <tr>
		<td width="40%" border="1" align="left">' . $title . '</td>
		<td width="15%" border="1">' . $print . '</td>		
		<td width="15%" border="1">' . $digi . '</td>
        <td width="15%" border="1">' . $total . '</td>
        <td width="15%" border="1">' . $circ . '</td>
	</tr>';
}
/* Supplemental Analysis - Common dAtA Appending*/

/* Variance - Number Formatting */
function checktype($data) {
    if($data == 'None Claimed') {
        return $data;
    }
    else {
        return number_format($data);
    }
}
/* Variance - Number Formatting */


// Table Properties -----------------------------------------------------------------------------

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

if($es){
    $data = '';
    foreach($es as $row) {
        $data .= '<tr>
                <td border="1">'. number_format($row['NP_PARA_1_A_TOTAL_ANP']) .'</td>
                <td border="1">'. number_format($row['NP_PARA_1_TOTL_RB']) .'</td>
                <td border="1">'. number_format($row['NP_PARA_1_TOTL_VARIANCE_RB']) .'</td>
            </tr>';	
    }
}

$Executive_Summary = 
    '<table width="100%"  align="center" border="1">
                <thead>
                     <tr>
                          <td width="34%" style="background-color: #bcd4ee;"><b><br>Total Analyzed <br> Nonpaid Circulation</b></td>
                          <td width="32%" style="background-color: #bcd4ee;"><b><br>Rate <br> Base</b></td>
                          <td width="34%" style="background-color: #bcd4ee;"><b><br>Variance <br> to Rate Base</b></td>                           
                     </tr>				 
				</thead>' . $data . '
    </table>';           

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

//------- TOTAL CIRCULATION--------------------------------------------------------------------------

if($tci) {
    $len = sizeof($tci);

    $data = '';
    for ($i=0; $i<$len-1; $i++) {
        $row = $tci[$i];
	    $data .= '<tr>
                     <td border="1">' . $row['NPC_SPECIAL_ISSUE'] . '</td>
                     <td border="1">' . $row['NPC_ISSUE_NAME'] . '</td>
                     <td border="1">' . number_format($row['NPC_TOTAL_ANP_PRINT']) . '</td>
                     <td border="1">' . number_format($row['NPC_TOTAL_ANP_DIG_REPL']) . '</td>
                     <td border="1">' . number_format($row['NPC_TOTAL_ANP']) . '</td>
                 </tr>';	
    }

    $avg = '';
    for ($i=$len-1; $i<=$len-1; $i++) {
        $row = $tci[$i];
        $avg .= '<tr style="font-weight:bold;">
                    <td border="1">' . $row['NPC_SPECIAL_ISSUE'] . '</td>
                    <td border="1">' . $row['NPC_ISSUE_NAME'] . '</td>
                    <td border="1">' . number_format($row['NPC_TOTAL_ANP_PRINT']) . '</td>
                    <td border="1">' . number_format($row['NPC_TOTAL_ANP_DIG_REPL']) . '</td>
                    <td border="1">' . number_format($row['NPC_TOTAL_ANP']) . '</td>
                </tr>';
    }

}

$Total_Circulation = 
    '<table align="center" width="100%" border="0">
                <thead>
                    <tr>				       
                        <td border="none" width="15%"></td>                        
				        <td border="1" width="85%" colspan="4" style="background-color: #bcd4ee;"><b>Analyzed Nonpaid</b></td>
                    </tr>
                     <tr>
                          <td border="1"  width="5%" style="background-color: #bcd4ee;"></td>
                          <td border="1"  width="10%" style="background-color: #bcd4ee;"><b><br><br>Issue</b></td>
                          <td border="1"  width="25%" style="background-color: #bcd4ee;"><b><br><br>Print</b></td>
                          <td border="1"  width="30%" style="background-color: #bcd4ee;"><b><br>Digital<br>Issue</b></td>
                          <td border="1"  width="30%" style="background-color: #bcd4ee;"><b>Total<br>Analyzed<br> Nonpaid</b></td>                          
                     </tr>				 
				</thead>' . $data . '  ' . $avg . '				
    </table>';           

//------- TOTAL CIRCULATION--------------------------------------------------------------------------

//------- SUPPLEMENTAL ANALYSIS----------------------------------------------------------------------

if($sup) {
    
    $data = '';    
        
    if($sup['NP_PARA_1_LIST_PRINT'] || $sup['NP_PARA_1_LIST_DIG_REPL'] || $sup['NP_PARA_1_LIST_SOURCE'] || $sup['NP_PARA_1_LIST_SOURCE_PCT']) {
        $data .= commonSAData('List', $sup['NP_PARA_1_LIST_PRINT'], $sup['NP_PARA_1_LIST_DIG_REPL'], $sup['NP_PARA_1_LIST_SOURCE'], $sup['NP_PARA_1_LIST_SOURCE_PCT']);            
    }
    if($sup['NP_PARA_1_MKT_COV_PRINT'] || $sup['NP_PARA_1_MKT_COV_DIG_REPL'] || $sup['NP_PARA_1_MKT_COV'] || $sup['NP_PARA_1_MKT_COV_PCT']) {
        $data .= commonSAData('Market Coverage', $sup['NP_PARA_1_MKT_COV_PRINT'], $sup['NP_PARA_1_MKT_COV_DIG_REPL'], $sup['NP_PARA_1_MKT_COV'], $sup['NP_PARA_1_MKT_COV_PCT']);            
    }
    if($sup['NP_PARA_1_BULK_PRINT'] || $sup['NP_PARA_1_BULK_DIG_REPL'] || $sup['NP_PARA_1_BULK'] || $sup['NP_PARA_1_BULK_PCT']) {
        $data .= commonSAData('Nonpaid Bulk', $sup['NP_PARA_1_BULK_PRINT'], $sup['NP_PARA_1_BULK_DIG_REPL'], $sup['NP_PARA_1_BULK'], $sup['NP_PARA_1_BULK_PCT']);            
    }
    if($sup['NP_PARA_1_DEL_HOST_PROD_PRINT'] || $sup['NP_PARA_1_DELHOSTPROD_DIG_REPL'] || $sup['NP_PARA_1_DEL_HOST_PROD'] || $sup['NP_PARA_1_DEL_HOST_PROD_PCT']) {
        $data .= commonSAData('Delivered with Host Product', $sup['NP_PARA_1_DEL_HOST_PROD_PRINT'], $sup['NP_PARA_1_DELHOSTPROD_DIG_REPL'], $sup['NP_PARA_1_DEL_HOST_PROD'], $sup['NP_PARA_1_DEL_HOST_PROD_PCT']);            
    }
    if($sup['NP_PARA_1_TOTAL_ANP_PRINT'] || $sup['NP_PARA_1_TOTAL_ANP_DIG_REPL'] || $sup['NP_PARA_1_TOTAL_ANP'] || $sup['NP_PARA_1_TOTAL_ANP_PCT']) {
        $data .= commonSAData('Total Analyzed Nonpaid', $sup['NP_PARA_1_TOTAL_ANP_PRINT'], $sup['NP_PARA_1_TOTAL_ANP_DIG_REPL'], $sup['NP_PARA_1_TOTAL_ANP'], $sup['NP_PARA_1_TOTAL_ANP_PCT']);            
    }
    
}

$Supplemental_Analysis = 
    '<table align="center" width="100%" border="0">
                <thead>
                    <tr>
				        <td border="none" width="40%"></td>
				        <td border="1"  width="15%" style="background-color: #bcd4ee;"><b><br>Print</b></td>
                        <td border="1"  width="15%" style="background-color: #bcd4ee;"><b>Digital<br>Issue</b></td>
                        <td border="1"  width="15%" style="background-color: #bcd4ee;"><b><br>Total</b></td>
                        <td border="1"  width="15%" style="background-color: #bcd4ee;"><b><br>% of Circulation</b></td>
                    </tr>
                </thead>    
                
                <tbody>
                    <tr>
                        <td border="1"  colspan="5" align="left" style="background-color: #bcd4ee;"><b>  Analyzed Nonpaid</b></td>
                    </tr>' . $data .'            
				</tbody>
    </table>';

//------- SUPPLEMENTAL ANALYSIS----------------------------------------------------------------------

//------- VARIANCE --------------------------------------------------------------------------------

if($var) {
    $data = '';
    foreach($var as $row) {
        $data .= '<tr>
                <td width="16%">' .$row['DRIVE_DATE']. '</td>
                <td width="17%">' .checktype($row['RATE_BASE']). '</td>
                <td width="17%">' .number_format($row['AUDIT_REPORT']). '</td>                 
                <td width="17%">' .number_format($row['PUBLISHERS_STATEMENT']). '</td>
                <td width="17%">' .number_format($row['DIFFERENCE']). '</td>
                <td width="16%">' .number_format($row['PERCENTAGE_OF_DIFFERENCE']). '</td>
            </tr>';	
    }
}

$Variance = 
    '<table align="center" width="100%" border="1">
                <thead>
                    <tr style="background-color: #bcd4ee;">
				        <td width="16%"><b>Audit Period<br>Ended</b></td>
                        <td width="17%"><b><br>Rate Base</b></td>
                        <td width="17%"><b><br>Audit Report</b></td>
                        <td width="17%"><b>Publisher’s<br>Statements</b></td>
                        <td width="17%"><b><br>Difference</b></td>
                        <td width="16%"><b>Percentage of<br>Difference</b></td>				        
                    </tr>                     			 
				</thead>' . $data . '
    </table>';           

//------- VARIANCE --------------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="49%">
                ' . $title_1 . '
                ' . $Executive_Summary . ' 
                    <br><br>
                ' . $title_3 . '
                ' . $Supplemental_Analysis . '
            </td>
            <td width="2%"></td>
            <td width="49%">                
                '. $title_2 .'
                '. $Total_Circulation .'
                    <br><br>
                '. $title_4 .'
                '. $Variance .'
            </td>            
        </tr>
    </table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

//------- ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER---------------------------

$Additional_Data = 
    '<table width="100%"  align="left" border="0">
		<tr>
            <td>Circulation by Regional, Metro & Demographic Editions</td>
		</tr>
        <tr>
            <td width="100%">Geographic Data</td>
        </tr>
        <tr>
            <td width="100%">Trend Analysis</td>
        </tr>
        <tr>
            <td></td>
		</tr>
    </table>';  

//------- ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER---------------------------

//------- NOTES ----------------------------------------------------------------------------------

$Notes = 
    '<table width="100%" align="left" border="0">       
         <tr>
            <td><b>Included in Paid Circulation are copies obtained through individual subscriptions, sponsorship sale subscriptions
and single copy sales.</b></td>
         </tr>            
         <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>Included in Verified Circulation are copies distributed to individually addressed.</b></td>
         </tr>
         <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>Included in Analyzed Nonpaid Circulation are copies of list, market coverage and nonpaid bulk.</b></td>           
         </tr>
          <tr>
            <td></td>
		</tr>
        <tr>
            <td><b>* Special issue circulation not included in averages.</b></td>
		</tr>
    </table>';

//------- NOTES ----------------------------------------------------------------------------------

//------- RATE BASE --------------------------------------------------------------------------------

require_once('../common/commonData.php');

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
		</tr>' . $ratebasenotes . '                
    </table>';

//------- RATE BASE --------------------------------------------------------------------------------

//------- CERTIFICATE --------------------------------------------------------------------------------

if($cert) {
    $Certificate = '<table width="90%" style="border: 1px solid black">
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
            <td colspan="2"> Parent Company: '.$cert['NP_PARENT_COMPANY'].'</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"> '.$cert['NP_PUBL_ADDR'].'</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>  
        <tr>
            <td> Name: '.$cert['NP_PARA_12_NAME1'].' </td>
            <td> Name: '.$cert['NP_PARA_12_NAME2'].'</td>
        </tr> 
        <tr>
            <td> Director: '.$cert['NP_PARA_12_TITLE1'].'</td>
            <td> Publisher: '.$cert['NP_PARA_12_TITLE2'].'</td>
        </tr>
        <tr>
            <td> Date Signed:</td>
            <td> Sales Offices: </td>
        </tr>
        <tr>            
            <td colspan="2"> '.$cert['NP_P_F_URL'].'</td>
            <td></td>
        </tr>
        <tr>            
            <td> Established: '.$cert['NP_ESTABLISHED'].'</td>
            <td> AAM Member since: '.$cert['NP_MEM_SINCE'].'</td>
        </tr>    
        <tr>
            <td></td>
        </tr>
    </table>';
}

//------- CERTIFICATE --------------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="49%">
                ' . $title_5 . '
                ' . $Additional_Data . '                
                    <br><br>               
                ' . $title_7 . '
                ' . $Rate_Base . '
            </td>            
            
            <td width="2%"></td>

            <td width="49%">
                ' . $title_6 . '
                ' . $Notes . '                
                    <br><br>                
                ' . $Certificate . '                
            </td>                
        </tr>        
    </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$pdf->lastPage();

// ---------------------------------------------------------

$pdf->Output('hhhhhh.pdf','I');

//============================================================+
// END OF FILE                                                
//============================================================+
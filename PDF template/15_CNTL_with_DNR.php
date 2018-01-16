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

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rinesh Bharath');
$pdf->SetTitle('15 CNTL with DNR');
$pdf->SetSubject('TCPDF');
$pdf->SetKeywords('PDF, 15 CNTL with DNR');


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
$title_2 = table_cell('  DIGITAL NONREPLICA');
$title_3 = table_cell('  SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION');
$title_4 = table_cell('  ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER');
$title_5 = table_cell('  RATE BASE');
$title_6 = table_cell('  NOTES');
$title_7 = table_cell('  TOTAL CIRCULATION BY ISSUE');
$title_8 = table_cell('  DIGITAL NONREPLICA');
$title_9 = table_cell('  VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
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
function table_cell_2($title,$size){
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
/* Styling up the Title */

/* Supplemental Analysis - Common dAtA Appending*/
function commonSAData($title, $print, $circ,$dgnr, $bold = false) {
	if ($bold) {
		$title = '<b>' . $title . '</b>';
	}
	return '<tr>
		<td width="50%" border="1">' . $title . '</td>
		<td width="25%" border="1">' . $print . '</td>
		<td width="25%" border="1">' . $circ . '</td>
		<td width="25%" border="1">' . $dgnr . '</td>
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

if($es) {
    
    $data = '';
    foreach($es as $row) {
	$data .= '<tr>
                    <td width="34%">'.number_format($row['NP_PARA_1_A_TOTAL_ANP']).'</td>
                    <td width="32%">'.number_format($row['NP_PARA_1_TOTL_RB']).'</td>
                    <td width="34%">'.number_format($row['NP_PARA_1_TOTL_VARIANCE_RB']).'</td>                  
				</tr>';	
    }

}
    
$Executive_Summary = $title_1.'<table width="100%" border="1">
                <thead>
                    <tr style="line-height: 10px;">
                          <td width="34%" style="background-color: #bcd4ee;"><b><br>Total Analyzed <br> Nonpaid Circulation</b></td>
                          <td width="32%" style="background-color: #bcd4ee;"><b><br>Rate <br> Base</b></td>
                          <td width="34%" style="background-color: #bcd4ee;"><b><br>Variance <br> to Rate Base</b></td>                           
                     </tr>
                </thead>
                <tbody>
                    ' . $data . '
                </tbody>
            </table>';

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

if($es) {
    
    $data = '';
    foreach($es as $row) {
	$data .= '<tr>
				  <td width="34%" align="center">'.number_format($row['NP_PARA_1_TOTAL_ANP_DIG_NR']).'</td>				        
              </tr>';	
    }

}

$Digital_Nonreplica1 = 
    '<table align="center" width="100%" border="1">
                <thead>
                    <tr style="line-height: 18px;">
				        <td style="background-color: #bcd4ee; line-height: 10px;" width="34%"><b>Total Analyzed <br> Nonpaid  Circulation</b></td>				        
                    </tr>
                </thead>    
                
                <tbody>                 
                        ' . $data . '          
				</tbody>
    </table>';

//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

//------- SUPPLEMENTAL ANALYSIS-----------------------------------------------------------------------

if ($sup) {
    
	$data = '';
	if ($sup['PARA_6_ANP_LIST_SOURCE_PRINT'] || $sup['NP_PARA_1_LIST_PRINT'] || $sup['NP_PARA_1_LIST_SOURCE_PCT'] || $sup['NP_PARA_1_LIST_DIG_NR']) {
		$data .= commonSAData('List', $sup['NP_PARA_1_LIST_PRINT'], $sup['NP_PARA_1_LIST_SOURCE_PCT'],$sup['NP_PARA_1_LIST_DIG_NR']);
	}
	if ($sup['PARA_6_ANP_MKT_COV_PRINT'] || $sup['NP_PARA_1_MKT_COV_PRINT'] || $sup['NP_PARA_1_MKT_COV_PCT'] || $sup['NP_PARA_1_MKT_COV_DIG_NR']) {
		$data .= commonSAData('Market Coverage', $sup['NP_PARA_1_MKT_COV_PRINT'], $sup['NP_PARA_1_MKT_COV_PCT'], $sup['NP_PARA_1_MKT_COV_DIG_NR']);
	}
	if ($sup['PARA_6_ANP_BULK_PRINT'] || $sup['NP_PARA_1_BULK_PRINT'] || $sup['NP_PARA_1_BULK_PCT'] || $sup['NP_PARA_1_BULK_DIG_NR']) {
		$data .= commonSAData('Nonpaid Bulk', $sup['NP_PARA_1_BULK_PRINT'], $sup['NP_PARA_1_BULK_PCT'], $sup['NP_PARA_1_BULK_DIG_NR']);
	}
	if ($sup['PARA_6_ANP_DEL_HOST_PROD_PRINT'] || $sup['NP_PARA_1_DEL_HOST_PROD_PRINT'] || $sup['NP_PARA_1_DEL_HOST_PROD_PCT'] || $sup['NP_PARA_1_DEL_HOST_PROD_DIG_NR']) {
		$data .= commonSAData('Delivered with Host Product', $sup['NP_PARA_1_DEL_HOST_PROD_PRINT'], $sup['NP_PARA_1_DEL_HOST_PROD_PCT'], $sup['NP_PARA_1_DEL_HOST_PROD_DIG_NR']);
	}
	if ($sup['PARA_6_TOTAL_ANP_PRINT'] || $sup['NP_PARA_1_TOTAL_ANP_PRINT'] || $sup['NP_PARA_1_TOTAL_ANP_PCT'] || $sup['NP_PARA_1_TOTAL_ANP_DIG_NR']) {
		$data .= commonSAData('Total analyzed Nonpaid', $sup['NP_PARA_1_TOTAL_ANP_PRINT'], $sup['NP_PARA_1_TOTAL_ANP_PCT'], $sup['NP_PARA_1_TOTAL_ANP_DIG_NR'], true);
	}

$Supplemental_Analysis = 
    '<table align="center" width="100%" border="0">
                <thead>
                    <tr style="line-height: 15px;">
				        <td border="none" width="40%"></td>
				        <td border="1"  width="20%" style="background-color: #bcd4ee;"><b>Print</b></td>
                        <td border="1"  width="20%" style="background-color: #bcd4ee;"><b>% of Circulation</b></td>
                        <td border="1"  width="20%" style="background-color: #bcd4ee;"><b>Digital Nonreplica</b></td>
                    </tr>
                </thead>    
                
                <tbody>
                    <tr>
                        <td align="left" colspan="3" style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Analyzed Nonpaid</b></td>
                    </tr> ' .$data. '               
				</tbody>
    </table>'; 
}

//------- SUPPLEMENTAL ANALYSIS-----------------------------------------------------------------------

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
    </table>'; 

//------- ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER---------------------------

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

//------- TOTAL CIRCULATION--------------------------------------------------------------------------

if($tci) {
    
    $len = sizeof($tci);
    $data = '';
    for ($i=0; $i<$len-1; $i++) {
        $row = $tci[$i];
        $data .= '
            <tr align="center">
                <td border="1"  width="5%">' . $row['NPC_SPECIAL_ISSUE'] . '</td>
                <td border="1"  width="35%">' . $row['NPC_ISSUE_NAME'] . '</td>
                <td border="1"  width="60%">' . number_format($row['NPC_TOTAL_ANP_PRINT']) . '</td>			
            </tr>';	
        
    $avg = '';
    for ($i=$len-1; $i<=$len-1; $i++) {
            $row = $tci[$i];
            $avg .= '
            <tr style="font-weight:bold;" align="center">                
                <td border="1"  width="5%">' . $row['NPC_SPECIAL_ISSUE'] . '</td>
                <td border="1"  width="35%">' . $row['NPC_ISSUE_NAME'] . '</td>
                <td border="1"  width="60%">' . number_format($row['NPC_TOTAL_ANP_PRINT']) . '</td>			
            </tr>';
        
}
        
$Total_Circulation = 
    '<table align="center" width="100%" border="0">
          <thead>
              <tr>
                <td border="none"  width="40%"></td>
				<td border="1"  width="60%" style="background-color: #bcd4ee;">Print</td>
              </tr>
              <tr style="line-height: 10px;">
                <td border="1"  width="40%" style="background-color: #bcd4ee;"><b><br><br>Issue</b></td>
                <td border="1"  width="60%" style="background-color: #bcd4ee;"><b><br>Analyzed <br> Nonpaid</b></td>
              </tr>				 
        </thead>  ' . $data . ' ' . avg . '
    </table>';              
}

//------- TOTAL CIRCULATION--------------------------------------------------------------------------
    
//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

if($tci){
    
    $len = sizeof($tci);
    $data = '';
    for ($i=0; $i<$len-1; $i++) {
        $row = $tci[$i];
        $data .= '
            <tr align="center">
                <td border="1"  width="5%">' . $row['NPC_SPECIAL_ISSUE'] . '</td>
                <td border="1"  width="35%">' . $row['NPC_ISSUE_NAME'] . '</td>
                <td border="1"  width="60%">' . number_format($row['NPC_TOTAL_ANP_DIG_NR']) . '</td>			
            </tr>';	
        
    $avg = '';
    for ($i=$len-1; $i<=$len-1; $i++) {
            $row = $tci[$i];
            $avg .= '
            <tr style="font-weight:bold;" align="center">                
                <td border="1"  width="5%">' . $row['NPC_SPECIAL_ISSUE'] . '</td>
                <td border="1"  width="35%">' . $row['NPC_ISSUE_NAME'] . '</td>
                <td border="1"  width="60%">' . number_format($row['NPC_TOTAL_ANP_PRINT']) . '</td>			
            </tr>';
        
}

$Digital_Nonreplica2 = 
    '<table align="center" width="100%" border="1">
            <thead>
                <tr style="line-height: 10px;">
                    <td width="50%" style="background-color: #bcd4ee;"><b><br><br>Issue</b></td>
                    <td width="50%" style="background-color: #bcd4ee;"><b>Total<br>Analyzed Nonpaid<br>Circulation</b></td>               
                </tr>				 
		    </thead> ' . $data . ' ' . avg . '
    </table>';
}
    
//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

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
            <td colspan="2"> '.$cert['PHON_FAX_URL'].'</td>
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
}

//------- CERTIFICATE --------------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="49%">
                ' . $title_1 . '
                ' . $Executive_Summary . '
                	<br><br>
                ' . $title_2 . '
                ' . $Digital_Nonreplica1 . '
                    <br><br>
                ' . $title_3 . '
                ' . $Supplemental_Analysis . '
                    <br><br>
                ' . $title_4 . '
                ' . $Additional_Data . '
                ' . $title_5 . '
                ' . $Rate_Base. '
                ' . $title_6 . '
                ' . $Notes. '
            </td>
            
            <td width="2%"></td>
                      
            <td width="49%">
                ' . $title_7 . '
                ' . $Total_Circulation . '
                    <br><br>
                ' . $title_8 . '
                ' . $Digital_Nonreplica2 . '
                    <br><br>
                ' . $title_9 . '
                ' . $Variance . '
                    <br><br>
                ' . $Certificate . '
                    <br><br>
            </td>        
        </tr>
    </table>';

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$pdf->writeHTML($tbl, true, false, false, false, '');

//-------------------------------------------------------------------------------------

$pdf->lastPage();

// ---------------------------------------------------------

$pdf->Output('hhhhhh.pdf','I');

//============================================================+
// END OF FILE                                                
//============================================================+

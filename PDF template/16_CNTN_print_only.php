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
			$image_file = '../assets/images/logo.jpg'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,15,10,50);            
			 
            $this->SetFont('arialnarrow', 'B', 10);
            $this->Text(15,28,"Publisher's Statement");
            
            $this->SetFont('arialnarrow', '', 10);
            $this->Text(15,33,"6 months ended December 31, 2015, Subject to Audit");
			//$this->Cell(0, 0, "Publisher's Statement", 0, false, 'L', 0, '', 0, false, 'M', 'M');

			// Header Right Side
			$image_file = '../assets/images/ABA.png'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,160,10,50);
            
            //Annual Frequency
            $this->SetFont('arialnarrowb', 'B', 7);
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
            $this->SetFont('helvetica', '', 7);
            $this->MultiCell(110,5,"".$Field,'','','','',177,30);
            
            //Published By
            $Publish = $head['PUBLISHED_BY'];
            $this->SetFont('arialnarrow', '', 7);
            $this->Text(160,38,"Published by " .$Publish);
			
		} else {
			$this->SetMargins(10, 10, 10, true);
		}

    }

    // Page footer
    public function Footer() {
        
        //Address
        
        $this->SetFont('arialnarrow', 'B', 7);
        $this->Text(80,200,"48 W. Seegers Road lArlington Heights, IL 60005-3913 lT: 224-366-6939 lF: 224-366-6949 lwww.auditedmedia.com");
        
        //Contact Website
        $this->SetFont('arialnarrow', 'B', 7);
        $this->Text(113,203,"T: 224-366-6939 F: 224-366-6949 www.auditedmedia.com");
        
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sathish Kumar');
$pdf->SetTitle('16 CNTN print only');
$pdf->SetSubject('TcPdf');
$pdf->SetKeywords('PDF,16 CNTN print only');


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
$pdf->SetFont('arialnarrow', '',8); 

// Landscape and A4 is the recommended Page Attributes
$pdf->AddPage('L', 'A4');

$pdf->Ln();

// Table Properties -----------------------------------------------------------------------------

/* Setting up the Title */

$title_1 = table_cell('  EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$title_2 = table_cell('  TOTAL CIRCULATION BY ISSUE');
$title_3 = table_cell('  RATE BASE');
$title_4 = table_cell('  NOTES');

/* Setting up the Title */

/* Styling up the Title */
function table_cell($title){
    $td = '
    <table width="100%">
        <tr>
            <td style="color:#fff; background-color:#0244A1;font-weight:bold;">'.$title.'</td>
        </tr>
        <tr style="line-height: 30%;">
            <td></td>
        </tr>
    </table>';
    return $td;
}
function table_cell_2($title, $size){
    $td = '
    <table width="'.$size.'%">
        <tr>
            <td style="color:#fff; background-color:#0244A1; font-size: 11.3px;"><b>'.$title.'</b></td>
        </tr>
        <tr style="line-height: 30%;">
            <td></td>
        </tr>
    </table>';
    return $td;
}
/* Styling up the Title */

// Table Properties -----------------------------------------------------------------------------

// ---------------------- pAGE 1 START---------------------------------------------------------------------------
    
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

$Executive_Summary = 
    '<table width="100%"  align="center" border="1">
                <thead>
                     <tr>
                          <td height="30"  width="34%" style="background-color: #bcd4ee;"><b><br>Total Analyzed<br> Nonpaid Circulation</b></td>
                          <td height="30"  width="32%" style="background-color: #bcd4ee;"><b><br>Rate<br> Base</b></td>
                          <td height="30" width="34%" style="background-color: #bcd4ee;"><b><br>Variance<br> to Rate Base</b></td>                           
                     </tr>				 
				</thead>
                <tbody>
                    '.$data.'
                </tbody>
				

    </table>';

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

//------- TOTAL CIRCULATION BY ISSUE--------------------------------------------------------------------------

if($tci) {
    $data='';
    $len = sizeof($tci);
    for ($i=0; $i<$len-1; $i++) {
     $row = $tci[$i];
        $data.= '<tr>
                    <td border="1" width="5%">'.$row['NPC_SPECIAL_ISSUE'].'</td>
                    <td border="1" width="35%">'.$row['NPC_ISSUE_NAME'].'</td>
                    <td border="1" width="60%">'.number_format($row['NPC_TOTAL_ANP_PRINT']).'</td>			
                </tr>';	
    }
    $avg = '';
    for ($i=$len-1; $i<=$len-1; $i++) {
      $row = $tci[$i];

        $avg .= '<tr>
                    <td border="1" width="5%">'.$row['NPC_SPECIAL_ISSUE'].'</td>
                    <td border="1" width="35%">'.$row['NPC_ISSUE_NAME'].'</td>
                    <td border="1" width="60%">'.number_format($row['NPC_TOTAL_ANP_PRINT']).'</td>			
                </tr>';	
    }
}

$Total_Circulation = 
    '<table align="center" width="100%" border="0">
                <thead>
                    <tr>
				        <td border="none" width="40%"></td>
				        <td border="1" width="60%" colspan="2" style="background-color: #bcd4ee;">Print</td>
                    </tr>
                     <tr>
                          <td border="1" height="30" width="40%" style="background-color: #bcd4ee;"><b><br>Issue</b></td>
                          <td border="1" height="30" width="60%" style="background-color: #bcd4ee;"><b>Analyzed<br>Nonpaid</b></td>                          
                     </tr>				 
				</thead>
                <tbody>
                    '.$data.' '.$avg.'
                </tbody>
    </table>';

//------- TOTAL CIRCULATION--------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="49%">
                ' . $title_1 . '
                ' . $Executive_Summary . '
            </td>
            
            <td width="2%"></td>
                      
            <td width="49%">
                ' . $title_2 . '
                ' . $Total_Circulation . '
                    <br>
            </td>        
        </tr>
    </table>';


$pdf->writeHTML($tbl, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

//--------RATE BASE------------------------------------------------------------------------------

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

//------- NOTES --------------------------------------------------------------------------------

$Notes = 
    '<table width="100%" align="left" border="0">       
         <tr>
            <td><b>Average nonanalyzed nonpaid for period:</b>9,500</td>
         </tr>            
         <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>* Special issue circulation not included in averages.</b></td>
         </tr>
         <tr>
            <td></td>
		</tr>
         <tr>
            <td><b>(additional disclosures as required will also appear)</b></td>           
         </tr>         
    </table>';

//------- NOTES  --------------------------------------------------------------------------------

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
}

//------- CERITIFICATE --------------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="49%">
                ' . $title_3 . '
                ' . $Rate_Base . '
            </td>            
            
            <td width="2%"></td>

            <td width="49%">
                ' . $title_4 . '
                ' . $Notes . '                
            <br><br><br><br><br><br>                
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
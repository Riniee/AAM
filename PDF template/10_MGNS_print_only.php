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
$prc = PdfManager::p_get_price_summary_layout($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
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
$pdf->SetAuthor('Sri Krishna');
$pdf->SetTitle('10_MGNS_print_only');
$pdf->SetSubject('TcPdf');
$pdf->SetKeywords('PDF, Dummy');


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

// add a page
$pdf->AddPage('L', 'A4');

$pdf->Ln();

// Table Properties -----------------------------------------------------------------------------

/* Setting up the Title */
$title_1 = table_cell('  EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$title_2 = table_cell('  TOTAL CIRCULATION BY ISSUE');
$title_3 = table_cell('  PRICES');
$title_4 = table_cell('  NOTES');
$title_5 = table_cell('  RATE BASE');

/* Setting up the Title */

/* Styling up the Title */
function table_cell($title) {
    $td = '
    <table width="100%">
        <tr>
            <td style="color:#fff; background-color:#0f4a9e;font-weight:bold;">'.$title.'</td>
        </tr>
        <tr style="line-height: 30%;">
            <td></td>
        </tr>
    </table>';
    return $td;
}
/* Styling up the Title */

// Table Properties -----------------------------------------------------------------------------

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

if($es) {
    $data = '';
    foreach($es as $row) {
        $data .= '<tr>
                <td border="1">'. number_format($row['PARA_1_PAID_VERIF_SUBS']) .'</td>
                <td border="1">'. number_format($row['PARA_1_SCS']) .'</td>
                <td border="1">'. number_format($row['PARA_1_TOTAL_ANP_CIRC']) .'</td>
                <td border="1">'. number_format($row['PARA_1_PAID_VERIF_ANP_CIRC']) .'</td>
                <td border="1">'. number_format($row['PARA_1_TOTL_VARIANCE_RB']) .'</td>
                <td border="1">'. number_format($row['PARA_1_TOTL_VARIANCE_RB']) .'</td>
                <td border="1">'. number_format($row['PARA_1_PAID_VERIF_CIRC']) .'</td>
            </tr>';	
    }
}
    $Executive_Summary =
        '<table width="100%"  align="center" border="1">
            <thead>
                 <tr style="background-color:#bcd4ee;color:#1a1a1a;">
                       <td><b>Total<br>Paid & Verified<br>Subscriptions</b></td>
                       <td><b><br>Single Copy<br>Sales</b></td>
                       <td><b>Total<br>Paid & Verified<br>Circulation</b></td>
                       <td><b><br>Analyzed<br>Nonpaid</b></td>
                       <td><b><br>Total<br>Circulation</b></td>
                       <td><b><br>Rate<br>Base</b></td>
                       <td><b><br>Variance<br>to Rate Base</b></td>
                </tr>				 
            </thead>' . $data .'
        </table>';

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

//------- TOTAL CIRCULATION--------------------------------------------------------------------------

if($tci) {
    $len = sizeof($tci);
    $data = '';
    for ($i=0; $i<$len-1; $i++) {
        $row = $tci[$i];
	    $data .= '<tr>
                     <td border="1">' . $row['SPECIAL_ISSUE'] . '</td>
                     <td border="1">' . $row['ISSUE_NAME'] . '</td>
                     <td border="1">' . number_format($row['PAID_SUBS_PRINT']) . '</td>
                     <td border="1">' . number_format($row['VERIF_SUBS_PRINT']) . '</td>
                     <td border="1">' . number_format($row['TOTAL_PAID_VERIF_SUBS']) . '</td>
                     <td border="1">' . number_format($row['SCS_PRINT']) . '</td>
                     <td border="1">' . number_format($row['TOTAL_PAID_VERIF_CIRC']) . '</td>
                     <td border="1">' . number_format($row['ANP_PRINT']) . '</td>
                     <td border="1">' . number_format($row['TOTAL_PAID_VERIF_ANP_CIRC']) . '</td>
                 </tr>';	
    }

    $avg = '';
    for ($i=$len-1; $i<=$len-1; $i++) {
        $row = $tci[$i];
        $avg .= '<tr style="font-weight:bold;">
                     <td border="1">' . $row['SPECIAL_ISSUE'] . '</td>
                     <td border="1">' . $row['ISSUE_NAME'] . '</td>
                     <td border="1">' . number_format($row['PAID_SUBS_PRINT']) . '</td>
                     <td border="1">' . number_format($row['VERIF_SUBS_PRINT']) . '</td>
                     <td border="1">' . number_format($row['TOTAL_PAID_VERIF_SUBS']) . '</td>
                     <td border="1">' . number_format($row['SCS_PRINT']) . '</td>
                     <td border="1">' . number_format($row['TOTAL_PAID_VERIF_CIRC']) . '</td>
                     <td border="1">' . number_format($row['ANP_PRINT']) . '</td>
                     <td border="1">' . number_format($row['TOTAL_PAID_VERIF_ANP_CIRC']) . '</td>
                </tr>';
    }
}

$Total_Circulation = 
    '<table align="center" width="100%">
                <thead>
                    <tr>
				        <td width="12.5%" border="none"></td>
				        <td border="1" width="87.5%" colspan="3" style="background-color: #bcd4ee;"><b>Print</b></td>
                    </tr>
                     <tr>
                          <td border="1" width="3%" style="background-color: #bcd4ee;"></td>
                          <td border="1" width="9.5%" style="background-color: #bcd4ee;"><b><br><br><br>Issue</b></td>
                          <td border="1" width="12.5%" style="background-color: #bcd4ee;"><b><br><br>Paid<br>Subscriptions</b></td>
                          <td border="1" width="12.5%" style="background-color: #bcd4ee;"><b><br><br>Verified<br>Subscriptions</b></td>
                          <td border="1" width="12.5%" style="background-color: #bcd4ee;"><b><br>Total<br>Paid & Verified<br>Subscriptions</b></td>
                          <td border="1" width="12.5%" style="background-color: #bcd4ee;"><b><br><br>Single Copy<br>Sales</b></td>
                          <td border="1" width="12.5%" style="background-color: #bcd4ee;"><b><br>Total<br>Paid & Verified<br>Circulation</b></td>
                          <td border="1" width="12.5%" style="background-color: #bcd4ee;"><b><br><br>Analyzed<br>Nonpaid</b></td>
                          <td border="1" width="12.5%" style="background-color: #bcd4ee;"><b>Total<br>Paid, Verified &<br>Analyzed Nonpaid<br> Circulation</b></td>
                     </tr>				 
				</thead>' . $data . ''.$avg.'
    </table>';           

//------- TOTAL CIRCULATION--------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

$tbl = '<table width="100%" cellpadding="0" border="0">
        <tr>
            <td>
                ' . $title_1 . '
                ' . $Executive_Summary . '
                <br>
            </td>
        </tr>
        <tr>
            <td>
                ' . $title_2 . '
                ' . $Total_Circulation . '
                
            </td>
        </tr>
    </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

//------- PRICES ---------------------------------------------------------------------------------

if($prc){
    $asc = 0;
    $sub = 0;
    foreach ($prc as $row) {    
        $asc += $row['AVERAGE_SINGLE_COPY'];
        $sub += $row['SUBSCRIPTION'];
    }
    $data = '';
    $data .= '<tr>
                <td border="1">Average Single Copy</td>
                <td border="1" align="center">'.$asc.'</td>
             </tr> 
             <tr>
                <td border="1">Subscription</td> 
                <td border="1" align="center">'.$sub.'</td>
             </tr>
             <tr>
                <td></td>
             </tr>
             <tr>
                <td>(1) Statement Period</td>
             </tr>';
}
 
$Prices = 
    '<table width="100%" border="0">       
        <thead>
         <tr>
            <td width="65%"></td>
            <td width="35%" align="center" border="1" style="background-color: #bcd4ee;"><b>Suggested<br>Retail Prices (1)</b></td>            
         </tr>
        <thead>'. $data .'        
    </table>';

//------- PRICES ---------------------------------------------------------------------------------

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
                ' . $title_3 . '
                ' . $Prices . '
             <br><br><br>
                ' . $title_5 . '
                ' . $Rate_Base . '
            </td>
            <td width="2%"></td>            
            
            <td width="49%">
                ' . $title_4 . '
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
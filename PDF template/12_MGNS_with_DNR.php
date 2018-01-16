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
			$image_file = '../assets/images/logo.jpg'; // *** Very IMP: make sure this image is available on given path on your server
			$this->Image($image_file,20,10,50);            
			 
            $this->SetFont('helvetica', 'B', 10);
            $this->Text(20,30,"Publisher's Statement");
            
            $this->SetFont('helvetica', '', 10);
            $this->Text(20,36,"6 months ended December 31, 2015, Subject to Audit");
			//$this->Cell(0, 0, "Publisher's Statement", 0, false, 'L', 0, '', 0, false, 'M', 'M');

			// Header Right Side
			$image_file = '../assets/images/ABA.png'; // *** Very IMP: make sure this image is available on given path on your server
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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rinesh Bharath');
$pdf->SetTitle('12 MGNS with DNR');
$pdf->SetSubject('12 MGNS with DNR');
$pdf->SetKeywords('PDF, 12 MGNS with DNR');


// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 45, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 30);

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
$title_2 = table_cell_with_percentage('  DIGITAL NONREPLICA','70%');
$title_3 = table_cell('  TOTAL CIRCULATION BY ISSUE');
$title_4 = table_cell('  DIGITAL NONREPLICA');
$title_5 = table_cell('  PRICES');
$title_6 = table_cell('  RATE BASE');
$title_7 = table_cell('  NOTES');
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
                        <td width="14%">'. number_format($row['PARA_1_PAID_VERIF_SUBS']) .'</td>
                        <td width="14%">'. number_format($row['PARA_1_SCS']) .'</td>
                        <td width="14%">'. number_format($row['PARA_1_PAID_VERIF_CIRC']) .'</td>                  
                        <td width="14%">'. number_format($row['PARA_1_TOTAL_ANP_CIRC']) .'</td>                  
                        <td width="14%">'. number_format($row['PARA_1_PAID_VERIF_ANP_CIRC']) .'</td>                   
                        <td width="15%">'. number_format($row['PARA_1_TOTL_RB']) .'</td>                   
                        <td width="15%">'. number_format($row['PARA_1_TOTL_VARIANCE_RB']) .'</td>                   
                    </tr>';	

    }
}

$Executive_Summary = 
    '<table width="100%"  align="center" border="1">
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

//------- EXECUTIVE SUMMARY--------------------------------------------------------------------------

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
    
$Digital_Nonreplica = 
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
            ' . avg . '
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

$Digital_Nonreplica = 
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
      
	  <tbody>'
	     .$data.
	     .$avg.
	  '</tbody>
      
	</table>';
    
//------- DIGITAL NONREPLICA--------------------------------------------------------------------------

//--------STRUCTURE THE TABLE------------------------------------------------------------------------------
    
$tbl = '
    <table width="100%" cellpadding="0" border="0">
        <tr>
            <td width="100%">
                ' . $title_1 . '
                ' . $Executive_Summary . '                 
                <br><br>
            </td>  
        </tr> 
		<tr>
            <td width="100%">                
                ' . $title_2 . '
                ' . $Digital_Nonreplica . '             
                <br><br><br><br><br>
            </td>  
        </tr>
		<tr>
            <td width="100%">			    
                ' . $title_3 . '
                ' . $Total_Circulation . '                    
                <br><br>
            </td> 
        </tr>
		<tr>
            <td width="100%">
                ' . $title_4 . '
                ' . $Digital_Nonreplica . '                
            </td> 
        </tr>
		
    </table>';


$pdf->writeHTML($tbl, true, false, false, false, '');
    
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

// ---------------------- pAGE 1 END---------------------------------------------------------------------------
    
$pdf->AddPage('L','A4');
    
// ---------------------- pAGE 2 START---------------------------------------------------------------------------
    
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
            <td width="2%"></td>
            <td width="47%">
                ' . $title_5 . '
                ' . $Prices . '
                <br><br>  (1) For Statement Period<br><br>
                ' . $title_6 . '
                <br><br>
                ' . $Rate_Base . ' 
            </td>            
            
            <td width="2%"></td>

            <td width="49%">            
                ' . $title_7 . '
                ' . $Notes . '
                <br><br>
                ' . $Certificate . ' 
            </td>                
        </tr>        
    </table>';

$pdf->writeHTML($tbl, true, false, false, false, '');
    
//--------STRUCTURE THE TABLE------------------------------------------------------------------------------

// ---------------------- pAGE 2 END---------------------------------------------------------------------------

$pdf->lastPage();

// ---------------------------------------------------------

$pdf->Output('hhhhhh.pdf','I');

//============================================================+

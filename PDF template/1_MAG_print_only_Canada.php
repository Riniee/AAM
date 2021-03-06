<?PHP
// Include the main TCPDF library 
require_once('../libraries/TCPDF/tcpdf_include.php');
require_once('../libraries/TCPDF/tcpdf.php');
class MYPDF extends TCPDF {
    //Page Header
    public function Header() { 
        if ($this->page == 1) {
            
            // Header Left Side
            $this->Text(15,5,"(1b) Paid and Verified - Print Only");
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
            $this->SetFont('helvetica', 'B', 7);
            $this->Text(160,25,"Annual Frequency: ");
            //Anu Frequency Value
            $AnuFre = 10;
            $this->SetFont('helvetica', '', 7);
            $this->Text(183,25,"".$AnuFre);
            
            //Field Served
            $this->SetFont('helvetica', 'B', 7);
            $this->Text(160,30,"Field Served: ");
            //Field Served Value
            $Field = "Consumers interested in healthy living.";
            $this->SetFont('helvetica', '', 7);
            $this->Text(177,30,"".$Field);
            
            //Published By
            $this->SetFont('helvetica', '', 7);
            $this->Text(160,35,"Published by Magazine Inc.");
			// We need to adjust the x and y positions of this text ... first two parameters
		} else {
			$this->SetMargins(10, 10, 10, true);
		}        
    }
    
    // Page footer
    public function Footer(){
        if($this->page == 1) {
        //position at 25mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 7);
		$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
        $this->Cell(0, 0, '48 W. Seegers Road lArlington Heights, IL 60005-3913 lT: 224-366-6939 lF: 224-366-6949 lwww.auditedmedia.com', 0, 0, 'C');
        
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
        else {
            //position at 25mm from bottom
            $this->SetY(-25);
            $this->SetFont('helvetica','', 7);
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
$pdf->SetTitle('1mag_print_only_canada');
$pdf->SetSubject('1mag_print_only_canada');
$pdf->SetKeywords('PDF, 1mag_print_only_canada');

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
$pdf->SetFont('helvetica', '', 6.75); 
// *** Very IMP: Please use times font, so that if you send this pdf file in gmail as attachment and if user
//opens it in google document, then all the text within the pdf would be visible properly.

// add a page
$pdf->AddPage('L', 'A4');

$pdf->Ln(-5);
//$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 0, 0)));
$pdf->SetTextColor(0,0,0);
$table_1_header = table_cell('EXECUTIVE SUMMARY: TOTAL AVERAGE CIRCULATION');
$table_2_header = table_cell('TOTAL CIRCULATION BY ISSUE');
$table_1 = 
    '<table width="100%" border="1">
        <tr style="background-color: #bcd4ee; color:#1a1a1a; " >
            <td width="20%" align="center"><b>Total <br>Paid & Verified <br>Subscriptions</b></td>
            <td width="20%" align="center"><b><br>Single CopySales</b></td>
            <td width="20%" align="center"><b><br>Total<br> Circulation</b></td>
            <td width="20%" align="center"><b><br>Rate Base</b></td>
            <td width="20%" align="center"><b><br>Variance<br> to Rate Base</b></td>
        </tr>
        <tr>
            <td width="20%" align="center">xxxxx </td>
            <td width="20%" align="center">xxxxx </td>
            <td width="20%" align="center">xxxxx</td>
            <td width="20%" align="center">xxxxx</td>
            <td width="20%" align="center">xxxxx</td>
        </tr>
    </table>';

$data = '';
for($i=0; $i<=6; $i++){
    $data.='<tbody>
                <tr>
                    <td width="3%"  border="1" align="center">xxx </td>
                    <td width="7%"  border="1" align="center">xxxx </td>
                    <td width="15%" border="1"  align="center">xxxx </td>
                    <td width="15%" border="1"  align="center">xxxx </td>
                    <td width="20%" border="1"  align="center">xxxx</td>
                    <td width="20%" border="1"  align="center">xxx </td>
                    <td width="20%" border="1"  align="center">xxxx</td>  
                </tr>
            <t/body>';
}

$table_2 = '<table width="100%" border="0">
                <thead>
                    <tr >
                        <td border="none" width="10%"></td>
                        <td border="1" width="90%" style="background-color: #bcd4ee;color:#1a1a1a;" align="center">
                            <b>Print</b>
                    </td>
                    </tr>
                    <tr style="background-color: #bcd4ee;color:#1a1a1a;">
                        <td border="1" width="10%" align="center" colspan="2">
                            <b><br><br>Issue</b>
                        </td>
                        <td border="1" width="15%" align="center">
                            <b><br>Paid<br> Subscriptions</b>
                        </td>
                        <td border="1" width="15%" align="center">
                            <b><br>Verified<br> Subscriptions</b>
                        </td>
                        <td border="1" width="20%" align="center">
                            <b>Total<br>Paid & Verified<br> Subscriptions</b>
                        </td>
                        <td border="1" width="20%" align="center">
                            <b><br>Single Copy<br> Sales</b>
                        </td>
                        <td border="1" width="20%" align="center"> 
                            <b>Total<br> Paid & Verified<br> Circulation</b>
                        </td>
                    </tr>
                <thead>
                <tbody>
                    '.$data.'
                </tbody>
            </table>';

$tbl1 = '<table width="100%" cellpadding="0" border="0">
        <tr>
            <td>
                ' . $table_1_header . '
                ' . $table_1 . '
                <br>
            </td>
        </tr>
        <tr>
            <td>
                ' . $table_2_header . '
                ' . $table_2 . '
            </td>
        </tr>
    </table>';

$pdf->writeHTML($tbl1, true, false, false, false, '');
//$pdf->Ln(-1);

//SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION
$table_3_header = table_cell('SUPPLEMENTAL ANALYSIS OF AVERAGE CIRCULATION');
$table_4_header = table_cell('VARIANCE OF LAST THREE RELEASED AUDIT REPORTS');
$table_5_header = table_cell('PRICES');
$empty_row = empty_row();
$table_3_1='<tr >
                <td align="left" colspan="3"  style="background-color:#bcd4ee;color:#1a1a1a;" border="1"><b>Paid Subscriptions</b></td>
            </tr>';
for($i=0; $i<=9; $i++){ 
    $table_3_1.='<tr>
                    <td width="40%" border="1" style="color:#1a1a1a;">1111111</td>
                    <td width="30%" border="1">2222</td>
                    <td width="30%" border="1">3333</td>
                </tr>';
}
$table_3_2= '<tr >
                <td align="left" colspan="3" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b>Verified Subscriptions</b></td>
            </tr>';
for($i=0; $i<=3; $i++){
    $table_3_2.='<tr>
                    <td width="40%" border="1">fdsgfdg</td>
                    <td width="30%" border="1">fgfg</td>
                    <td width="30%" border="1">fgfgf</td>
                </tr>';
}

$table_3_3= '<tr >
                <td align="left" colspan="3" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b>Single Copy Sales</b></td>
            </tr>';
for($i=0; $i<=4; $i++){
    $table_3_3.='<tr>
                    <td width="40%" border="1">xxxx</td>
                    <td width="30%" border="1">xxxx</td>
                    <td width="30%" border="1">xxxxx</td>
                </tr>';
}
/* table 3*/


$table_4 = '<table width="100%" border="1">
                <tr style="background-color: #bcd4ee;color:#1a1a1a;">
                    <td align="center"><b> Audit Period<br> Ended</b></td>
                    <td align="center"><b><br> Rate Base</b></td>
                    <td align="center"><b><br> Audit Report</b></td>
                    <td align="center"><b> Publisher’s <br>Statements</b></td>
                    <td align="center"><b><br> Difference</b></td>
                    <td align="center"><b>Percentage<br>of Difference</b></td>
                </tr>
                <tr>
                    <td align="center">22/22/2222</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                </tr>
                <tr>
                    <td align="center">22/22/2222</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                </tr>
                <tr>
                    <td align="center">22/22/2222</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                    <td align="center">xxxx</td>
                </tr>
            </table>';
$table_5 = '<table width="100%" border="0" style="text-align:center">
                <thead>
                    <tr >
                        <td width="50%" rowspan="2"  border="none"></td>
                        <td width="17%"rowspan="2" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b><br>Suggested <br> Retail Prices (1)</b></td>
                        <td colspan="2" width="33%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1">
                            <b>Average Price(2)</b>
                        </td>
                    </tr>
                    <tr >
                        <td width="17%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b><br>Net</b></td>
                        <td width="16%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1">
                            <b>Gross <br> (Optional)</b>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-weight:thin;">
                        <td  width="50%" align="left" border="1"> Average Single Copy</td>
                        <td  width="17%" border="1">11111</td>
                        <td rowspan="2" width="17%" border="1"></td>
                        <td rowspan="2" width="16%" border="1"></td>
                    </tr>
                    <tr>
                        <td width="50%" align="left" border="1"> Subscription</td>
                        <td width="17%" border="1">11111</td>

                    </tr>
                    <tr>
                        <td width="50%" align="left" border="1"> Average Subscription Price Annualized (3) </td>
                        <td rowspan="2" width="17%" border="1"></td>
                        <td width="17%" border="1">111111</td>
                        <td width="16%" border="1">111111</td> 
                    </tr>
                    <tr>
                        <td width="50%" align="left" border="1"> Average Subscription Price per Copy</td>
                        <td width="17%" border="1">111111</td>
                        <td width="16%" border="1">111111</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tr><td></td></tr>
            </table>';

$main_left = $table_3_header.
    '<table width="100%" border="0" style="text-align:center; color:#1a1a1a;">
        <thead>
            <tr >
                <td width="40%"  border="none"></td>
                <td width="30%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b>Print</b></td>
                <td width="30%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b>% of Circulation</b></td>
            </tr>
        </thead>
            <tbody>
                '.$table_3_1.'                   
                '.$table_3_2.'                   
                '.$table_3_3.'                   
            </tbody>
    </table>'; 
$main_right = '<table width="100%">
                    <tr>
                        <td >
                            '.$table_4_header.'
                            '.$table_4.'
                            <br><br>  Visit www.auditedmedia.com Media Intelligence Center for audit reports<br><br>
                        </td>
                    </tr>
                    '.$empty_row.'
                    '.$empty_row.'
                    <tr>
                        <td>
                            '.$table_5_header.'
                            '.$table_5.'
                            <br><br>  (1) For statement period<br>
                            (2) Represents subscriptions for the 12 month period ended June 30, 2015<br>
                            (3) Based on the following issue per year frequency: 10<br>
                            
                        </td>
                    </tr>
            </table>';

// $main includes tables 3, 4 & 5
$main = <<<EOD
    <table width="100%" border="0" cellpadding="0" nobr="true">
                    <tr>
                        <td width="49%">
                            $main_left
                        </td>
                         <td width="1%"></td>
                        <td width="50%">
                            $main_right
                        </td>
                    </tr>
            </table>
EOD;

$pdf->writeHTML($main, true, false, false, false, '');

/*     SECOND PAGE STARTS HERE      */

/* additional table title */
$table_6_header = table_cell_3('ADDITIONAL DATA IN WWW.AUDITEDMEDIA.COM MEDIA INTELLIGENCE CENTER','99');
$table_7_header = table_cell('ADDITIONAL ANALYSIS OF VERIFIED');
$table_8_header = table_cell('RATE BASE');
/* additional table title */

$add_inside_table_public = '';
for($i=0; $i<=6; $i++){
    $add_inside_table_public .= 
        '<tr>
            <td width="70%" border="1"></td>
            <td width="30%" align="center" border="1">14,000</td>
        </tr>';
}

$add_inside_table_individual = '';
for($i=0; $i<=5; $i++){
    $add_inside_table_individual .= 
        '<tr>
            <td  width="70%" border="1"></td>
            <td width="30%" align="center" border="1">15,000</td>
        </tr>';
}
$table_6 = 
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
$table_7 = 
    '<table width="50%" border="0">
        <tr>
            <td width="70%" border="none"></td>
            <td width="30%" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b> Print </b></td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b> Public Place </b></td>
        </tr>
            '.$add_inside_table_public.'
        <tr>
            <td width="70%" border="1"><b>Total Public Places</b></td>
            <td width="30%" align="center" border="1">9999</td>
        </tr>
        <tr>
            <td colspan="2" style="background-color: #bcd4ee;color:#1a1a1a;" border="1"><b> Individual Use </b></td>
        </tr>
            '.$add_inside_table_individual.'
        <tr>
            <td width="70%" border="1"><b>Total Individual Places</b></td>
            <td width="30%" align="center" border="1">9999</td>
        </tr>
    </table>';
$table_8 =
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
$additional = '<table width="100%" >
                    <tr>
                        <td>'.$table_6_header.'
                        '.$table_6.'
                        </td>
                    </tr>
                        <br><br>
                    <tr>
                        <td>
                        '.$table_7_header.'
                        '.$table_7.'
                        </td>
                    </tr>
                    <br><br>
                    <tr style="background-color: #fff;color:#1a1a1a;">
                        <td>
                        '.$table_8_header.'
                        '.$table_8.'    
                        </td>
                    </tr>
                </table>';

$table_9_header = table_cell('NOTES');
$table_10_header = '';
$table_9 = 
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

$table_10 = '<table width="90%" style="border: 1px solid black">
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
            <td>  Name</td>
            <td>  Name</td>
        </tr> 
        <tr>
            <td>  Director</td>
            <td>  Publisher</td>
        </tr>
        <tr>
            <td>  Date Signed:</td>
            <td>  Sales Offices:</td>
        </tr>
        <tr>            
            <td>  P: 000.000.1000 • F: 000.000.0000 • URL: www.</td>
            <td></td>
        </tr>
        <tr>            
            <td>  Established:</td>
            <td>  AAM Member since:</td>
        </tr>    
        <tr>
            <td></td>
        </tr>
    </table>';

$notes_table = '<table width="100%" style="background-color: #fff;color:#1a1a1a;">
                    <tr>
                        <td>
                        '.$table_9_header.'
                        '.$table_9.'                
                        </td>
                    </tr>
                    <br><br><br>
                    <tr>
                        <td width="1%"></td>
                        <td width="99%">
                        '.$table_10_header.'
                        '.$table_10.'
                        </td>
                    </tr>
                    </table>';
$table = <<<EOD
    <table width="100%" border="0" nobr="true">
                    <tr>
                        <td width="49%">
                            $additional
                        </td>
                        <td width="1%"></td>
                        <td width="50%">
                            $notes_table
                        </td>
                    </tr>
            </table>
EOD;
 $pdf->writeHTML($table, true, false, false, false, '');
//FUNCTIONS
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
$pdf->lastPage();
// ---------------------------------------------------------

//Close and output PDF document
/*$pdf_file_name = 'custom_header_footer.pdf';
$pdf->Output($pdf_file_name, 'I');*/
/**
$rand = rand(0,999999);
$filename= "{$rand}.pdf"; 
$filelocation = "C:\\wamp\\www\\test1\\ramu_uploads";

$fileNL = $filelocation."\\".$filename;
echo $fileNL;*/
$pdf->Output('hhhhhh.pdf','I');



//============================================================+
// END OF FILE                                                
//============================================================+

?>
<?php 

$member = $card['MEMBER_NUMBER'];
$drive  = $card['DRIVE_DATE'];
$type   = $card['PRODUCT_TYPE'];

$htmlpath   = 'Magazine Format Type/';
$pdfpath    = 'PDF template/';

$layout = PdfManager::p_get_layout_details($member, $drive, $type);
$Model  = strval($layout['LAYOUT_TYPE']);

switch($Model) {
        
    case '1A1':
       $htmlUrl = $htmlpath.'1_MAG_print_only.php';
        $pdfUrl = $pdfpath.'1_MAG_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '1B1':
       $htmlUrl = $htmlpath.'2_MAG_print_digital.php';
        $pdfUrl = $pdfpath.'2_MAG_print_digital.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '1A2':
       $htmlUrl = $htmlpath.'3_MAG_with_DNR.php';
        $pdfUrl = $pdfpath.'3_MAG_with_DNR.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '1B2':
       $htmlUrl = $htmlpath.'19_MAG_print_digital_with_DNR.php';
        $pdfUrl = $pdfpath.'19_MAG_print_digital_with_DNR.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '2A1':
       $htmlUrl = $htmlpath.'4_MAGS_print_only.php';
        $pdfUrl = $pdfpath.'4_MAGS_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '2B1':
       $htmlUrl = $htmlpath.'5_MAGS_print_digital.php';
        $pdfUrl = $pdfpath.'5_MAGS_print_digital.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '2A2':    
       $htmlUrl = $htmlpath.'6_MAGS_with_DNR.php';        
        $pdfUrl = $pdfpath.'6_MAGS_with_DNR.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;        
        
    case '2B2':
       //$htmlUrl = $htmlpath.'1_MAG_print_only.php';
        //$pdfUrl = $pdfpath.'1_MAG_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '3A1':
       $htmlUrl = $htmlpath.'13_CNTL_print_only.php';
        $pdfUrl = $pdfpath.'13_CNTL_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '3B1':        
       $htmlUrl = $htmlpath.'14_CNTL_print_digital.php';
        $pdfUrl = $pdfpath.'14_CNTL_print_digital.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
    
    case '3A2':
       $htmlUrl = $htmlpath.'15_CNTL_with_DNR.php';
        $pdfUrl = $pdfpath.'15_CNTL_with_DNR.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
            
    case '3B2':
       //$htmlUrl = $htmlpath.'1_MAG_print_only.php';
        //$pdfUrl = $pdfpath.'1_MAG_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '4A1':        
       $htmlUrl = $htmlpath.'7_MGN_print_only.php';        
        $pdfUrl = $pdfpath.'7_MGN_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;            
        break;
    
    case '4B1':
       $htmlUrl = $htmlpath.'8_MGN_print_digital.php';
        $pdfUrl = $pdfpath.'8_MGN_print_digital.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
    
    case '4A2':
       $htmlUrl = $htmlpath.'9_MGN_with_DNR.php';
        $pdfUrl = $pdfpath.'9_MGN_with_DNR.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '4B2':
       //$htmlUrl = $htmlpath.'1_MAG_print_only.php';
        //$pdfUrl = $pdfpath.'1_MAG_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '5A1':
       $htmlUrl = $htmlpath.'10_MGNS_print_only.php';
        $pdfUrl = $pdfpath.'10_MGNS_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '5B1':
       $htmlUrl = $htmlpath.'11_MGNS_print_digital.php';
        $pdfUrl = $pdfpath.'11_MGNS_print_digital.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '5A2':
       $htmlUrl = $htmlpath.'12_MGNS_with_DNR.php';
        $pdfUrl = $pdfpath.'12_MGNS_with_DNR.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '5B2':
       //$htmlUrl = $htmlpath.'1_MAG_print_only.php';
        //$pdfUrl = $pdfpath.'1_MAG_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '6A1':
       $htmlUrl = $htmlpath.'16_CNTN_print_only.php';
        $pdfUrl = $pdfpath.'16_CNTN_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '6B1':
       $htmlUrl = $htmlpath.'17_CNTN_print_digital.php';
        $pdfUrl = $pdfpath.'17_CNTN_print_digital.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '6A2':
       $htmlUrl = $htmlpath.'18_CNTN_with_DNR.php';
        $pdfUrl = $pdfpath.'18_CNTN_with_DNR.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    case '6B2':
       //$htmlUrl = $htmlpath.'1_MAG_print_only.php';
        //$pdfUrl = $pdfpath.'1_MAG_print_only.php?member_no=' .$member. '&drive_date=' .$drive.'&product_type='.$type;
        break;
        
    default :
        break;
}
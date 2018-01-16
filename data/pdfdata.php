<?php
	//require '../App.php';
	require 'PdfManager.php';
	$card['MEMBER_NUMBER'] = 415072; //400012 /* LAYOUT2 - 411550/30-JUN-2016/PS */ /*Layout: 2A1 - 400166/30-JUN-2016/PS*/
	$card['DRIVE_DATE'] = '31-DEC-2016'; // '31-DEC-2016'
	$card['PRODUCT_TYPE'] = 'PS';

	$es = PdfManager::p_get_executive_summary($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);

	$variance = PdfManager::p_get_variance($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
	/*
	 * @var $tci total circulation by issue
	 */
	$tci = PdfManager::p_get_total_circulation_issue($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
	
	/*
	 * @var $rb Rate Base Changes
	 */
	$rbc = PdfManager::p_get_ratebase_changes($card['MEMBER_NUMBER'], '30-JUN-2016', $card['PRODUCT_TYPE']);

	$rb = PdfManager::p_get_rate_base($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);

	$prices = PdfManager::p_get_price_summary_layout($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);

	$lheader = PdfManager::p_get_header($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);

	$certify = PdfManager::p_get_certify($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
	/* @var $sa supplymentory analysis*/
	$sa = PdfManager::p_get_supply_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
	
	/*
	 * @var $aav Addtional Analysis verified
	 */
	$aav = PdfManager::p_get_additional_analysis($card['MEMBER_NUMBER'], $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);

	//$notes = PdfManager::p_get_notes(401053, $card['DRIVE_DATE'], $card['PRODUCT_TYPE']);
	$notes = PdfManager::p_get_notes(404488, '30-JUN-2016', $card['PRODUCT_TYPE']);
	
	
	//echo json_encode($notes);
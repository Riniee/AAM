<?php

/* @var $paav public AAV */
	$paav = [];
	/* @var $iaav individual AAV */
	$iaav = [];
	foreach ($aav as $row) {
		if (isset($rb['MAVS_PARAGRAPH']) && $row['MAVS_PARAGRAPH'] == '6A' && isset($rb['MAVS_VERIF_SUBS_PRINT']) && $row['MAVS_VERIF_SUBS_PRINT']) {
			$paav[] = $row;
		}
		if (isset($rb['MAVS_PARAGRAPH']) && $row['MAVS_PARAGRAPH'] == '6B' && isset($rb['MAVS_VERIF_SUBS_PRINT']) && $row['MAVS_VERIF_SUBS_PRINT']) {
			$iaav[] = $row;
		}
	}
	
	/* rate base */
	$pvctext = '';
	$rbnotes = '';
	if ($rb) {
		if (isset($rb['PARA_1_RATE_BASE_NOTES']) && $rb['PARA_1_RATE_BASE_NOTES']) {
			$rbnotes = $rb['PARA_1_RATE_BASE_NOTES'];
		}
		if (isset($rb['PARA_1_NON_CLAIM_RB_FLAG']) && $rb['PARA_1_NON_CLAIM_RB_FLAG'] == 'Y') {
			$pvctext = 'None Claimed';
		} 
		if (isset($rb['PARA_1_PVDR_RB_FLAG']) && isset($rb['NP_PARA_1_ANP_RB_FLAG'])) {
			if ($rb['PARA_1_PVDR_RB_FLAG'] == 'Y' && $rb['NP_PARA_1_ANP_RB_FLAG'] == 'Y') {
				$pvctext = 'Rate base shown in Executive Summary is for combined paid and verified & analyzed nonpaid circulation';
			}

			if ($rb['PARA_1_PVDR_RB_FLAG'] == 'Y' && $rb['NP_PARA_1_ANP_RB_FLAG'] == 'N') {
				$pvctext = 'Rate base shown in Executive Summary is for paid and verified circulation.';
			}
			if ($rb['PARA_1_PVDR_RB_FLAG'] == 'N' && $rb['NP_PARA_1_ANP_RB_FLAG'] == 'Y') {
				$pvctext = 'Rate base shown in Executive Summary is for analyzed nonpaid circulation';
			}
		}
		
	}
	/* @var $rbca ratebase change */
	$rbca = [];
	$rbcc = [];
	$count = count($rbc);
	//echo $count;print_r($rbc[1]['EFFECTIVE_DT']);die;
	for ($i = 0; $i < $count-1; $i++) {
		$rbcc['start_rb'] = $rbc[$i]['RATE_BASE'];
		$rbcc['end_rb'] = $rbc[$i+1]['RATE_BASE'];
		$edate = $rbc[$i + 1]['EFFECTIVE_DT'];		
		$date = new \DateTime($edate);
		
		$rbcc['end_date'] = date_format($date, 'F Y');
		
		$date = $date->format('y-m-d');
		$datestring = $date . 'first day of last month';
		$dt=date_create($datestring);		
		$rbcc['start_date'] = date_format($dt, 'F Y');
		
		$rbca[] = $rbcc;
	}

	/* supplymentory analysis */
	
	$psdata = false;
	$vsdata = false;
	$scsdata = false;
	 $andata = false;
	if ($sa) {
		if (isset($sa['PARA_6_PD_INDV_SUBS_PRINT']) && $sa['PARA_6_PD_INDV_SUBS_PRINT'] || 
			isset($sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT']) && $sa['PARA_6_PD_ASSOC_SUBS_DED_PRINT'] || isset($sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT']) && $sa['PARA_6_PD_ASSOC_SUBS_ND_PRINT'] || isset($sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT']) && $sa['PARA_6_PD_CLUB_MEMBR_DED_PRINT'] || isset($sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT']) && $sa['PARA_6_PD_CLUB_MEMBR_ND_PRINT'] || 
			isset($sa['PARA_6_PD_DEFER_SUBS_PRINT']) && $sa['PARA_6_PD_DEFER_SUBS_PRINT'] || 
			isset($sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT']) && $sa['PARA_6_PD_PRTNR_SUBS_DED_PRINT'] ||
			isset($sa['PARA_6_PD_SCHOOL_PRINT']) && $sa['PARA_6_PD_SCHOOL_PRINT'] || 
			isset($sa['PARA_6_PD_SPONS_SALES_PRINT']) && $sa['PARA_6_PD_SPONS_SALES_PRINT'] || 
			isset($sa['PARA_6_TOTAL_PAID_SUBS_PRINT']) && $sa['PARA_6_TOTAL_PAID_SUBS_PRINT']) {
			$psdata = true;
		}
		
		if (isset($sa['PARA_6_VERIF_SUBS_PP_PRINT']) && $sa['PARA_6_VERIF_SUBS_PP_PRINT'] || 
			isset($sa['PARA_6_VERIF_SUBS_IU_PRINT']) && $sa['PARA_6_VERIF_SUBS_IU_PRINT'] ||
			isset($sa['PARA_6_TOT_VERIF_SUBS_PRINT']) && $sa['PARA_6_TOT_VERIF_SUBS_PRINT'] || isset($sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT']) && $sa['PARA_6_TOT_PD_VERIF_SUBS_PRINT']) {
			$vsdata = true;
		}
		
		if (isset($sa['PARA_6_SCS_PRINT']) && $sa['PARA_6_SCS_PRINT'] || 
			isset($sa['PARA_6_SCS_PARTNER_DED_PRINT']) && $sa['PARA_6_SCS_PARTNER_DED_PRINT'] || isset($sa['PARA_6_SCS_SPONS_SALES_PRINT']) && $sa['PARA_6_SCS_SPONS_SALES_PRINT'] ||
			isset($sa['PARA_6_TOTAL_SCS_PRINT']) && $sa['PARA_6_TOTAL_SCS_PRINT'] ||
			isset($sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT']) && $sa['PARA_6_TOT_PD_VERIF_CIRC_PRINT']) {
			$scsdata = true;
		}
		 if(isset($sa['PARA_6_ANP_LIST_SOURCE_PRINT']) && $sa['PARA_6_ANP_LIST_SOURCE_PRINT'] ||   isset($sa['PARA_6_ANP_MKT_COV_PRINT']) && $sa['PARA_6_ANP_MKT_COV_PRINT'] || isset($sa['PARA_6_ANP_BULK_PRINT']) && $sa['PARA_6_ANP_BULK_PRINT'] || isset($sa['PARA_6_ANP_DEL_HOST_PROD_PRINT']) &&$sa['PARA_6_ANP_DEL_HOST_PROD_PRINT'] || isset($sa['PARA_6_TOTAL_ANP_PRINT']) && $sa['PARA_6_TOTAL_ANP_PRINT'] || isset($sa['PARA_6_TOT_PD_VERIF_ANP_PRINT']) && $sa['PARA_6_TOT_PD_VERIF_ANP_PRINT']) {
            $andata = true;
        }
	}
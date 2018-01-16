<?php 	
	//require '../App.php';
	//require '../data/PdfManager.php';
	$notes = PdfManager::p_get_notes(404488, '30-JUN-2016', 'PS');
    //$notes = PdfManager::p_get_notes(401053, '31-DEC-2016', 'PS');
	$noCirc = false;
	$singleCirc = false;
	$threeCirc = false;
	$grid1 = false;
	$grid2 = false;
	$checkBox = false;
	$checkBoxData1 = [];
	$checkBoxData2 = [];
	$checkBoxData3 = [];
	$checkBoxData4 = [];
	$grid1Data = [];
	$grid2Data = [];
	$notesTable = '';
	if ($notes) {
		$notesTable = '<table width="100%" align="left" border="0">';
	}
	foreach($notes as $key=>$row) {				
		$clauseId = $row['CLAUSE_ID'];
		if (in_array($clauseId, $otherTypes)) {
			if (in_array($clauseId, $gridType)) {
				if ($clauseId == 1145) {
					$grid1Data['TITLE'] = $row['TITLE'];
					$grid1Data['TEXT_BEFORE'] = $row['TEXT_BEFORE'];
					$grid1Data['TEXT_AFTER'] = $row['TEXT_AFTER'];
					$g1data[] = [
						'TEXT' => $row['TEXT'],
						'CIRC' => $row['CIRC'],
					];
					$grid1 = true;
				}
				if ($clauseId == 1146) {
					$grid2Data['TITLE'] = $row['TITLE'];
					$grid2Data['TEXT_BEFORE'] = $row['TEXT_BEFORE'];
					$grid2Data['TEXT_AFTER'] = $row['TEXT_AFTER'];
					$g2data[] = [
						'TEXT' => $row['TEXT'],
						'MULTI_TITLE' => $row['MULTI_TITLE'],
						'OPENS_PER_ISSUE' => $row['OPENS_PER_ISSUE'],
						'TOT_OPENS' => $row['TOT_OPENS'],
						'UNIQUE_OPENS' => $row['UNIQUE_OPENS'],
					];
					$grid2 = true;
				}
			}
			if (in_array($clauseId, $checkBoxType)) {
				$checkBox = true;
				if($clauseId == 1200) {
					$checkBoxData1['TITLE'] = $row['TITLE'];
					$checkBoxData1['TEXT_BEFORE'] = $row['TEXT_BEFORE'];
					$cb1data[] = [
						'TEMP_TEXT' => $row['TEMP_TEXT']
					];
				}

				if($clauseId == 1201) {
					$checkBoxData2['TITLE'] = $row['TITLE'];
					$checkBoxData2['TEXT_BEFORE'] = $row['TEXT_BEFORE'];
					$cb2data[] = [
						'TEMP_TEXT' => $row['TEMP_TEXT']
					];
				}
				if($clauseId == 1205) {
					$checkBoxData3['TITLE'] = $row['TITLE'];
					$checkBoxData3['TEXT_BEFORE'] = $row['TEXT_BEFORE'];
					$cb3data[] = [
						'TEMP_TEXT' => $row['TEMP_TEXT']
					];
				}
				if($clauseId == 1210) {
					$checkBoxData4['TITLE'] = $row['TITLE'];
					$checkBoxData4['TEXT_BEFORE'] = $row['TEXT_BEFORE'];
					$cb4data[] = [
						'TEMP_TEXT' => $row['TEMP_TEXT']
					];
				}

			}
		} else {
			if (in_array($clauseId, $singleCellCirc)) {
				$type = "single cell circ";
				$singleCirc = true;
			} else if (in_array($clauseId, $threeCellCirc)) {
				$type = "three cell circ";
				$threeCirc = true;
			} else {
				$type = "No circ cell data:";		
				$noCirc = true;
			}											
		}
		
		if ($noCirc) {
			$notesTable .= '<tr>
				<td><b> ' . preg_replace('/[^A-Za-z0-9\-]/', '', $row['TITLE']) . ':</b> ' . $row['TEXT_BEFORE'] . ':' . $row['TEXT_AFTER'] . '</td>
			</tr>';
			$noCirc = false;
		}
		
		if ($singleCirc) {
			$notesTable .= '<tr>
				<td><b> ' . $row['TITLE']. ':</b> ' . $row['TEXT_BEFORE'] . ':' .  $row['CIRC'] .''. $row['TEXT_AFTER'] . '</td>
			</tr>';
			$singleCirc = false;
		}
		
		if ($threeCirc) {
			$notesTable .= '<tr>
				<td><b> ' . $row['TITLE']. ':</b> ' . $row['TEXT_BEFORE'] . '<br/>Total expirations during 12 months:' .  $row['TOT_12MON'] . '<br/>Total renewals of those expirations:' . $row['TOT_REN_EXP'] . '<br/>Renewals percentage:' . $row['TOT_REN_EXP'] . '</td>
			</tr>';
			$threeCirc = false;
		}

 }

if (isset($g1data)) {
	$grid1Data['data'] = $g1data;
}
if (isset($g2data)) {
	$grid2Data['data'] = $g2data;
}
if (isset($cb1data)) {
	$checkBoxData1['data'] = $cb1data;
}
if (isset($cb2data)) {
	$checkBoxData2['data'] = $cb2data;
}
if (isset($cb3data)) {
	$checkBoxData3['data'] = $cb3data;
}
if (isset($cb4data)) {
	$checkBoxData4['data'] = $cb4data;
}

/*if ($grid1Data) {
	$grid1datanotes = '<tr><td><b>' . $grid1Data['TITLE'] . '</b></br>' . $grid1Data['TEXT_BEFORE'];
	if(isset($grid1Data['data']) && $grid1Data['data']) {
		$grid1datanotes .= '<table><tr><th>Program</th><th>Average Circulation </th></tr><tr>';
		foreach ($grid1Data['data'] as $row) {
			$grid1datanotes .= '<td>' . $row['TEXT'] . '</td><td>' . $row['CIRC'] . '</td>';
		}
		$grid1datanotes .= '</tr></table>';
	}
	$grid1datanotes .= $grid1Data['TEXT_AFTER'] .'</td></tr>';
	
	$notesTable .= $grid1datanotes;
}



if ($grid2Data) {
	$grid2datanotes = '<tr><td><b>' . $grid2Data['TITLE'] . '</b></br>' . $grid2Data['TEXT_BEFORE'];
	if(isset($grid2Data['data']) && $grid2Data['data']) {
		$grid2datanotes .= '<table>
							<tr>
								<th>Program</th>
								<th>Reported Multi-Title Digital Program </th>
								<th>Unique Opens by Reader</th>
								<th>Opens by Issue</th>
								<th>Total Opens by Reader</th>
							</tr>';
		
		foreach ($grid2Data['data'] as $row) {
			$grid2datanotes .= '<td>' . $row['TEXT'] . '</td>
			<td>' . $row['MULTI_TITLE'] . '</td>
			<td>' . $row['UNIQUE_OPENS'] . '</td>
			<td>' . $row['OPENS_PER_ISSUE'] . '</td>
			<td>' . $row['TOT_OPENS'] . '</td>';
		}
		
		$grid2datanotes .= $grid2Data['TEXT_AFTER'] .'</td></tr>';
	
		$notesTable .= $grid2datanotes;
	}
}*/

if ($checkBoxData1) {
	$checkbox1datanotes = '<tr><td><b>' . $checkBoxData1['TITLE'] . '</b></br>' . $checkBoxData1['TEXT_BEFORE'];
	if(isset($checkBoxData1['data']) && $checkBoxData1['data']) { 
        foreach ($checkBoxData1['data'] as $row) {
			$checkbox1datanotes .= $row['TEMP_TEXT'] . '<br/>';
		}
	}
	$checkbox1datanotes .= '</td></tr>';
	$notesTable .= $checkbox1datanotes;
}

if ($checkBoxData2) {	
	$checkbox2datanotes = '';
	$checkbox2dataloop = '';
	if(isset($checkBoxData2['data']) && $checkBoxData2['data']) { 
        foreach ($checkBoxData2['data'] as $row) {
			$checkbox2dataloop .= $row['TEMP_TEXT'] . '<br/>';
		}
	}
	$checkbox2datanotes = '<tr><td><b>' . $checkBoxData2['TITLE'] . '</b><br/> ' . $checkBoxData2['TEXT_BEFORE'] . '' . $checkbox2dataloop . '</td></tr>';
	$notesTable .= $checkbox2datanotes;
}

if ($checkBoxData3) {	
	$checkbox3datanotes = '';
	$checkbox3dataloop = '';
	if(isset($checkBoxData3['data']) && $checkBoxData3['data']) { 
        foreach ($checkBoxData3['data'] as $row) {
			$checkbox3dataloop .= $row['TEMP_TEXT'] . '<br/>';
		}
	}
	$checkbox3datanotes = '<tr><td><b>' . $checkBoxData3['TITLE'] . '</b><br/> ' . $checkBoxData3['TEXT_BEFORE'] . '' . $checkbox3dataloop . '</td></tr>';
	$notesTable .= $checkbox3datanotes;
}

if ($checkBoxData4) {	
	$checkbox4datanotes = '';
	$checkbox4dataloop = '';
	if(isset($checkBoxData4['data']) && $checkBoxData4['data']) { 
        foreach ($checkBoxData4['data'] as $row) {
			$checkbox4dataloop .= $row['TEMP_TEXT'] . '<br/>';
		}
	}
	$checkbox4datanotes = '<tr><td><b>' . $checkBoxData4['TITLE'] . '</b><br/> ' . $checkBoxData4['TEXT_BEFORE'] . '' . $checkbox4dataloop . '</td></tr>';
	$notesTable .= $checkbox4datanotes;
}



$notesTable .= '</table>';
//echo $notesTable;

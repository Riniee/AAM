<?php 	
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
?>
	<div class="col-sm-10 col-md-10">						
		<?php if ($noCirc) { require 'common/common_modal.php'; ?>
			<p><strong><?php echo $row['TITLE'] ?>:</strong>
			<?php echo $row['TEXT_BEFORE'] ?>
			<?php if($row['TEXT_AFTER']) {?> :<?php echo $row['TEXT_AFTER'] ?> <?php } ?></p>
		<?php } $noCirc = false; ?>

		<?php if ($singleCirc) { require 'common/common_modal.php'; ?>
			<p><strong><?php echo $row['TITLE'] ?>:</strong>
			<?php echo $row['TEXT_BEFORE'] ?> : <?php echo $row['CIRC'] ?> 
			<?php if($row['TEXT_AFTER']) {?> :<?php echo $row['TEXT_AFTER'] ?> <?php } ?>
		</p>
		<?php } $singleCirc = false; ?>

		<?php if ($threeCirc) { require 'common/common_modal.php'; ?>
			<p><strong><?php echo $row['TITLE'] ?>:</strong><br/>
			<?php echo $row['TEXT_BEFORE'] ?> </p>

			<p>Total expirations during 12 months: <?php echo $row['TOT_12MON'] ?> </p>
			<p>Total renewals of those expirations: <?php echo $row['TOT_REN_EXP'] ?> </p>
			<p>Renewals percentage: <?php echo $row['REN_PERCENT'] ?> </p>

			<p><?php echo $row['TEXT_AFTER'] ?> </p>	
		<?php } $threeCirc = false; ?>

		<?php if ($grid1) { ?>
			<p><strong><?php echo $row['TITLE'] ?>:</strong>
			<?php echo $row['TEXT_BEFORE'] ?> : <?php echo $row['CIRC'] ?> 
			<?php if($row['TEXT_AFTER']) {?> :<?php echo $row['TEXT_AFTER'] ?> <?php } ?>
		</p>
		<?php } $grid1 = false; ?>

		<?php if ($grid2) { ?>
			<p><strong><?php echo $row['TITLE'] ?></strong><br/>
				<?php echo $row['TEXT_BEFORE'] ?>						
			</p>									
		<?php } $grid2 = false; ?>

		<?php if ($checkBox) { ?>
			<p><strong><?php echo $row['TITLE'] ?></strong><br/>
				<?php echo $row['TEXT_BEFORE'] ?>						
			</p>									
		<?php } $checkBox = false; ?>

	</div>	
	<div class="col-sm-2 col-md-2">
		<?php if ($row['MEMBER_STATIC_TEXT'] == 'N') { ?>
		<button type="button" class=" glyphicon glyphicon-pencil pull-right ml3"
				data-toggle="modal" data-target="#myModal-<?php echo $key; ?>"></button>
		<button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
		<?php } ?>
	</div>								
<?php } ?>	

<?php
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

	
?>

<?php if ($grid1Data) { ?>
<div class="col-sm-10 col-md-10">
	<p><strong><?php echo $grid1Data['TITLE'] ?></strong></p>
	<p><?php echo $grid1Data['TEXT_BEFORE'] ?></p>
	<p><?php echo $grid1Data['TEXT_AFTER'] ?></p>
	<table class="rm-table-border">
		<tr>
			<th>Program</th>
			<th>Average Circulation </th>
		</tr>
		
        <?php if(isset($grid1Data['data']) && $grid1Data['data']) { ?>
        <tr>
            <?php foreach ($grid1Data['data'] as $row) { ?>
            <td><?php echo $row['TEXT'] ?></td>
            <td><?php echo $row['CIRC'] ?></td>
            <?php } ?>
        </tr>
        <?php } ?>		
	</table>
</div>
<div class="col-sm-2 col-md-2">
	<button type="button" class=" glyphicon glyphicon-pencil pull-right ml3"
				data-toggle="modal" data-target="#edit-grid1"></button>
	<button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
</div>
<?php } ?>
<?php if ($grid2Data) { ?>
<div class="col-sm-10 col-md-10">
	<p><strong><?php echo $grid2Data['TITLE'] ?></strong></p>
	<p><?php echo $grid2Data['TEXT_BEFORE'] ?></p>	
	<table class="rm-table-border">
		<tr>
			<th>Program</th>
			<th>Reported Multi-Title Digital Program </th>
			<th>Unique Opens by Reader</th>
			<th>Opens by Issue</th>
			<th>Total Opens by Reader</th>
		</tr>
		
        <?php if(isset($grid2Data['data']) && $grid2Data['data']) { ?>
			<?php foreach ($grid2Data['data'] as $row) { ?>
            <tr>
                <td><?php echo $row['TEXT'] ?></td>
                <td><?php echo $row['MULTI_TITLE'] ?></td>
                <td><?php echo $row['UNIQUE_OPENS'] ?></td>
                <td><?php echo $row['OPENS_PER_ISSUE'] ?></td>
                <td><?php echo $row['TOT_OPENS'] ?></td>
            </tr>
			<?php } ?>
        <?php } ?>
			
	</table>
	<p><?php echo $grid2Data['TEXT_AFTER'] ?></p>
</div>
<div class="col-sm-2 col-md-2">
	<button type="button" class=" glyphicon glyphicon-pencil pull-right ml3"
				data-toggle="modal" data-target="#edit-grid2"></button>
	<button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
</div>
<?php } ?>
<?php if ($checkBoxData1) { ?>
<div class="col-sm-10 col-md-10">
	<p><strong><?php echo $checkBoxData1['TITLE'] ?></strong></p>
	<p><?php echo $checkBoxData1['TEXT_BEFORE'] ?></p>
	<?php 
		if(isset($checkBoxData1['data']) && $checkBoxData1['data']) { 
        foreach ($checkBoxData1['data'] as $row) { ?>
		<p><?php echo $row['TEMP_TEXT'] ?></p>
	<?php } } ?>
</div>
<div class="col-sm-2 col-md-2">
	<button type="button" class=" glyphicon glyphicon-pencil pull-right ml3"
				data-toggle="modal" data-target="#edit-checkbox1"></button>
	<button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
</div>
<?php } ?>
<?php if ($checkBoxData2) { ?>
<div class="col-sm-10 col-md-10">
	<p><strong><?php echo $checkBoxData2['TITLE'] ?></strong></p>
	<p><?php echo $checkBoxData2['TEXT_BEFORE'] ?></p>
	<?php 
		if(isset($checkBoxData2['data']) && $checkBoxData2['data']) { 
        foreach ($checkBoxData2['data'] as $row) { ?>
		<p><?php echo $row['TEMP_TEXT'] ?></p>
	<?php } } ?>
</div>
<div class="col-sm-2 col-md-2">
	<button type="button" class=" glyphicon glyphicon-pencil pull-right ml3"
				data-toggle="modal" data-target="#edit-checkbox2"></button>
	<button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
</div>
<?php } ?>
<?php if ($checkBoxData3) { ?>
<div class="col-sm-10 col-md-10">
	<p><strong><?php echo $checkBoxData3['TITLE'] ?></strong></p>
	<p><?php echo $checkBoxData3['TEXT_BEFORE'] ?></p>
	<?php 
		if(isset($checkBoxData3['data']) && $checkBoxData3['data']) { 
        foreach ($checkBoxData3['data'] as $row) { ?>
		<p><?php echo $row['TEMP_TEXT'] ?></p>
	<?php } } ?>
</div>
<div class="col-sm-2 col-md-2">
	<button type="button" class=" glyphicon glyphicon-pencil pull-right ml3"
				data-toggle="modal" data-target="#edit-checkbox3"></button>
	<button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
</div>
<?php } ?>
<?php if ($checkBoxData4) { ?>
<div class="col-sm-10 col-md-10">
	<p><strong><?php echo $checkBoxData4['TITLE'] ?></strong></p>
	<p><?php echo $checkBoxData4['TEXT_BEFORE'] ?></p>
	<?php 
		if(isset($checkBoxData4['data']) && $checkBoxData4['data']) { 
        foreach ($checkBoxData4['data'] as $row) { ?>
		<p><?php echo $row['TEMP_TEXT'] ?></p>
	<?php } } ?>
</div>
<div class="col-sm-2 col-md-2">
	<button type="button" class=" glyphicon glyphicon-pencil pull-right ml3"
				data-toggle="modal" data-target="#edit-checkbox4"></button>
	<button type="button" class=" glyphicon glyphicon-unchecked pull-right"></button>
</div>
<?php } ?>
<?php include 'grid1modal.php'; ?>
<?php include 'grid2modal.php'; ?>
<?php include 'checkBoxModal.php'; ?>
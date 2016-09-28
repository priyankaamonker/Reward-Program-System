<table style="width:100%;" cellspacing="3" cellpadding="3">
	<tr class="even">
		<td>Reward Program title</td>
		<td><?php echo $rewardprogram_item->title; ?></td>
	</tr>
	<tr>
		<td>Reward Program description</td>
		<td><?php echo $rewardprogram_item->description; ?></td>
	</tr>
	<tr class="even">
		<td>Reward Program type</td>
		<td><?php echo ($rewardprogram_item->type==1) ? "Sale" : "Training"; ?></td>
	</tr>		
	<tr>
		<td colspan="2">
			<br>
			<table width="100%" class="qitems">
				<tr>
					<td colspan="2"><b>Qualifying <?php if($rewardprogram_item->type=="1") echo "Product"; else echo "Course"; ?></b></td>
				</tr>
				<tr>
					<th>Item</th>
					<th>Reward Amount</th>
				</tr>
				<?php foreach($rewardprogram_item->qitems as $key => $val) { ?>
				<tr>
					<td><?php echo $rewardprogram_item->qitems[$key]->item_details[0]['title']; ?></td>
					<td><?php echo $rewardprogram_item->qitems[$key]->amount; ?></td>
				</tr>
				<?php } ?>
			</table>
			<br>
		</td>
	</tr>	
	<tr class="even">
		<td>Reward Program valid untill</td>
		<td><?php echo $rewardprogram_item->validity; ?></td>
	</tr>	
	<tr>
		<td>Reward Program status</td>
		<td><?php echo ($rewardprogram_item->status) ? "Active" : "Inactive";?></td>
	</tr>		
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td class="align-right">
			<a href="<?php echo base_url(); ?>rewardprogram/edit/<?php echo $rewardprogram_item->id; ?>">Edit</a>&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>rewardprogram">Back</a>
		</td>
	</tr>		
</table>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
		<tr>
			<td colspan="2">
			<b>Reward Request by <i><?php echo $rewardrequest_item->user->firstname . " " . $rewardrequest_item->user->lastname; ?></i>
			From <?php echo $rewardrequest_item->user->company; ?></b>
			<hr />
			</td>
		</tr>
		<tr>
			<td style="width:50%;">
				<table style="width:100%;" cellspacing="5" cellpadding="5">
					<tr>
						<td><b>Request Date:</b></td>
						<td><?php echo $rewardrequest_item->created; ?></td>
					</tr>		
					<tr>
						<td><b>Reward Program:</b></td>
						<td><?php echo $rewardrequest_item->program->title; ?></td>
					</tr>
					<tr>
						<td style="height:35px;"><b>Program Description:</b></td>
						<td><?php echo $rewardrequest_item->program->description; ?></td>
					</tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<table style="width:100%; background:#f6f0f0;" cellspacing="5" cellpadding="5">
					<tr>
						<td><b>Status:</b></td>
						<td>
							<?php
							if($rewardrequest_item->status == 1) $status = "Pending";
							if($rewardrequest_item->status == 2) $status = "Approved";
							if($rewardrequest_item->status == 3) $status = "Denied";
							if($rewardrequest_item->status == 4) $status = "Deleted";		
							echo $status . " as of " . $rewardrequest_item->last_activity;
							?>
						</td>
					</tr>		
					<tr>
						<td><b>Reward Amount:</b></td>
						<td>$<?php echo $rewardrequest_item->qitems[0]->amount; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if($rewardrequest_item->program->type == 1) { ?>
		<tr>
			<td colspan="2">
				<table width="100%" class="qitems" cellspacing="5" cellpadding="5">
					<tr>
						<td colspan="4"><h3>Proof of Performance</h3></td>
					</tr>	
					<tr class="tr-heading">
						<th>Product</th>
						<th>Order Date</th>
						<th>Quantity Sold</th>
						<th>Reward Amount</th>
					</tr>
					<tr>
						<td><?php echo $rewardrequest_item->qitems[0]->item_details[0]['title']; ?></td>
						<td><?php echo $rewardrequest_item->qitems[0]->completed_on; ?></td>
						<td><?php echo $rewardrequest_item->qitems[0]->quantity; ?></td>
						<td><?php echo $rewardrequest_item->qitems[0]->amount; ?></td>
					</tr>
				</table>			
			</td>
		</tr>	
		<?php } else { ?>
		<tr>
			<td colspan="2">
				<table width="100%" class="qitems" cellspacing="5" cellpadding="5">
					<tr>
						<td colspan="4"><h3>Proof of Performance</h3></td>
					</tr>	
					<tr class="tr-heading">
						<th>Training Course</th>
						<th>Date Completed</th>
						<th>Reward Amount</th>
					</tr>
					<tr>
						<td><?php echo $rewardrequest_item->qitems[0]->item_details[0]['title']; ?></td>
						<td><?php echo $rewardrequest_item->qitems[0]->completed_on; ?></td>
						<td><?php echo $rewardrequest_item->qitems[0]->amount; ?></td>
					</tr>
				</table>				
			</td>
		</tr>	
		<?php } ?>	
		<tr>
			<td colspan="2"><b>Comments:</b><?php echo $rewardrequest_item->comments; ?></td>
		</tr>		
		<tr>
			<td>&nbsp;</td>
			<td class="align-right">
				<a href="<?php echo base_url(); ?>rewardrequest/edit/<?php echo $rewardrequest_item->id; ?>">Edit</a>&nbsp;&nbsp;
				<a href="<?php echo base_url(); ?>rewardrequest">Back</a>
			</td>
		</tr>	
	</table>
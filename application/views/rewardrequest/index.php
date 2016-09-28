<table style="width:100%;">
	<?php if(isset($msg)) { ?>
		<tr>
			<td class="align-center notification"><?php print($msg); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td>
			<table style="width:100%;" cellspacing="3" cellpadding="3">
				<tr class="tr-heading">
					<td align="center">Request Time</td>
					<td>Reward Program</td>
					<td>Partner</td>
					<td>Reward Amount</td>
					<td>Status</td>
					<td colspan="5">Action</td>
				</tr>			
				<?php 
				$i = 1;
				foreach ($rewardrequest as $rewardrequest_item): 
					$class = ($i % 2) ? "even" : "odd"; // for templates having multiple rows
					$i++;
					
					if($rewardrequest_item->status == 1) $status = "Pending";
					if($rewardrequest_item->status == 2) $status = "Approved";
					if($rewardrequest_item->status == 3) $status = "Denied";
					if($rewardrequest_item->status == 4) $status = "Deleted";					
				?>
				<tr class="<?php echo $class; ?>">
					<td align="center"><?php echo date("m/d/Y H:sa", strtotime($rewardrequest_item->created)); ?></td>		
					<td><?php echo $rewardrequest_item->program->title; ?></td>
					<td><?php echo $rewardrequest_item->user->firstname . " " . $rewardrequest_item->user->lastname . "<br><i>".$rewardrequest_item->user->company."</i>"; ?></td>	
					<td>&nbsp;&nbsp;$<?php echo number_format($rewardrequest_item->amount,2); ?></td>
					<td><?php echo $status; ?><br><small>Since <?php echo date("m/d/Y", strtotime($rewardrequest_item->last_activity)); ?></small></td>		<td align="center">
					<?php if($rewardrequest_item->status != 4) { ?>
					<?php if($rewardrequest_item->status == 2) { ?>
					Approved<br><a href="<?php echo base_url(); ?>rewardrequest/reset/<?php echo $rewardrequest_item->uid . "/" . $rewardrequest_item->id; ?>"><small>Reset to Pending<small></a>
					<?php } else { ?>
					<a href="<?php echo base_url(); ?>rewardrequest/approve/<?php echo $rewardrequest_item->uid . "/" . $rewardrequest_item->id; ?>">Approve</a>
					<?php } ?>
					<?php } ?>
					</td>		
					<td align="center">
					<?php if($rewardrequest_item->status != 4) { ?>
					<?php if($rewardrequest_item->status == 3) { ?>
					Denied
					<?php } else { ?>
					<a href="<?php echo base_url(); ?>rewardrequest/deny/<?php echo $rewardrequest_item->uid . "/" . $rewardrequest_item->id; ?>">Deny</a><?php } ?>
					<?php } ?>
					</td>	
					<td><a href="<?php echo base_url(); ?>rewardrequest/view/<?php echo $rewardrequest_item->id; ?>">View</a></td>
					<td>Edit</td>
					<td><a href="<?php echo base_url(); ?>rewardrequest/destroy/<?php echo $rewardrequest_item->uid . "/" . $rewardrequest_item->id; ?>" onclick="return confirm('Are you sure you want to delete this reward request?')">Delete</a></td>
				</tr>				
				<?php endforeach; ?>			
			</table>
		</td>
	</tr>
</table>
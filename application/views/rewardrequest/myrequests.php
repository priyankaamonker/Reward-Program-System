	<table style="width:100%;" cellspacing="3" cellpadding="3">
		<tr>
			<td colspan="2"><h2>My Reward Requests</h2></td>
		</tr>	
		<tr>
			<td colspan="2" align="left"><a href="#reward-request" class="rr-buttonblue">Add a Request</a><br><br></td>
		</tr>		
		<tr>
		<td>
			<table style="width:100%;" cellspacing="3" cellpadding="3" class="hasborder">
				<tr class="tr-heading">
					<th align="center">Request Time</th>
					<th>Reward Program</th>
					<th align="center">Reward Amount</th>
					<th align="center">Status</th>									
					<th colspan="2">&nbsp;</th>
				</tr>			
				<?php 
				foreach ($myrequests as $request) {
					if($request->status == 1) $status = "Pending";
					if($request->status == 2) $status = "Approved";
					if($request->status == 3) $status = "Denied";
					if($request->status == 4) $status = "Deleted";
				?>
				<tr>
					<td align="center"><?php echo date($this->session->userdata('date_format') . " h:ia",strtotime($request->created)); ?></td>	
					<td><?php echo $request->program->title ?></td>	
					<td align="center"><?php echo "$" . $request->amount; ?></td>						
					<td align="center"><?php echo $status; ?></td>				
					<td><?php if($request->status == 1) { ?><a href="#" class="rr-buttonblue">Edit</a><?php } ?></td>		
					<td>
					<?php if($request->status == 1) { ?>
					<a href="<?php echo base_url(); ?>rewardrequest/delete/<?php echo $request->uid; ?>/<?php echo $request->id; ?>" onclick="return confirm('Are you sure you want to delete this reward request?')" class="rr-buttonorange">Delete</a>
					<?php } ?>
					</td>	
				</tr>			
				<?php } ?>			
			</table>
		</td>
		</tr>
	</table>
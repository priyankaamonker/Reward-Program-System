<table style="width:100%;">
	<?php if(isset($msg)) { ?>
		<tr>
			<td class="align-center notification"><?php print($msg); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td class="align-right"><a href="<?php echo base_url(); ?>rewardprogram/create">Add new reward program</a></td>
	</tr>
	<tr>
		<td>
			<table style="width:100%;" cellspacing="3" cellpadding="3">
				<tr class="tr-heading">
					<td>Title</td>
					<td>Type</td>
					<td>Status</td>
					<td colspan="2">Action</td>
				</tr>			
				<?php 
				$i = 1;
				foreach ($rewardprogram as $rewardprogram_item): 
					$class = ($i % 2) ? "even" : "odd"; // for templates having multiple rows
					$i++;
				?>
				<tr class="<?php echo $class; ?>">
					<td><a href="<?php echo base_url(); ?>rewardprogram/view/<?php echo $rewardprogram_item->id; ?>"><?php echo $rewardprogram_item->title; ?></a></td>		
					<td><?php echo ($rewardprogram_item->type==1) ? "Sale" : "Training"; ?></td>
					<td><?php echo ($rewardprogram_item->status) ? "Active" : "Inactive"; ?></td>				
					<td><a href="<?php echo base_url(); ?>rewardprogram/edit/<?php echo $rewardprogram_item->id; ?>">Edit</a></td>		
					<td><a href="<?php echo base_url(); ?>rewardprogram/delete/<?php echo $rewardprogram_item->id; ?>" onclick="return confirm('Are you sure you want to delete this reward program?')">Delete</a></td>	
				</tr>				
				<?php endforeach; ?>			
			</table>
		</td>
	</tr>
</table>
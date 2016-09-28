<table style="width:100%;">
	<?php if(isset($msg)) { ?>
		<tr>
			<td class="align-center notification"><?php print($msg); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td class="align-right"><a href="<?php echo base_url(); ?>user/create">Add new user</a></td>
	</tr>
	<tr>
		<td>
			<table style="width:100%;" cellspacing="3" cellpadding="3">
				<tr class="tr-heading">
					<td>Name</td>
					<td>Email</td>
					<td>Company</td>
					<td>Status</td>
					<td colspan="2">Action</td>
				</tr>			
				<?php 
				$i = 1;
				foreach ($user as $user_item): 
					$class = ($i % 2) ? "even" : "odd"; // for templates having multiple rows
					$i++;
				?>
				<tr class="<?php echo $class; ?>">
					<td><a href="<?php echo base_url(); ?>user/view/<?php echo $user_item->id; ?>"><?php echo $user_item->firstname . " " . $user_item->lastname; ?></a></td>		
					<td><?php echo $user_item->email; ?></td>
					<td><?php echo $user_item->company; ?></td>
					<td><?php echo ($user_item->status) ? "Active" : "Inactive"; ?></td>				
					<td><a href="<?php echo base_url(); ?>user/edit/<?php echo $user_item->id; ?>">Edit</a></td>		
					<td><a href="<?php echo base_url(); ?>user/delete/<?php echo $user_item->id; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></td>	
				</tr>				
				<?php endforeach; ?>			
			</table>
		</td>
	</tr>
</table>
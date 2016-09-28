<table style="width:100%;" cellspacing="3" cellpadding="3">
	<tr class="even">
		<td>First Name</td>
		<td><?php echo $user_item->firstname; ?></td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><?php echo $user_item->lastname; ?></td>
	</tr>
	<tr class="even">
		<td>Email</td>
		<td><?php echo $user_item->email; ?></td>
	</tr>
	<tr>
		<td>Company</td>
		<td><?php echo $user_item->company; ?></td>
	</tr>	
	<tr class="even">
		<td>Role</td>
		<td><?php echo ($user_item->role == 1) ? "Employee" : "Partner"; ?></td>
	</tr>
	<tr>
		<td>Date Format</td>
		<td><?php echo $user_item->date_format; ?></td>
	</tr>	
	<tr class="even">
		<td>Status</td>
		<td><?php echo ($user_item->status) ? "Active" : "Inactive";?></td>
	</tr>		
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td class="align-right">
			<a href="<?php echo base_url(); ?>user/edit/<?php echo $user_item->id; ?>">Edit</a>&nbsp;&nbsp;
		</td>
	</tr>		
</table>
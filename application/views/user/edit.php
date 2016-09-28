<?php echo form_open('user/edit/'.$user_item->id); ?>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
	
		<?php if(validation_errors()) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo validation_errors(); ?></td>
		</tr>		
		<?php } ?>
		<tr>
			<td colspan="2"><h2>Update user</h2></td>
		</tr>
		<tr>
			<td>First Name *</td>
			<td><input type="text" name="firstname" value="<?php echo $user_item->firstname; ?>"></td>
		</tr>
		<tr>
			<td>Last Name *</td>
			<td><input type="text" name="lastname" value="<?php echo $user_item->lastname; ?>"></td>
		</tr>	
		<tr>
			<td>Email *</td>
			<td>
			<?php if($this->session->userdata('role')==2) { ?>
			<input type="text" name="email_dis" value="<?php echo $user_item->email; ?>" disabled>
			<input type="hidden" name="email" value="<?php echo $user_item->email; ?>">
			<?php } else { ?>
			<input type="text" name="email" value="<?php echo $user_item->email; ?>">
			<?php } ?>
			</td>
		</tr>	
		<tr>
			<td>Company </td>
			<td><input type="text" name="company" value="<?php echo $user_item->company; ?>"></td>
		</tr>	
		<?php if($this->session->userdata('role')==2) { ?>
		<input type="hidden" name="role" value="<?php echo $user_item->role; ?>">
		<?php } else { ?>		
		<tr>
			<td>Role </td>
			<td>
				<select name="role" id="role">
					<option value="1" <?php echo set_select('role', '1'); ?>>Employee</option>
					<option value="2" <?php echo set_select('role', '2'); ?>>Partner</option>
				</select>
			</td>
		</tr>	
		<?php } ?>
		<tr>
			<td>Date Format </td>
			<td>
				<select name="date_format" id="date_format">
					<option value="m-d-Y" <?php echo set_select('date_format', 'm-d-Y'); ?>>m-d-Y</option>
					<option value="d-m-Y" <?php echo set_select('date_format', 'd-m-Y'); ?>>d-m-Y</option>
					<option value="Y-m-d" <?php echo set_select('date_format', 'Y-m-d'); ?>>Y-m-d</option>					
				</select>			
			</td>
		</tr>	
		<?php if($this->session->userdata('role')==2) { ?>
		<input type="hidden" name="status" value="<?php echo $user_item->status; ?>">
		<?php } else { ?>		
		<tr>
			<td>Status</td>
			<td>
				<select name="status" id="status">
					<option value="1" <?php echo set_select('status', '1'); ?>>Active</option>
					<option value="0" <?php echo set_select('status', '0'); ?>>Inactive</option>
				</select>
			</td>
		</tr>
		<?php } ?>		
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Submit"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="align-right">* marked fields are mandatory</td>
		</tr>
	</table>
	<input type="hidden" name="id" id="id" value="<?php echo $user_item->id; ?>">
</form>

<?php if($user_item->role!="") { ?>
<script type="text/javascript">
  document.getElementById('role').value = "<?php echo $user_item->role;?>";
</script>
<?php } ?>

<?php if($user_item->date_format!="") { ?>
<script type="text/javascript">
  document.getElementById('date_format').value = "<?php echo $user_item->date_format;?>";
</script>
<?php } ?>

<?php if($user_item->status!="") { ?>
<script type="text/javascript">
  document.getElementById('status').value = "<?php echo $user_item->status;?>";
</script>
<?php } ?>
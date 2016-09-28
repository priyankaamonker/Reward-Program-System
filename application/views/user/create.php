<?php echo form_open('user/create'); ?>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
	
		<?php if(validation_errors()) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo validation_errors(); ?></td>
		</tr>		
		<?php } ?>
		<tr>
			<td colspan="2"><h2>Add a new user</h2></td>
		</tr>
		<tr>
			<td>First Name *</td>
			<td><input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>"></td>
		</tr>
		<tr>
			<td>Last Name *</td>
			<td><input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>"></td>
		</tr>	
		<tr>
			<td>Email *</td>
			<td><input type="text" name="email" value="<?php echo set_value('email'); ?>"></td>
		</tr>	
		<tr>
			<td>Password *</td>
			<td><input type="password" name="password" value="<?php echo set_value('password'); ?>"></td>
		</tr>
		<tr>
			<td>Confirm Password *</td>
			<td><input type="password" name="passconf" value="<?php echo set_value('passconf'); ?>"></td>
		</tr>	
		<tr>
			<td>Company </td>
			<td><input type="text" name="company" value="<?php echo set_value('company'); ?>"></td>
		</tr>		
		<tr>
			<td>Role </td>
			<td>
				<select name="role" id="role">
					<option value="1" <?php echo set_select('role', '1'); ?>>Employee</option>
					<option value="2" <?php echo set_select('role', '2'); ?>>Partner</option>
				</select>			
			</td>
		</tr>	
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
		<tr>
			<td>Status</td>
			<td>
				<select name="status" id="status">
					<option value="1" <?php echo set_select('status', '1'); ?>>Active</option>
					<option value="0" <?php echo set_select('status', '0'); ?>>Inactive</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Submit"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="align-right">* marked fields are mandatory</td>
		</tr>
	</table>
</form>
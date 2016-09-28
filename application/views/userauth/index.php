<?php echo form_open('userauth/login'); ?>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
	
		<?php if(validation_errors()) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo validation_errors(); ?></td>
		</tr>		
		<?php } ?>
		
		<?php if(isset($msg)) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo $msg; ?></td>
		</tr>		
		<?php } ?>
		
		<tr>
			<td>Username</td>
			<td><input type="text" name="email" value="<?php echo set_value('email'); ?>"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name="password" value="<?php echo set_value('password'); ?>"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Login"></td>
		</tr>
	</table>
</form>
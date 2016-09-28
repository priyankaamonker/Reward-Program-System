<?php echo form_open('course/edit/'.$course_item['id']); ?>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
	
		<?php if(validation_errors()) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo validation_errors(); ?></td>
		</tr>		
		<?php } ?>
		<tr>
			<td colspan="2"><h2>Update course</h2></td>
		</tr>
		<tr>
			<td>Course title *</td>
			<td><input type="text" name="title" value="<?php echo $course_item['title']; ?>"></td>
		</tr>
		<tr>
			<td>Course description</td>
			<td><textarea name="description" rows="10" cols="25"><?php echo $course_item['description']; ?></textarea></td>
		</tr>
		<tr>
			<td>Course status</td>
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
	<input type="hidden" name="id" id="id" value="<?php echo $course_item['id']; ?>">
</form>

<?php if($course_item['status']!="") { ?>
<script type="text/javascript">
  document.getElementById('status').value = "<?php echo $course_item['status'];?>";
</script>
<?php } ?>
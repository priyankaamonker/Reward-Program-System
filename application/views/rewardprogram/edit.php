<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
  $(function() {
    $( "#validity" ).datepicker();
  });
</script>

<?php echo form_open('rewardprogram/edit/'.$rewardprogram_item->id); ?>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
	
		<?php if(validation_errors()) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo validation_errors(); ?></td>
		</tr>		
		<?php } ?>
		<tr>
			<td colspan="2"><h2>Update reward program</h2></td>
		</tr>
		<tr>
			<td>Reward Program title *</td>
			<td><input type="text" name="title" value="<?php echo $rewardprogram_item->title; ?>"></td>
		</tr>
		<tr>
			<td>Reward Program description</td>
			<td><textarea name="description" rows="10" cols="25"><?php echo $rewardprogram_item->description; ?></textarea></td>
		</tr>
		<tr>
			<td>Reward Program type *</td>
			<td><?php echo ($rewardprogram_item->type==1) ? "Sale" : "Training"; ?></td>
		</tr>	
		<tr>
			<td colspan="2">
				<br>
				<table width="100%" class="qitems">
					<tr>
						<td colspan="2"><b>Qualifying <?php if($rewardprogram_item->type=="1") echo "Product"; else echo "Course"; ?></b></td>
					</tr>
					<tr>
						<th>Item</th>
						<th>Reward Amount</th>
					</tr>
					<?php foreach($rewardprogram_item->qitems as $key => $val) { ?>
					<tr>
						<td><?php echo $rewardprogram_item->qitems[$key]->item_details[0]['title']; ?></td>
						<td><?php echo $rewardprogram_item->qitems[$key]->amount; ?></td>
					</tr>
					<?php } ?>
				</table>
				<br>
			</td>
		</tr>		
		<tr>
			<td>Reward Program valid untill *</td>
			<td>
				<input type="text" name="validity" id="validity" value="<?php echo $rewardprogram_item->validity; ?>">
			</td>
		</tr>		
		<tr>
			<td>Reward Program status</td>
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
	<input type="hidden" name="id" id="id" value="<?php echo $rewardprogram_item->id; ?>">
	<input type="hidden" name="type" id="type" value="<?php echo $rewardprogram_item->type; ?>">
</form>

<?php if($rewardprogram_item->status!="") { ?>
<script type="text/javascript">
  document.getElementById('status').value = "<?php echo $rewardprogram_item->status;?>";
</script>
<?php } ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
  $(function() {
    $( "#validity" ).datepicker();
  });
</script>

<?php echo form_open('rewardprogram/create'); ?>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
	
		<?php if(validation_errors()) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo validation_errors(); ?></td>
		</tr>		
		<?php } ?>
		<tr>
			<td colspan="2"><h2>Add a new reward program</h2></td>
		</tr>
		<tr>
			<td>Reward Program title *</td>
			<td><input type="text" name="title" value="<?php echo set_value('title'); ?>"></td>
		</tr>
		<tr>
			<td>Reward Program description</td>
			<td><textarea name="description" rows="10" cols="25"><?php echo set_value('description'); ?></textarea></td>
		</tr>
		<tr>
			<td>Reward Program type *</td>
			<td>
				<select name="type" id="type">
					<option value="">Select</option>
					<option value="1" <?php echo set_select('type', '1'); ?>>Sale</option>
					<option value="2" <?php echo set_select('type', '2'); ?>>Training</option>
				</select>
			</td>
		</tr>		
		<!--Hidden components -->
		<?php $this->load->view ('rewardprogram/_qproduct'); ?>
		<?php $this->load->view ('rewardprogram/_qcourse'); ?>
		<!--Hidden components - end -->		
		<tr>
			<td>Reward Program valid untill *</td>
			<td>
				<input type="text" name="validity" id="validity" value="<?php echo set_value('validity'); ?>">
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
</form>

<script type="text/javascript">
$("#type").change ( function () {
    var targID  = $(this).val ();
    $("tr.type-sub").hide ();
	$("tr.type-sub :input").val("");
    $('#' + targID).show ();
} );
</script>

<script src="<?php echo base_url(); ?>public/js/dynamic_items/jquery.duplicate1.js"></script>
<script type="text/javascript">
	var iCntc = 0;
	$('#addc').click(function() {
		if (iCntc < 4) {
            iCntc = iCntc + 1;
		} else {
		    $('#addc').attr('disabled', 'disabled');
			$('#msglabelc').append('<label style="color:red;">&nbsp;Reached the limit.</label>'); 
		}
	});
	var iCntp = 0;
	$('#addp').click(function() {
		if (iCntp < 4) {
            iCntp = iCntp + 1;
		} else {
		    $('#addp').attr('disabled', 'disabled');
			$('#msglabelp').append('<label style="color:red;">&nbsp;Reached the limit.</label>'); 
		}
	});	
</script>
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
			<td>
				<select name="type" id="type">
					<option value="">Select</option>
					<option value="1" <?php echo set_select('type', '1'); ?>>Sale</option>
					<option value="2" <?php echo set_select('type', '2'); ?>>Training</option>
				</select>
			</td>
		</tr>		
		<!--Hidden components -->
		<!--Qualifying products -->
		<tr id="1" class="type-sub" <?php if($rewardprogram_item->type!=1) echo 'style="display: none;"'; ?> name="Sale">
			<td colspan="2">
				<br>
				<table width="100%" class="qitems" id="qitems">
					<tr>
						<td colspan="2"><b>Qualifying Product</b></td>
					</tr>
					<tr>
						<th>Product</th>
						<th>Reward Amount</th>
					</tr>
					<tr>
						<td>
							<select name="qproduct" id="qproduct">
								<option value="">Select</option>
								<?php for($i=0; $i<count($qproducts); $i++) { 
								echo '<option value="'.$qproducts[$i]['id'].'" '.set_select("qproduct", $qproducts[$i]['id']).'>'.$qproducts[$i]['title'].'</option>';
								} ?>
							</select>
						</td>
						<td><input type="text" name="product_reward_amount" id="product_reward_amount" value="<?php echo isset($product_reward_amount) ? $product_reward_amount : ""; ?>"> *</td>
					</tr>
				</table>
				<br>
			</td>
		</tr>
		<!--Qualifying products - end -->
		
		<!--Qualifying courses --> 
		<tr id="2" class="type-sub" <?php if($rewardprogram_item->type!=2) echo 'style="display: none;"'; ?> name="Training">
			<td colspan="2">
				<br>
				<table width="100%" class="qitems" id="qitems">
					<tr>
						<td colspan="2"><b>Qualifying Course</b></td>
					</tr>
					<tr>
						<th>Course</th>
						<th>Reward Amount</th>
					</tr>
					<tr>
						<td>
							<select name="qcourse" id="qcourse">
								<option value="">Select</option>
								<?php for($i=0; $i<count($qcourses); $i++) {
								echo '<option value="'.$qcourses[$i]['id'].'" '.set_select("qcourse", $qcourses[$i]['id']).'>'.$qcourses[$i]['title'].'</option>';
								} ?>
							</select>
						</td>
						<td><input type="text" name="course_reward_amount" id="course_reward_amount" value="<?php echo isset($course_reward_amount) ? $course_reward_amount : ""; ?>"> *</td>
					</tr>
				</table>
				<br>
			</td>
		</tr>  
		<!--Qualifying products - end -->
		<!--Hidden components - end -->		
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
</form>

<?php if($rewardprogram_item->type!="") { ?>
<script type="text/javascript">
  document.getElementById('type').value = "<?php echo $rewardprogram_item->type;?>";
</script>
<?php } ?>

<?php if(isset($qproduct)) { ?>
<script type="text/javascript">
  document.getElementById('qproduct').value = "<?php echo $qproduct;?>";
</script>
<?php } ?>

<?php if(isset($qcourse)) { ?>
<script type="text/javascript">
  document.getElementById('qcourse').value = "<?php echo $qcourse;?>";
</script>
<?php } ?>

<?php if($rewardprogram_item->status!="") { ?>
<script type="text/javascript">
  document.getElementById('status').value = "<?php echo $rewardprogram_item->status;?>";
</script>
<?php } ?>

<script type="text/javascript">
$("#type").change ( function () {
    var targID  = $(this).val ();
    $("tr.type-sub").hide ();
	$("tr.type-sub :input").val("");
    $('#' + targID).show ();
} );
</script>
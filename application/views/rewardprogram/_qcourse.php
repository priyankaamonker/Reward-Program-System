		<!--Qualifying courses -->
		<tr id="2" class="type-sub" <?php if(set_value('type')!=2) echo 'style="display: none;"'; ?> name="Training">
			<td colspan="2">
				<br>
				<table width="100%" class="qitems" id="qitems">
					<tr>
						<td colspan="3"><b>Qualifying Course</b></td>
					</tr>
					<tr>
						<th>Course</th>
						<th colspan="2">Reward Amount</th>
					</tr>
					<tr data-duplicate="qitemc" id="qitemc">
						<td>
							<select name="qcourse[]" id="qcourse">
								<option value="">Select</option>
								<?php for($i=0; $i<count($qcourses); $i++) {
									echo '<option value="'.$qcourses[$i]['id'].'">'.$qcourses[$i]['title'].'</option>';
								 } 
								?>
							</select>
						</td>
						<td><input type="text" name="course_reward_amount[]" id="course_reward_amount"> *</td>
						<td><button type="button" id="remove" data-duplicate-remove="qitemc">Remove</button></td>
					</tr>
					<tr>
						<td colspan="3" id="msglabelc"><button type="button" id="addc" data-duplicate-add="qitemc">Add another course</button></td>
					</tr>					
				</table>
				<br>
			</td>
		</tr>  
		<!--Qualifying products - end -->
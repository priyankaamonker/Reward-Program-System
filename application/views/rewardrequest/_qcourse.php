							<select name="qcourse[]" id="qcourse" onchange="getAmount(this.value, this.parentNode.parentNode.id);" class="qcourse">
								<option value="">Select</option>
								<?php for($i=0; $i<count($qitems); $i++) {
									echo '<option value="'.$qitems[$i]->item_details[0]['id'].'">'.$qitems[$i]->item_details[0]['title'].'</option>';
									} 
								?>
							</select>
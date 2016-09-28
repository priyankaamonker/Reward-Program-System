							<select name="qproduct[]" id="qproduct" onchange="getAmount(this.value, this.parentNode.parentNode.id);" class="qproduct">
								<option value="">Select</option>
								<?php for($i=0; $i<count($qitems); $i++) {
									echo '<option value="'.$qitems[$i]->item_details[0]['id'].'">'.$qitems[$i]->item_details[0]['title'].'</option>';
									} 
								?>
							</select>
		<!--Qualifying products -->
		<tr id="1" class="type-sub" <?php if(set_value('type')!=1) echo 'style="display: none;"'; ?> name="Sale">
			<td colspan="2">
				<br>
				<table width="100%" class="qitems" id="qitems">
					<tr>
						<td colspan="3"><b>Qualifying Product</b></td>
					</tr>
					<tr>
						<th>Product</th>
						<th colspan="2">Reward Amount</th>
					</tr>
					<tr data-duplicate="qitemp" id="qitemp">
						<td>
							<select name="qproduct[]" id="qproduct">
								<option value="">Select</option>
								<?php for($i=0; $i<count($qproducts); $i++) {
									echo '<option value="'.$qproducts[$i]['id'].'">'.$qproducts[$i]['title'].'</option>';
									} 
								?>
							</select>
						</td>
						<td><input type="text" name="product_reward_amount[]" id="product_reward_amount"> *</td>
						<td><button type="button" id="remove" data-duplicate-remove="qitemp">Remove</button></td>
					</tr>
					<tr>
						<td colspan="3" id="msglabelp"><button type="button" id="addp" data-duplicate-add="qitemp">Add another product</button></td>
					</tr>
				</table>
				<br>
			</td>
		</tr>
		<!--Qualifying products - end -->
<table style="width:100%;" cellspacing="3" cellpadding="3">
	<tr class="even">
		<td>Product title</td>
		<td><?php echo $product_item['title']; ?></td>
	</tr>
	<tr>
		<td>Product description</td>
		<td><?php echo $product_item['description']; ?></td>
	</tr>
	<tr class="even">
		<td>Product status</td>
		<td><?php echo ($product_item['status']) ? "Active" : "Inactive";?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td class="align-right">
			<a href="<?php echo base_url(); ?>product/edit/<?php echo $product_item['id']; ?>">Edit</a>&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>product">Back</a>
		</td>
	</tr>		
</table>
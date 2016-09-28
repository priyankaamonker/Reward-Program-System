<table style="width:100%;" cellspacing="3" cellpadding="3">
	<tr class="even">
		<td>Course title</td>
		<td><?php echo $course_item['title']; ?></td>
	</tr>
	<tr>
		<td>Course description</td>
		<td><?php echo $course_item['description']; ?></td>
	</tr>
	<tr class="even">
		<td>Course status</td>
		<td><?php echo ($course_item['status']) ? "Active" : "Inactive";?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td class="align-right">
			<a href="<?php echo base_url(); ?>course/edit/<?php echo $course_item['id']; ?>">Edit</a>&nbsp;&nbsp;
			<a href="<?php echo base_url(); ?>course">Back</a>
		</td>
	</tr>		
</table>
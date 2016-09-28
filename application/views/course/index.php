<table style="width:100%;">
	<?php if(isset($msg)) { ?>
		<tr>
			<td class="align-center notification"><?php print($msg); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td class="align-right"><a href="<?php echo base_url(); ?>course/create">Add new course</a></td>
	</tr>
	<tr>
		<td>
			<table style="width:100%;" cellspacing="3" cellpadding="3">
				<tr class="tr-heading">
					<td>Title</td>
					<td>Status</td>
					<td colspan="2">Action</td>
				</tr>			
				<?php 
				$i = 1;
				foreach ($course as $course_item): 
					$class = ($i % 2) ? "even" : "odd"; // for templates having multiple rows
					$i++;
				?>
				<tr class="<?php echo $class; ?>">
					<td><a href="<?php echo base_url(); ?>course/view/<?php echo $course_item['id']; ?>"><?php echo $course_item['title']; ?></a></td>		
					<td><?php echo ($course_item['status']) ? "Active" : "Inactive"; ?></td>				
					<td><a href="<?php echo base_url(); ?>course/edit/<?php echo $course_item['id']; ?>">Edit</a></td>		
					<td><a href="<?php echo base_url(); ?>course/delete/<?php echo $course_item['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a></td>	
				</tr>				
				<?php endforeach; ?>			
			</table>
		</td>
	</tr>
</table>
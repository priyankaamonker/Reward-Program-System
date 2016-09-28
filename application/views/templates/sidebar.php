	<ul>
		<li><a href="<?php echo base_url(); ?>">Home</a></li>		
		<?php if($this->session->userdata('role') == "1") { ?>
		<li><a href="<?php echo base_url(); ?>rewardrequest">Review Requests</a></li>					
		<li><a href="<?php echo base_url(); ?>rewardprogram">Reward Programs</a></li>
		<li><a href="<?php echo base_url(); ?>course">Courses</a></li>
		<li><a href="<?php echo base_url(); ?>product">Products</a></li>
		<li><a href="<?php echo base_url(); ?>user">Users</a></li>
		<?php } ?>
		<li><a href="<?php echo base_url(); ?>user/profile">Profile</a></li>
		<li><a href="<?php echo base_url(); ?>logout">Logout</a></li>
	</ul>
			
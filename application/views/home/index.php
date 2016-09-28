<?php if($this->session->userdata('logged_in') == false) { ?>
<p>Welcome Guest!</p>
<p>Please click <a href="<?php echo base_url(); ?>login">here</a> to Login.
<?php } else { ?>

	<?php  if($this->session->userdata('role') == "1") { ?>
	<p><h3>Welcome <?php echo $this->session->userdata('firstname') . " " . $this->session->userdata('lastname'); ?></h3></p>
	<p>Your last activity was on <?php echo date('F d, Y', strtotime($this->session->userdata('last_activity'))); ?></p>
	<?php } ?>

	<?php if( $this->session->userdata('role') == "2") { ?>	
	<!-- Supporting files for tabs -->
	<script src="public/js/easytabs/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="public/js/easytabs/jquery.hashchange.min.js" type="text/javascript"></script>
	<script src="public/js/easytabs/jquery.easytabs.js" type="text/javascript"></script>
	
	<script type="text/javascript">
		$(document).ready( function() {
			$('#tab-container').easytabs();
		});
	</script>
	  
	<div id="tab-container" class="tab-container">
		<ul class='etabs'>
			<li class='tab'><a href="#welcome">Welcome</a></li>
			<li class='tab'><a href="#reward-request">Request a Reward</a></li>
			<li class='tab'><a href="#my-requests">My Reward Requests</a></li>
		</ul>
		<div class="tab-content" id="welcome">
			<p><h3>Welcome, <?php echo $this->session->userdata('firstname') . " " . $this->session->userdata('lastname'); ?></h3></p>	
			<?php $this->load->view ('home/pending_requests'); ?>
			<br>
			<p><h3>Available Reward Programs</h3></p>
			<p>Earn cash for selling Barracuda products and completing courses.</p>	
			<br><br>
			<?php $this->load->view ('home/reward_programs'); ?>	
		</div>
		<div class="tab-content" id="reward-request">
			<?php $this->load->view ('rewardrequest/create', $reward_program); ?>	
		</div>
		<div class="tab-content" id="my-requests">
			<?php $this->load->view ('rewardrequest/myrequests', $myrequests); ?>	
		</div>
	</div>
	<?php } ?>
	
<?php } ?>
<!-- Supporting file dynamic elements -->
<script src="<?php echo base_url(); ?>public/js/dynamic_items/jquery.duplicate.js"></script>
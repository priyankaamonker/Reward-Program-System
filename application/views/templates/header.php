<!DOCTYPE html> 
<html> 
	<head> 
	<title>Barracuda <?php echo $title; ?></title> 	
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
</head> 
<body> 

<div>
	<div class="header">
		<table>
			<tr>
				<td><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>public/img/barracuda_icon.jpg" alt="Barracuda" /></a></td>
				<td><h2>Barracuda</h2></td>
			</tr>
		</table>
	</div>
	<div class="main_container">
		<table style="width:100%;">
			<tr>
				<td class="sidebar">
				<?php if($this->session->userdata('logged_in') == true) { ?>
					Welcome, <?php echo $this->session->userdata('firstname') . ".";?>
					<?php $this->load->view ('templates/sidebar');  ?>
				<?php } ?>
				</td>
				<td class="container">
					<h1><?php echo $title?></h1>
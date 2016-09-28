<table style="width:100%;" class="rrclass">
<?php for($i=0; $i<count($reward_program);$i++) { ?>
<tr>
	<td style="width:70%;"><?php echo $reward_program[$i]['title']; ?><p><?php echo $reward_program[$i]['description']; ?></p></td>
	<td class="align-right"><a href="#reward-request?id=<?php echo $reward_program[$i]['id']; ?>" class="rr-button">Request Reward</a></td>
</tr>
<?php } ?>
</table>
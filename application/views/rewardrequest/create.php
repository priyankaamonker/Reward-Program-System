<?php echo form_open('rewardrequest/create', array('id'=>'reward_request_create', 'novalidate' => 'novalidate')); ?>
	<table style="width:100%;" cellspacing="3" cellpadding="3">
	
		<?php if(validation_errors()) { ?>
		<tr>
			<td colspan="2" class="align-center notification"><?php echo validation_errors(); ?></td>
		</tr>		
		<?php } ?>
		<tr>
			<td colspan="2"><h2>Submit Request</h2></td>
		</tr>
		<tr>
			<td style="width:50%;">
				<table style="width:100%;" cellspacing="5" cellpadding="5">
					<tr>
						<td><b>Request Date:</b></td>
						<td>
							<input type="text" name="requestdate" id="requestdate" value="<?php echo date('F d, Y'); ?>" disabled>
						</td>
					</tr>		
					<tr>
						<td style="vertical-align:top;"><b>Reward Program:</b></td>
						<td>
							<select name="rp_id" id="rp_id" onchange="populateThis(this.value);">
								<option value="">Select</option>
							<?php
								foreach($reward_program as $key => $val){
									echo '<option value="'.$reward_program[$key]['id'].'" '.set_select('rp_id', $reward_program[$key]['id']).'>'.$reward_program[$key]['title'].'</option>';
								}
							?>
							</select>
						</td>
					</tr>
					<tr><td colspan="2" id="description" style="height:35px;"></td></tr>
				</table>
			</td>
			<td style="vertical-align:top;">
				<table style="width:100%; background:#f6f0f0;" cellspacing="5" cellpadding="5">
					<tr>
						<td><b>Status:</b></td>
						<td>Pending as of <?php echo date($this->session->userdata('date_format')); ?></td>
					</tr>		
					<tr>
						<td><b>Reward Amount:</b></td>
						<td>$<span id="calamount">0</span></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>		
		<!--Hidden components -->
		<tr>
			<td colspan="2">
				<!--Qualifying products -->		
				<table width="100%" class="qitems" id="sale" cellspacing="5" cellpadding="5" style="display:none;">
					<tr>
						<td colspan="5"><h3>Proof of Performance</h3></td>
					</tr>	
					<tr class="tr-heading">
						<th>Product</th>
						<th>Order Date</th>
						<th>Quantity Sold</th>
						<th>Reward Amount</th>
						<th>&nbsp;</th>
					</tr>
					<tr data-duplicate="qitemp" id="qitem1">
						<td class="qProductContainer"></td>
						<td align="center"><input type="text" name="qpcompleted_date[]" class="completed_date"> *</td>
						<td align="center"><input type="text" name="qpquantity[]" id="qpquantity" value="" onchange="getAmount(document.getElementById('qproduct').value, this.parentNode.parentNode.id);" class="qpquantity"> *</td>
						<td id="itemamount" align="center"></td>
						<td align="center"><button type="button" id="remove" data-duplicate-remove="qitemp" class="rr-buttonorange removep">Remove</button></td>
					</tr>
					<tr>
						<td colspan="5"><button type="button" id="addp" data-duplicate-add="qitemp" class="rr-buttonblue">Add Another Product</button><span id="msglabelp"></span></td>
					</tr>
				</table>
				<!--Qualifying products - end -->
				<!--Qualifying courses -->	
				<table width="100%" class="qitems" id="training" cellspacing="5" cellpadding="5" style="display:none;">
					<tr>
						<td colspan="5"><h3>Proof of Performance</h3></td>
					</tr>				
					<tr class="tr-heading">
						<th>Training Course</th>
						<th>Date Completed</th>
						<th style="width:1px;padding:0;"></th>
						<th>Reward Amount</th>
						<th>&nbsp;</th>
					</tr>
					<tr data-duplicate="qitemc" id="qitem1">
						<td class="qCourseContainer"></td>
						<td align="center"><input type="text" name="qccompleted_date[]" class="completed_date"> *</td>
						<td style="width:1px;padding:0;"></td>
						<td id="itemamount" align="center"></td>
						<td align="center"><button type="button" id="remove" data-duplicate-remove="qitemc" class="rr-buttonorange removec">Remove</button></td>
					</tr>
					<tr>
						<td colspan="5"><button type="button" id="addc" data-duplicate-add="qitemc" class="rr-buttonblue">Add Another Course</button><span id="msglabelc"></span></td>
					</tr>					
				</table>
				<!--Qualifying course - end -->			
			</td>
		</tr>  	
		<!--Hidden components - end -->							
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">Comments<br /><textarea name="comments" id="comments" style="width:100%;" rows="7"></textarea></td>
		</tr>		
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="Submit" class="rr-button"></td>
		</tr>
	</table>
	<input type="hidden" name="uid" value="<?php echo $this->session->userdata('id'); ?>">
</form>

<script>
//Ajax for reward program description and populating items
function populateThis(str) {
  document.getElementById("calamount").innerHTML = 0;
  if (str == "") {
    document.getElementById("description").innerHTML = "";
	document.getElementById("training").style.display = "none";
	document.getElementById("sale").style.display = "none";
    return;
  }
  resetValues();
  getProgramtype();
  getProgramdesc();
}

function resetValues(){
	var classArray = ['completed_date','qcourse','qproduct','qpquantity'];
	 for(var k = 0; k < classArray.length; k++) {
		var x = document.getElementsByClassName(classArray[k]);
		for(var i = 0; i < x.length; i++) {
			x[i].value = "";
		}
	 }
}
  
function getProgramtype() { //call #1
	var str = document.getElementById("rp_id").value;
	$.ajax({
		url: "<?php echo base_url();?>rewardprogram/programtype/"+str, 
		success: function(result){
			var programType = result;
			if(programType == 1){$("#training").hide(); $("#sale").show ();}
		    if(programType == 2){$("#sale").hide(); $("#training").show ();}	
			getProgramitem(programType);							
		},
		error: function(xhr, status, error) {
		  var err = eval("(" + xhr.responseText + ")");
		  console.log(err.Message);
		}
	});
}			

function getProgramdesc() {  //call #2
    var str = document.getElementById("rp_id").value; 
	$.ajax({
		url: "<?php echo base_url();?>rewardprogram/programdesc/"+str, 
		success: function(result){	
			$('#description').html(result);			
		}
	});  
}
  
function getProgramitem(programType) { //call #3
    var str = document.getElementById("rp_id").value;
	$.ajax({
		url: "<?php echo base_url();?>rewardprogram/programitem/"+str, 
		success: function(result){	
			if(programType == 1)$('.qProductContainer').html(result);
			if(programType == 2)$('.qCourseContainer').html(result);			
		}
	});  
}
</script>

<!-- Supporting files for tabs -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
  $(function() {
    $('body').on('click','.completed_date', function() {
        $(this).datepicker('destroy').datepicker({showOn:'focus'}).focus();
    });
});
</script>

<!-- Supporting file dynamic elements -->
<script type="text/javascript">
$(document).ready(function () {
	var iCntc = 0;
	$('#addc').click(function() {
		var str = document.getElementById("rp_id").value;
		if (iCntc < 4) {
            iCntc = iCntc + 1;
			$.ajax({url: "<?php echo base_url();?>rewardprogram/programitem/"+str, success: function(result){$('.qCourseContainer').html(result);}});		
		} else {
		    $('#addc').attr({disabled:true,class:'rr-buttonblue-disabled'});
			$('#msglabelc').append('<label style="color:red;">&nbsp;Reached the limit.</label>'); 
		}
	});

	$('#training').on('click', 'button.removec', function() {
		if (iCntc > 1) {
			if(iCntc == 4) { 
				$('#addc').removeAttr('disabled','class');
				$('#addc').attr({class:'rr-buttonblue'});
				$('#msglabelc').html("");
			}
		iCntc = iCntc - 1;
	}});
		
	var iCntp = 0;
	$('#addp').click(function() {
		var str = document.getElementById("rp_id").value;
		if (iCntp < 4) {
            iCntp = iCntp + 1;	
			$.ajax({url: "<?php echo base_url();?>rewardprogram/programitem/"+str, success: function(result){$('.qProductContainer').html(result);}});
		} else {
		    $('#addp').attr({disabled:true,class:'rr-buttonblue-disabled'});
			$('#msglabelp').append('<label style="color:red;">&nbsp;Reached the limit.</label>'); 
		}
	});	
	$('#sale').on('click', 'button.removep', function() {
		if (iCntp > 1) {
			if(iCntp == 4) { 
				$('#addp').removeAttr('disabled','class');
				$('#addp').attr({class:'rr-buttonblue'});
				$('#msglabelp').html("");
			}
		iCntp = iCntp - 1;
	}});
});
</script>

<script>
//Ajax for item amount and total amount
	function getAmount(str, parent) {
	  if (str == "") {
		$("tr#"+parent+" td:nth-child(4)").html("");
		document.getElementById("calamount").innerHTML = "0";
		return;
	  }
	  var id = document.getElementById("rp_id").value; 
	  var element = $("tr#"+parent+" td:nth-child(3) input").val();
	  var qty = 1;
	  if (typeof(element) != 'undefined' && element != null){ 	  
		  if(parseInt(element) > 0) 
			  qty = element;
	  }

	  //call #1
	  var xhttp; 
	  xhttp = new XMLHttpRequest();		  
	  xhttp.onreadystatechange = function() {
	  if (xhttp.readyState == 4 && xhttp.status == 200) {
		$("tr#"+parent+" td:nth-child(4)").html(xhttp.responseText);
	  }
	  };
	  xhttp.open("GET", "<?php echo base_url();?>rewardprogram/programItemamount/"+id+"/"+str+"/"+qty, true);
	  xhttp.send();
		 
	  updateTotal();
	}	

	function updateTotal(){	
	  var id = document.getElementById("rp_id").value;  	
	  var itm = [];
	  var qtys = [];
	  $("table.qitems tr td:nth-child(1) select").each(function() {itm.push($(this).val());});
	  $("table.qitems tr td:nth-child(3) input").each(function() {qtys.push($(this).val());});
	  var allitms = itm.join("-");
	  var allqtys = qtys.join("-");

	  //call #2
	  var xhttp1; 
	  xhttp1 = new XMLHttpRequest();
	  xhttp1.onreadystatechange = function() { 
	  if (xhttp1.readyState == 4 && xhttp1.status == 200) {
		  document.getElementById("calamount").innerHTML = "";
		  document.getElementById("calamount").innerHTML = parseInt(xhttp1.responseText);
	  }
	  };
	  xhttp1.open("GET", "<?php echo base_url();?>rewardprogram/programTotal/"+id+"/"+allitms+"/"+allqtys, true);
	  xhttp1.send(); 
	}
</script>	

<!-- jquery form validation -->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#reward_request_create").validate({
                rules: {
                    'rp_id': "required",
					'qproduct[]': "required",
					'qpcompleted_date[]': {required:true,date:true},
					'qpquantity[]': {required:true,number:true},
					'qcourse[]': "required",
					'qccompleted_date[]': {required:true,date:true},				
                },
                messages: {
                    'rp_id': "<br>Please select a reward program.",
					'qproduct[]': "<br>Please select a product.",
					'qpcompleted_date[]': "<br>Please enter the order date.",
					'qpquantity[]': "<br>Please enter the quantity sold.",
					'qcourse[]': "<br>Please select a product.",
					'qccompleted_date[]': "<br>Please enter the order date.",				
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }

    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
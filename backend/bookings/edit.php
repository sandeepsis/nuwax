<?php
	include_once('config.php');
	include_once('../checkAdminPagePermissions.php'); 
	$dbBean	= new DatabaseBean();
	$general = new General($dbBean);
	$menu_id	= (empty($_REQUEST['menu_id'])?$_SESSION['menu_id']:$_REQUEST['menu_id']);
	$heading	= $general->getPageHeading($menu_id);
	$Booking 	= new Booking($dbBean);
	$rows 		= $Booking->getBookingById($_REQUEST['id']);
	
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<?php include('../common.php');?>
<!-- BEGIN PAGE LEVEL STYLES -->

<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_URL;?>/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_URL;?>/assets/global/css/dhtmlxcalendar.css">
<link rel="stylesheet" type="text/css" href="<?php echo ADMIN_URL;?>/assets/global/css/sandeep.css">

<!-- END PAGE LEVEL STYLES -->
<?php include('../common_second.php');?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-quick-sidebar-over-content ">
<?php include_once("../topbar.php"); ?> 
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<?php include_once("../left_menu.php"); ?>
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title"><?php echo $heading['MENU'];?> <small> <?php echo $heading['SUBMENU'];?></small></h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="<?php echo ADMIN_URL;?>/index.php">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="#"><?php echo $heading['MENU'];?></a>
					</li>
				</ul>
				
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet light bg-inverse">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-equalizer font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">Edit Details</span>
                        </div>
                    </div>
                    <div class="portlet-body form">
              			<?php 
                        	if (isset($_SESSION['msg'])) {
                        ?>
                            <div class="alert alert-<?php echo $_REQUEST['msg'];?> fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                 <?php		
                                      echo $_SESSION['msg'];
                                      unset($_SESSION['msg']);
                                ?>
                            </div>
              			<?php		
                            }
                       ?>
                        <!-- BEGIN FORM-->
                        
                        <form id="frmbooking" name="frmbooking" method="post" action="<?php echo ADMIN_URL;?>/bookings/DB.php" class="form-horizontal">
                            <div class="form-body">           
                                	<div class="form-group">
                                    <label class="control-label col-md-3">Customer<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-6">
                                         <select name="customer" id="customer" disabled class="form-control">
                                    		<option value="">Select Customer</option>
	                                    	<?php
	                                    	$results=Booking::getCustomers();
	                                    	
	                                    	if (count($results)>0) {
	                                    		for ($index = 0; $index < count($results); $index++)
	                                    		{
	                                    			$mrows = $results[$index];
	                                    			if ($mrows['id'] == $rows->customerid) {
	                                    			?>
	                                    				<option value="<?php echo $mrows['id'];?>" selected="selected"><?php echo $mrows['name'];?></option>
	                                    			<?php 
	                                    			} else {
	                                    			?>
	                                    				<option value="<?php echo $mrows['id'];?>"><?php echo $mrows['name'];?></option>
	                                    			<?php 
	                                    			}
	                                    		}
	                                    	}                                    	
	                                    	?>                                    		
	                                    </select>	                                         
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <label class="control-label col-md-3">Services<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-6" id="divadd">
                                    	<?php
		                                $serviceresult = Booking::getBookingservicesbyBookingid($_REQUEST['id']);
		                                $scount = count($serviceresult);
		                                $c = 1;
		                                if ($scount>0) {
			                                for ($t = 0; $t < $scount; $t++)
			                                {
		                                    	$m_rows = $serviceresult[$t];
		                                    	$service_id 	= $m_rows['serviceid'];	
		                                    	$actual_price	= $m_rows['actualprice'];
		                                    	$offer_price	= $m_rows['offerprice'];
		                                    	$status			= $m_rows['status'];
		                                    	$bookingserviceid	= $m_rows['id'];
		                                ?>
                                    
                                    	<div id='divrow<?php echo $c;?>' class="divpadding divmsglength">
                                    		<div class="col-md-4 nopadding">
                                    		 <input type="hidden" name="servicerowid[]" id="servicerowid<?php echo $c;?>" value="<?php echo $bookingserviceid;?>"/>
                                    		 <input type="hidden" name="serviceids[]" id="serviceids<?php echo $c;?>" value="<?php echo $service_id;?>"/>
	                                         <select name="service[]" id="service<?php echo $c;?>" class="form-control" onchange="javascript: fun_getactualprice(this.value,'<?php echo $c;?>');">
	                                    		<option value="">Select Service</option>
		                                    	<?php
		                                    	$results=Booking::getServices();
		                                    	
		                                    	if (count($results)>0) {
		                                    		for ($index = 0; $index < count($results); $index++)
		                                    		{
		                                    			$myrows = $results[$index];
		                                    			
		                                    			if ($myrows['id'] == $service_id) {
		                                    			?>
		                                    				<option value="<?php echo $myrows['id'];?>" selected="selected"><?php echo $myrows['servicename'];?></option>
		                                    			<?php 
		                                    			} else {		                                    			
		                                    			?>
		                                    				<option value="<?php echo $myrows['id'];?>"><?php echo $myrows['servicename'];?></option>
		                                    			<?php 
		                                    			}
		                                    		}
		                                    	}                                    	
		                                    	?>                                    		
		                                    </select>   
		                                    </div>
		                                    <div class="col-md-2 nopadding">
			                                    <input type="text" class="form-control" readonly placeholder="Actual Price" name="actualprice[]" id="actualprice<?php echo $c;?>" value="<?php echo $actual_price;?>" />
	                                         	<div id="divprice<?php echo $c;?>"></div>  
	                                        </div>
	                                        <div class="col-md-2 nopadding">
			                                    <input type="text" class="form-control sumofprice" placeholder="Offer Price" name="offerprice[]" id="offerprice<?php echo $c;?>" value="<?php echo $offer_price;?>" onkeyup="javascript: fun_totalprice('<?php echo $c;?>');" value="" />
	                                        </div>
	                                        <div class="col-md-3 nopadding">
			                                   <select name="bookingservicestatus[]" id="bookingservicestatus<?php echo $c;?>" onchange="javascript: fun_cancelrecord(this.value,<?php echo $c;?>);" class="form-control chkdisable">
			                                   		<option value="0" <?php if($status == 0) echo "selected='selected'"?>>Approve</option>
			                                   		<option value="1" <?php if($status == 1) echo "selected='selected'"?>>Cancel</option>
			                                   </select> 
	                                        </div>
	                                        <div class="col-md-1 a_padding"><a href="javascript:void(0);" onclick="javascript: fun_deleterow(<?php echo $c;?>,<?php echo $bookingserviceid;?>); fun_totalprice(<?php echo $c;?>);" title="Delete">Delete</a></div>	
	                                    </div>   
	                                    
	                                    <?php 
	                                    $c++;
			                                }
		                                } else {
		                                	?>
		                                	<div id='divrow1' class="divpadding divmsglength">
	                                    		<div class="col-md-4 nopadding">
	                                    		<input type="hidden" name="servicerowid[]" id="servicerowid1" value="0"/>
	                                    		<input type="hidden" name="serviceids[]" id="serviceids1"/>
		                                         <select name="service[]" id="service1" class="form-control" onchange="javascript: fun_getactualprice(this.value,'1');">
		                                    		<option value="">Select Service</option>
			                                    	<?php
			                                    	$results=Booking::getServices();
			                                    	
			                                    	if (count($results)>0) {
			                                    		for ($index = 0; $index < count($results); $index++)
			                                    		{
			                                    			$drows = $results[$index];
			                                    			?>
			                                    			<option value="<?php echo $drows['id'];?>"><?php echo $drows['servicename'];?></option>
			                                    			<?php 
			                                    		}
			                                    	}                                    	
			                                    	?>                                    		
			                                    </select>   
			                                    </div>
			                                    <div class="col-md-2 nopadding">
				                                    <input type="text" class="form-control" readonly placeholder="Actual Price" name="actualprice[]" id="actualprice1"/>
		                                         	<div id="divprice1"></div>  
		                                        </div>
		                                        <div class="col-md-2 nopadding">
				                                    <input type="text" class="form-control sumofprice" placeholder="Offer Price" name="offerprice[]" id="offerprice1" onkeyup="javascript: fun_totalprice('1');" value="" />
		                                        </div>
		                                        <div class="col-md-3 nopadding">
				                                   <select name="bookingservicestatus[]" id="bookingservicestatus1" onchange="javascript: fun_cancelrecord(this.value,'1');" class="form-control">
				                                   		<option value="0">Approve</option>
				                                   		<option value="1">Cancel</option>
				                                   </select> 
		                                        </div>
		                                        <div class="col-md-1 a_padding"></div>	
		                                    </div>   
		                                	<?php 
		                                }
	                                    ?>
	                                    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-1">
                                         <a href="javascript:void(0);" onClick="javascript:fun_add();" title="Add">+ Add</a>  
                                    </div>
                                    <div class="col-md-3"><span class="diverror"  id="divmsg"></span></div>
                                </div>
                                                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Service Date<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-6">
                                         <input type="text" class="form-control" placeholder="Service Date" name="servicedate" id="servicedate" value="<?php echo stripslashes($rows->servicedate); ?>" />    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Service Time<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-6">
                                         <input type="text" class="form-control" placeholder="Service Time" name="servicetime" id="servicetime" value="<?php echo stripslashes($rows->servicetime); ?>"/>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Total Price<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-6">
                                         <input type="text" class="form-control" readonly placeholder="Total Price" name="totalprice" id="totalprice" value="<?php echo stripslashes($rows->totalprice); ?>" />    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Status<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-6">
                                         <select name="status" id="status" class="form-control" onchange="javascript: fun_showtherapist(this.value);">
                                         	<option value="1" <?php if($rows->status == 1) echo "selected='selected'"?>>New</option>
                                         	<option value="2" <?php if($rows->status == 2) echo "selected='selected'"?>>Confirmed</option>
                                         	<option value="3" <?php if($rows->status == 3) echo "selected='selected'"?>>Cancelled</option>
                                         	<option value="4" <?php if($rows->status == 4) echo "selected='selected'"?>>Absent</option>
                                         	<option value="5" <?php if($rows->status == 5) echo "selected='selected'"?>>Complete</option>
                                         </select>    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divtherapist">
                                    <label class="control-label col-md-3">Therapist<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-6">
                                         <select name="therapist" id="therapist" class="form-control">
                                    		<option value="">Select Therapist</option>
	                                    	<?php
	                                    	$results=Booking::getStaffs();
	                                    	
	                                    	if (count($results)>0) {
	                                    		for ($index = 0; $index < count($results); $index++)
	                                    		{
	                                    			$mrows = $results[$index];
	                                    			if ($mrows['id'] == $rows->staffid) {
	                                    			?>
	                                    				<option value="<?php echo $mrows['id'];?>" selected="selected"><?php echo $mrows['name'];?></option>
	                                    			<?php
	                                    			} else {
	                                    			?>
	                                    				<option value="<?php echo $mrows['id'];?>"><?php echo $mrows['name'];?></option>
	                                    			<?php 
	                                    			}
	                                    		}
	                                    	}                                    	
	                                    	?>                                    		
	                                    </select>    
                                    </div>
                                </div>                   
                                
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-4">
                                    	<input type="hidden" name="FLAG" value="EDIT_BOOKING" />
                                    	<input type="hidden" name="hdnlaststatus" id="hdnlaststatus" value="<?php echo $rows->status;?>" />
                                    	<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $rows->customerid;?>"/> 
	                                    <input name="id" type="hidden" value="<?php echo $_REQUEST['id'];?>" />                                        
                                        
                                        <?php 
                                        if ($rows->status != '4' && $rows->status != '5') {
                                        ?>
                                        	<button type="submit" class="btn green">Submit</button>
                                        <?php 
                                        }?>
                                        <button type="button" class="btn default" name="cancel" onClick="javascript: window.location.href='<?php echo ADMIN_URL;?>/bookings/index.php'">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php include_once("../scripts.php"); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo ADMIN_URL;?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo  ADMIN_URL;?>/assets/global/scripts/dhtmlxcalendar.js"></script>

<!-- END PAGE LEVEL PLUGINS -->
<script>
var myCalendar;
function doOnLoad() {
	myCalendar = new dhtmlXCalendarObject(["servicedate"]);
	myCalendar.hideTime();
	myCalendar.setDateFormat("%Y-%m-%d");	
}

jQuery(document).ready(function() {
	doOnLoad();
	if ($("#status").val() == '5') {
		$("#divtherapist").show();	
	} else {
		$("#divtherapist").hide();
	}

	
    var w = 1;
	$(".chkdisable").each(function(){			
		t = $(this).val();		
		if (t == 1) {
			$("#offerprice"+w).removeClass('sumofprice');	
			fun_totalprice();
			$("#service"+w).attr('disabled','disabled');
			$("#offerprice"+w).attr('readonly','readonly');
		}

		w++;
    });	
		
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   FormValidation.init();

});

function fun_totalprice(a)
{	
	var sum = 0;
	$(".sumofprice").each(function(){		
		sum += Number($(this).val());		
		$("#totalprice").val(sum);
    });	
}

function fun_cancelrecord(s,a)
{
	if (s == 0) {
		$("#offerprice"+a).addClass('sumofprice');	
		fun_totalprice();
		$("#service"+a).removeAttr('disabled','disabled');
		$("#offerprice"+a).removeAttr('readonly','readonly');
	} else {
		$("#offerprice"+a).removeClass('sumofprice');	
		fun_totalprice();
		$("#service"+a).attr('disabled','disabled');
		$("#offerprice"+a).attr('readonly','readonly');
	}
}

var cnt = <?php echo $scount+1;?>;
function fun_add()
{
	var service		= "service"+cnt;
	var actualprice = "actualprice"+cnt;
	var offerprice 	= "offerprice"+cnt;
	var dprice 		= "divprice"+cnt;
	var x 			= "divrow"+cnt;
	var bookingstatus = "bookingservicestatus"+cnt;		
	var field = '<div id='+x+' class="divpadding divmsglength"><div class="col-md-4 nopadding"><input type="hidden" name="servicerowid[]" id="servicerowid'+cnt+'" value="0"/><input type="hidden" name="serviceids[]" id="serviceids'+cnt+'" /><select name="service[]" id='+service+' class="form-control" onchange="javascript: fun_getactualprice(this.value,'+cnt+');"> <option value="">Select Service</option><?php $results=Booking::getServices(); if (count($results)>0) {	for ($index = 0; $index < count($results); $index++){ $rows = $results[$index];?><option value="<?php echo $rows['id'];?>"><?php echo $rows['servicename'];?></option><?php } } ?> </select></div><div class="col-md-2 nopadding"> <input type="text" class="form-control" readonly placeholder="Actual Price" name="actualprice[]" id='+actualprice+' /><div id='+dprice+'></div></div><div class="col-md-2 nopadding"><input type="text" class="form-control sumofprice" placeholder="Offer Price" name="offerprice[]" id='+offerprice+' onkeyup="javascript: fun_totalprice('+cnt+');" value="" /></div><div class="col-md-3 nopadding"><select name="bookingservicestatus[]" id='+bookingstatus+' onchange="javascript: fun_cancelrecord(this.value,'+cnt+');" class="form-control chkdisable"><option value="0">Approve</option><option value="1">Cancel</option></select></div><div class="col-md-1 a_padding"><a href="javascript:void(0);" onclick="javascript: fun_deleterow('+cnt+'); fun_totalprice('+cnt+');" title="Delete">Delete</a></div></div>';

	$('#divadd').append(field);

	if ($(".divmsglength").length > '0') {
    	$("#divmsg").html("");
	}
	
	cnt++;
}

function fun_deleterow(a)
{
	$('#divrow'+a).remove();
}

function fun_showtherapist(a)
{
	if (a == 5) {
		$("#divtherapist").show();
	} else {
		$("#divtherapist").hide();
	}
}

function fun_getactualprice(a,b)
{	
	$("#serviceids"+b).val(a);
	if (a != "") {		
		$("#divprice"+b).load("<?php echo ADMIN_URL;?>/bookings/DB.php?FLAG=GET_PRICE&id="+a,function(data){
			
			if (data != 'error') {

				//alert(data);
				
				$("#actualprice"+b).val(data);
				$("#offerprice"+b).val(data);

				fun_totalprice();
				$("#divprice"+b).hide();
			}	
			else {
				alert("test");
			}	
		});
	} else {
		$("#actualprice"+b).val('');
		$("#offerprice"+b).val('');
	}		
}

var FormValidation = function () {

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#frmbooking');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);

            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: { 
                	"service[]": {
                        required: true
                    }, 
                    "offerprice[]": {    
                    	required: true,  
                        number:true
                    }, 
                    servicedate: {
                        required: true
                    },     
    		        servicetime: {                        
                        required: true,
                        number:true
                    },
                    therapist: {                        
                    	required: function(element) {
                            if ($('#status').val() != 5) {
                                return false;
                            } else {
                                return true;
                            }
                        },
                    }
                },

                messages: { // custom messages for radio buttons and checkboxes
                    
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) { 
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parents('.radio-list').size() > 0) { 
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').size() > 0) { 
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').size() > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').size() > 0) { 
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success3.hide();
                    error3.show();
                    Metronic.scrollTo(error3, -200);
                },

                highlight: function (element) { // hightlight error inputs
                   $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {

                	if ($(".divmsglength").length == '0') {
                		$("#totalprice").val('');
                    	$("#divmsg").html("Please select atleast one service");
                    	 return false;
                	}
                	else
                	{
                		$("#divmsg").html("");
                	}
                    
                    success3.show();
                    error3.hide();
                    form.submit(); // submit the form
                }

            });

            $('.date-picker .form-control').change(function() {
                form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input 
            })
    }


    return {
        //main function to initiate the module
        init: function () {
		 handleValidation3();

        }

    };

}();	
		
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

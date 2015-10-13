<?php
	include_once('config.php');
	include_once('../checkAdminPagePermissions.php'); 
	$dbBean	= new DatabaseBean();
	$general= new General($dbBean);
	$menu_id	= (empty($_REQUEST['menu_id'])?$_SESSION['menu_id']:$_REQUEST['menu_id']);
	$heading	= $general->getPageHeading($menu_id);
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
                            <span class="caption-subject font-red-sunglo bold uppercase">Add Details</span>
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
                                    <div class="col-md-5">
                                         <select name="customer" id="customer" class="form-control">
                                    		<option value="">Select Customer</option>
	                                    	<?php
	                                    	$results=Booking::getCustomers();
	                                    	
	                                    	if (count($results)>0) {
	                                    		for ($index = 0; $index < count($results); $index++)
	                                    		{
	                                    			$rows = $results[$index];
	                                    			?>
	                                    			<option value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
	                                    			<?php 
	                                    		}
	                                    	}                                    	
	                                    	?>                                    		
	                                    </select>      
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Services<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-5" id="divadd">
                                    	<div id='divrow1' class="divpadding">
                                    		<div class="col-md-4 nopadding">
	                                         <select name="service[]" id="service1" class="form-control" onchange="javascript: fun_getactualprice(this.value,'1');">
	                                    		<option value="">Select Service</option>
		                                    	<?php
		                                    	$results=Booking::getServices();
		                                    	
		                                    	if (count($results)>0) {
		                                    		for ($index = 0; $index < count($results); $index++)
		                                    		{
		                                    			$rows = $results[$index];
		                                    			?>
		                                    			<option value="<?php echo $rows['id'];?>"><?php echo $rows['servicename'];?></option>
		                                    			<?php 
		                                    		}
		                                    	}                                    	
		                                    	?>                                    		
		                                    </select>   
		                                    </div>
		                                    <div class="col-md-3 nopadding">
			                                    <input type="text" class="form-control" readonly placeholder="Actual Price" name="actualprice[]" id="actualprice1"/>
	                                         	<div id="divprice1"></div>  
	                                        </div>
	                                        <div class="col-md-3 nopadding">
			                                    <input type="text" class="form-control sumofprice" placeholder="Offer Price" name="offerprice[]" id="offerprice1" onkeyup="javascript: fun_totalprice('1');" value="" />
	                                        </div>
	                                        <div class="col-md-1 a_padding"></div>	
	                                    </div>   
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-5">
                                         <a href="javascript:void(0);" onClick="javascript:fun_add();" title="Add">+ Add</a>  
                                    </div>
                                </div>
                                                                                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Service Date<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-5">
                                         <input type="text" class="form-control" placeholder="Service Date" name="servicedate" id="servicedate" value="" />    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Service Time<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-5">
                                         <input type="text" class="form-control" placeholder="Service Time" name="servicetime" id="servicetime"/>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Total Price<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-5">
                                         <input type="text" class="form-control" placeholder="Total Price" readonly name="totalprice" id="totalprice" value="" />    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Status<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-5">
                                         <select name="status" id="status" class="form-control" onchange="javascript: fun_showtherapist(this.value);">
                                         	<option value="1">New</option>
                                         	<option value="2">Confirmed</option>
                                         	<option value="3">Cancelled</option>
                                         	<option value="4">Absent</option>
                                         	<option value="5">Complete</option>
                                         </select>    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divtherapist">
                                    <label class="control-label col-md-3">Therapist<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-5">
                                         <select name="therapist" id="therapist" class="form-control">
                                    		<option value="">Select Therapist</option>
	                                    	<?php
	                                    	$results=Booking::getStaffs();
	                                    	
	                                    	if (count($results)>0) {
	                                    		for ($index = 0; $index < count($results); $index++)
	                                    		{
	                                    			$rows = $results[$index];
	                                    			?>
	                                    			<option value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
	                                    			<?php 
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
                                    	<input type="hidden" name="FLAG" value="ADD_BOOKING" />
                                        <button type="submit" class="btn green">Submit</button>
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
	$("#divtherapist").hide();
	
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

var cnt = 2;
function fun_add()
{
	var service		= "service"+cnt;
	var actualprice = "actualprice"+cnt;
	var offerprice 	= "offerprice"+cnt;
	var dprice 		= "divprice"+cnt;
	var x 			= "divrow"+cnt;
			
	var field = '<div id='+x+' class="divpadding"><div class="col-md-4 nopadding"><select name="service[]" id='+service+' class="form-control" onchange="javascript: fun_getactualprice(this.value,'+cnt+');"> <option value="">Select Service</option><?php $results=Booking::getServices(); if (count($results)>0) {	for ($index = 0; $index < count($results); $index++){ $rows = $results[$index];?><option value="<?php echo $rows['id'];?>"><?php echo $rows['servicename'];?></option><?php } } ?> </select></div><div class="col-md-3 nopadding"> <input type="text" class="form-control" readonly placeholder="Actual Price" name="actualprice[]" id='+actualprice+' /><div id='+dprice+'></div></div><div class="col-md-3 nopadding"><input type="text" class="form-control sumofprice" placeholder="Offer Price" name="offerprice[]" id='+offerprice+' onkeyup="javascript: fun_totalprice('+cnt+');" value="" /></div><div class="col-md-1 a_padding"><a href="javascript:void(0);" onclick="javascript: fun_deleterow('+cnt+'); fun_totalprice('+cnt+');" title="Delete">Delete</a></div></div>';

	$('#divadd').append(field);
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
	//var t='';		
	if (a != "") {
		$("#divprice"+b).load("<?php echo ADMIN_URL;?>/bookings/DB.php?FLAG=GET_PRICE&id="+a,function(data){
			
			if (data != '') {
				$("#actualprice"+b).val(data);
				$("#offerprice"+b).val(data);

				fun_totalprice();
				$("#divprice"+b).hide();
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
			var user_type = $("#usertype").val();
			
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {                	
                	customer: {
                        required: true
                    }, 
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

                messages: { 
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
                    success3.show();
                    error3.hide();
                    form.submit(); // submit the form
                }

            });

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

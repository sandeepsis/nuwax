<?php
	include_once('config.php');
	include_once('../checkAdminPagePermissions.php'); 
	$dbBean	= new DatabaseBean();
	$general= new General($dbBean);
	$menu_id	= (empty($_REQUEST['menu_id'])?$_SESSION['menu_id']:$_REQUEST['menu_id']);
	$heading	= $general->getPageHeading($menu_id);
	$Package 	= new Package($dbBean);
	$myrows 	= $Package->getPackageById($_REQUEST['id']);
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
                        <form id="frmpackageallocate" name="frmpackageallocate" method="post" action="<?php echo ADMIN_URL;?>/packages/DB.php" class="form-horizontal">
                            <div class="form-body">   
                            	<div class="form-group">
                                    <label class="control-label col-md-3">Package</label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Package" readonly name="package" id="package" value="<?php echo $myrows->name;?>"/>    
                                    </div>
                                </div>                         	 
                                <div class="form-group">
                                    <label class="control-label col-md-3">Customer<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                    	<select id="customer" name="customer" class="form-control">
                                    		<option value="">Select Customer</option>
                                    		<?php
	                                    	$results=Package::getCustomers();
	                                    	
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
                                    <label class="control-label col-md-3">Payment Type<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                    	<select id="paymenttype" name="paymenttype" onchange="javascript: fun_paymenttype(this.value);" class="form-control">
                                    		<option value="0">Cash</option>
                                    		<option value="1">Cheque</option>
                                    		<option value="2">Other</option>	                                    	        
										</select>                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Amount<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Amount" readonly name="amount" id="amount" value="<?php echo $myrows->cost;?>"/>    
                                    </div>
                                </div>
                                <div class="form-group" id="divbank">
                                    <label class="control-label col-md-3">Bank Name<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Bank Name" name="bank" id="bank" value="" />    
                                    </div>
                                </div>                                
                                <div class="form-group" id="divinsname">
                                    <label class="control-label col-md-3">Instrument Name<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Instrument Name" name="instrumentname" id="instrumentname" value="" />    
                                    </div>
                                </div>
                                <div class="form-group" id="divinsno">
                                    <label class="control-label col-md-3">Instrument No<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Instrument No" name="instrumentno" id="instrumentno" value="" />    
                                    </div>
                                </div>
                                <div class="form-group" id="divcheque">
                                    <label class="control-label col-md-3">Cheque Amount<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Cheque Amount" name="chequeamount" id="chequeamount" value="" />    
                                    </div>
                                </div>
                                <div class="form-group" id="divcheqdate">
                                    <label class="control-label col-md-3">Cheque Date<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Cheque Date" name="chequedate" id="chequedate" value="" />    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Allocation Date<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Allocation Date" name="allocationdate" id="allocationdate" value="" />    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Remark</label>
                                    <div class="col-md-4">
                                         <textarea class="form-control" placeholder="Remark" name="remark" id="remark"></textarea>    
                                    </div>
                                </div>                                
                                	
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-4">
                                    	<input type="hidden" name="FLAG" value="ALLOCATE_PACKAGE" />
                                    	<input name="id" type="hidden" value="<?php echo $_REQUEST['id'];?>" />
                                    	<input type="hidden" name="creditprovided" id="creditprovided" value="<?php echo $myrows->creditprovided;?>" />
                                        <button type="submit" class="btn green">Submit</button>
                                        <button type="button" class="btn default" name="cancel" onClick="javascript: window.location.href='<?php echo ADMIN_URL;?>/packages/index.php'">Cancel</button>
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

<script type="text/javascript" src="<?php echo ADMIN_URL;?>/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo  ADMIN_URL;?>/assets/global/scripts/dhtmlxcalendar.js"></script>

<script>
var myCalendar;
function doOnLoad() {
	myCalendar = new dhtmlXCalendarObject(["allocationdate"]);
	myCalendar.hideTime();
	myCalendar.setDateFormat("%Y-%m-%d %H:%i:%s");
	

	myCalendar1 = new dhtmlXCalendarObject(["chequedate"]);
	myCalendar1.hideTime();
	myCalendar1.setDateFormat("%Y-%m-%d");
}

jQuery(document).ready(function() {    
	doOnLoad();
	
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   FormValidation.init();

   var paytype = $("#paymenttype").val();
   fun_paymenttype(paytype);
});

function fun_paymenttype(paytype)
{
	  if(paytype == 0)
	  {
		  $("#divbank").hide();
		  $("#divinsname").hide();
		  $("#divinsno").hide();
		  $("#divcheque").hide();
		  $("#divcheqdate").hide();
	  }
	  else
	  {
		  $("#divbank").show();
		  $("#divinsname").show();
		  $("#divinsno").show();
		  $("#divcheque").show();
		  $("#divcheqdate").show();
	  }
}

var FormValidation = function () {

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#frmpackageallocate');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);
			
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {                	
                	customer: {
                        required: true
                    },
        		    bank: {
        		    	required: function(element) {
                            if ($('#paymenttype').val() == 0) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    }, 
                    instrumentname: {
                    	required: function(element) {
                            if ($('#paymenttype').val() == 0) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },
                    instrumentno: {                        
                    	required: function(element) {
                            if ($('#paymenttype').val() == 0) {
                                return false;
                            } else {
                                return true;
                            }
                        },
                        number: true
                    },
                    chequeamount: {                        
                    	required: function(element) {
                            if ($('#paymenttype').val() == 0) {
                                return false;
                            } else {
                                return true;
                            }
                        },
                        number: true
                    },
                    chequedate: {
                    	required: function(element) {
                            if ($('#paymenttype').val() == 0) {
                                return false;
                            } else {
                                return true;
                            }
                        }
                    },     
                    allocationdate: {                        
                        required: true
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

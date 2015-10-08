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
                        <form id="frmcustomer" name="frmcustomer" method="post" action="<?php echo ADMIN_URL;?>/customers/DB.php" class="form-horizontal">
                            <div class="form-body">                                                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Name" name="name" id="name" value=""/>    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email ID<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Email ID" name="emailid" id="emailid" value="" />    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divrname">
                                    <label class="control-label col-md-3">Contact Number<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Contact Number" name="contactno" id="contactno" value="" />    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divremail">
                                    <label class="control-label col-md-3">Address<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <textarea class="form-control" placeholder="Address" name="address" id="address"></textarea>    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divcpmy">
                                    <label class="control-label col-md-3">Student Card No</label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Student Card No" name="studentcardno" id="studentcardno" value="" />    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divcpmy">
                                    <label class="control-label col-md-3">Student Card Validity</label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Student Card Validity" name="studentcardvalidity" id="studentcardvalidity" value="" />    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divremail">
                                    <label class="control-label col-md-3">Credit</label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Credit" name="credit" id="credit" value="" />    
                                    </div>
                                </div>
                                
                                <div class="form-group" id="divcpmy">
                                    <label class="control-label col-md-3">Remark</label>
                                    <div class="col-md-4">
                                         <textarea class="form-control" placeholder="Remark" name="remark" id="remark"></textarea>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                    	<select name="status" id="status" class="form-control form-filter input-sm">
                                         	<option value="0">Active</option>
                                         	<option value="1">Inactive</option>
                                         </select>
                                    </div>
                                </div>   
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-4">
                                    	<input type="hidden" name="FLAG" value="ADD_CUSTOMER" />
                                        <button type="submit" class="btn green">Submit</button>
                                        <button type="button" class="btn default" name="cancel" onClick="javascript: window.location.href='<?php echo ADMIN_URL;?>/customers/index.php'">Cancel</button>
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
	myCalendar = new dhtmlXCalendarObject(["studentcardvalidity"]);
	myCalendar.hideTime();
	myCalendar.setDateFormat("%Y-%m-%d");
}

jQuery(document).ready(function() {
	doOnLoad();
	
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   FormValidation.init();
});

var FormValidation = function () {

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#frmcustomer');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);
			var user_type = $("#usertype").val();
			
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {                	
                	name: {
                        required: true
                    },                    
                    emailid: {
                        required: true,
                        email: true
                    },
    		        contactno: {                        
                        required: true,
                        number: true
                    },
    		        address: {
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

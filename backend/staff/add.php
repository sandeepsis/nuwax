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

<style>
.nopadding{ padding-left:0px;} 
.divpadding{padding-bottom:40px;} 
.a_padding{padding:5px;}
</style>

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
                        	if(isset($_SESSION['msg']))
                            {
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
                        <form id="frmstaff" name="frmstaff" method="post" action="<?php echo ADMIN_URL;?>/staff/DB.php" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-body">                                                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Name<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Name" name="name" id="name" value=""/>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Image<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="file" name="staffimg" id="staffimg" />     
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Contact No<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Contact No" name="contactno" id="contactno" value=""/>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Email Address<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Email Address" name="emailaddress" id="emailaddress" value=""/>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Address<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <textarea class="form-control" placeholder="Address" name="address" id="address"></textarea>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Service<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                    	<select name="service" id="service" class="form-control">
                                    		<option value="">Select Service</option>
	                                    	<?php
	                                    	$results=Staff::getServices();
	                                    	
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
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Assign Services<span class="required" aria-required="true">*</span></label>                                    
	                                    <div class="col-md-4" id="divadd">
	                                    	<div id='divrow1' class="divpadding">
		                                    	<div class="col-md-5 nopadding">
			                                    	<select name="assignservice[]" id="assignservice1" class="form-control">
			                                    		<option value="">Select Service</option>
				                                    	<?php
				                                    	$results=Staff::getServices();
				                                    	
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
			                                   <div class="col-md-6 nopadding">
				                                    <select name="stafflevel[]" id="stafflevel1" class="form-control">
			                                    		<option value="">Select Staff Level</option>
				                                    	<?php
				                                    	$staffresults=Staff::getStafflevel();
				                                    	
				                                    	if (count($staffresults)>0) {
				                                    		for ($index = 0; $index < count($staffresults); $index++)
				                                    		{
				                                    			$rows = $staffresults[$index];
				                                    			?>
				                                    			<option value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option>
				                                    			<?php 
				                                    		}
				                                    	}                                    	
				                                    	?>                                    		
				                                    </select>    
			                                    </div>
			                                    <div class="col-md-1 a_padding"></div>	
			                                 </div>	                                     
	                                    </div>  
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-4">
                                         <a href="#" onClick="javascript:fun_add();" title="Add">+ Add</a>  
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-4">
                                    	<input type="hidden" name="FLAG" value="ADD_STAFF" />
                                    	<input type="hidden" name="assignservicecnt" id="assignservicecnt" />
                                        <button type="submit" class="btn green">Submit</button>
                                        <button type="button" class="btn default" name="cancel" onClick="javascript: window.location.href='<?php echo ADMIN_URL;?>/staff/index.php'">Cancel</button>
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

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->


<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core components
   Layout.init(); // init current layout
   FormValidation.init();
});

var cnt = 2;
function fun_add()
{
	var service = "assignservice"+cnt;
	var staff = "stafflevel"+cnt;
	var x = "divrow"+cnt;
	$("#assignservicecnt").val(cnt);

	//var d = "<?php //echo count($results);?>";
	
	var field = '<div id='+x+' class="divpadding"><div class="col-md-5 nopadding"><select name="assignservice[]" id='+service+' class="form-control"><option value="">Select Service</option> <?php $results=Staff::getServices(); if (count($results)>0) {	for ($index = 0; $index < count($results); $index++){ $rows = $results[$index]; ?> <option value="<?php echo $rows['id'];?>"><?php echo $rows['servicename'];?></option><?php }	} ?> </select></div><div class="col-md-6 nopadding"><select name="stafflevel[]" id='+staff+' class="form-control">	<option value="">Select Staff Level</option><?php $results=Staff::getStafflevel(); if (count($results)>0) { for ($index = 0; $index < count($results); $index++) { $rows = $results[$index];?><option value="<?php echo $rows['id'];?>"><?php echo $rows['name'];?></option><?php } } ?> </select></div><div class="col-md-1 a_padding"><a href="#" onclick="javascript: fun_deleterow('+cnt+');" title="Delete">Delete</a></div><div>';

	$('#divadd').append(field);
	cnt++;
}

function fun_deleterow(a)
{
	$('#divrow'+a).remove();
}

var FormValidation = function () {

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#frmstaff');
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
    		        staffimg: {                        
                        required: true,
                    },
                    contactno: {
                        required: true,
                        number:true
                    },
    		        emailaddress: {                        
                        required: true,
                        email:true
                    },
                    address:{
                        required:true
                    },
                    service:{
                        required:true
                    },
                    service1:{
                        required:true
                    },
                    stafflevel1:{
                        required:true
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

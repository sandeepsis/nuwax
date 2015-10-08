<?php
	include_once('config.php');
	include_once('../checkAdminPagePermissions.php'); 
	$dbBean	= new DatabaseBean();
	$general = new General($dbBean);
	$menu_id	= (empty($_REQUEST['menu_id'])?$_SESSION['menu_id']:$_REQUEST['menu_id']);
	$heading	= $general->getPageHeading($menu_id);
	$Package = new Package($dbBean);
	$rows = $Package->getPackageById($_REQUEST['id']);
	
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
                        
                        <form id="frmservice" name="frmservice" method="post" action="<?php echo ADMIN_URL;?>/packages/DB.php" class="form-horizontal">
                            <div class="form-body">           
                                	<div class="form-group">
                                    <label class="control-label col-md-3">Package Name<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Package Name" name="packagename" id="packagename" value="<?php echo stripslashes($rows->name); ?>"/>    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Cost<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Cost" name="cost" id="cost" value="<?php echo stripslashes($rows->cost); ?>" />    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Credit Provided<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Credit Provided" name="creditprovided" id="creditprovided" value="<?php echo stripslashes($rows->creditprovided); ?>" />    
                                    </div>
                                </div>
                                <?php $ids = explode(',',$rows->serviceapplicable);?>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Service Applicable<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                    	<select id="serviceapplicable" name="serviceapplicable[]" multiple="multiple" class="form-control">
                                    		<?php                                    		                                   		
	                                    	$results=Package::getServices();
	                                    	
	                                    	if (count($results)>0) {
	                                    		for ($index = 0; $index < count($results); $index++)
	                                    		{
	                                    			$mrows = $results[$index];
	                                    			
	                                    			if ($mrows['id'] == $ids[$index]) {
	                                    			?>
	                                    			<option value="<?php echo $mrows['id'];?>" selected="selected"><?php echo $mrows['servicename'];?></option>
	                                    			<?php 
	                                    			} else {
	                                    			?>
	                                    				<option value="<?php echo $mrows['id'];?>"><?php echo $mrows['servicename'];?></option>
	                                    			<?php 
	                                    			}
	                                    		}
	                                    	}                                    	
	                                    	?>        
										</select>
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Service Discount (%)</label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Service Discount (%)" name="servicediscount" id="servicediscount" value="<?php echo stripslashes($rows->servicediscount); ?>" />    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Product Discount (%)</label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Product Discount (%)" name="productdiscount" id="productdiscount" value="<?php echo stripslashes($rows->productdiscount); ?>"/>    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Tax Name<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Tax Name" name="taxname" id="taxname" value="<?php echo stripslashes($rows->taxname); ?>" />    
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-md-3">Tax (%)<span class="required" aria-required="true">*</span></label>
                                    <div class="col-md-4">
                                         <input type="text" class="form-control" placeholder="Tax (%)" name="taxper" id="taxper" value="<?php echo stripslashes($rows->taxpercent); ?>" />    
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-4">
                                    	<input type="hidden" name="FLAG" value="EDIT_PACKAGE" />
                                        <input name="id" type="hidden" value="<?php echo $_REQUEST['id'];?>" />                                        
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

var FormValidation = function () {

    // advance validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation

            var form3 = $('#frmservice');
            var error3 = $('.alert-danger', form3);
            var success3 = $('.alert-success', form3);

            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                	packagename: {
                        required: true
                    },     
    		        cost: {                        
                        required: true,
                        number: true
                    },
    		        creditprovided: {
        		        required: true,
						number:true        		        
        		    },
        		    serviceapplicable: {
                        required: true,
                        needsSelection: true
                    },                    
                    taxname: {
                        required: true
                    },     
    		        taxper: {                        
                        required: true,
                        number: true
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

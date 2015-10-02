<?php
$dbBean	= new DatabaseBean();
$sqlmgrp="SELECT * FROM  menu WHERE is_menu_group = 1 AND is_hidden = 0 and is_dashboard_icon=1 ORDER BY order_index, name ASC";
$menurowArray=$dbBean->QueryArray($sqlmgrp);
if (! $menurowArray) $dbBean->Kill();
?>
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<li <?php echo (basename($_SERVER['PHP_SELF'])=="index.php" && basename(dirname($_SERVER['PHP_SELF']),"/")=="backend" ) ? "class='start active open'":'';?>>
					<a href="<?php echo ADMIN_URL;?>/index.php">
					<i class="icon-home"></i>
					<span class="title"><?php echo ADMIN_TITLE; ?></span>
					<span class="selected"></span>
					<span class="arrow open"></span>
					</a>
					
				</li>
				<?php 
                    
                    for ($index = 0; $index < count($menurowArray); $index++) 
                    {
                         $menurow = $menurowArray[$index];
                    
                        
                        $accessRoles=explode(",",$menurow['access_roles']);
                        if(in_array($_SESSION['adm_status'],$accessRoles)) 
                        {
                ?>	    
                
                
				<li <?php echo isset($heading['MENU']) && $heading['MENU']==$menurow['name'] ? "class='active open'":'';?>>
					<a href="javascript:;">
					<i class="fa <?php echo $menurow['icon'] != '' ? $menurow['icon'] : 'fa-shopping-cart'; ?>"></i>
					<span class="title"><?php echo $menurow['name'];?></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu <?php echo isset($heading['MENU']) && $heading['MENU']==$menurow['name'] ? "":"closed";?>">
                 <?php
					$sqlsubgrp="SELECT * FROM menu WHERE is_menu_group = 0 AND is_hidden = 0 AND parent_id = ".intval($menurow['id'])." ORDER BY order_index ASC";
					$submenurowArray=$dbBean->QueryArray($sqlsubgrp);
					for ($ind = 0; $ind < count($submenurowArray); $ind++) 
					{
   					 	$submenurow = $submenurowArray[$ind];
						$subaccessRoles=explode(",",$submenurow['access_roles']);
						if(in_array($_SESSION['adm_status'],$subaccessRoles)) 
						{
				  ?>
						<li <?php echo isset($menu_id) && $menu_id==$submenurow['id'] ? "class='active'":'';?>>
							<a href="<?php echo ADMIN_URL.'/'.$submenurow['page_name'];?>?menu_id=<?php echo $submenurow['id'];?>">
							<i class="fa <?php echo $submenurow['icon'] ? $submenurow['icon'] : 'fa-home'; ?>"></i>
							<?php echo $submenurow['name'];?></a>
						</li>
                    <?php
						}
					}
					 ?>
					</ul>
				</li>
             <?php 
			 		}
				} 
			?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
<?php
    if(!(isset($_SESSION['adm_logged']) && ($_SESSION['adm_logged'] == true)))
	{
        header("Location:".ADMIN_URL."/login.php");
        exit;		              
    }   
?>
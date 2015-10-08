<?php
if ($_REQUEST['msg'] == 'success') {
	echo "Password successfully changed";
} else if ($_REQUEST['msg'] == 'error') {
	echo "Error changing password";
}
?>
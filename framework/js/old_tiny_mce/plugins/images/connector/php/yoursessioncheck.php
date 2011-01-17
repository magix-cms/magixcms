<?php

/**
 * User session check, for registered users
 * 
 * If you don't care about access,
 * please remove or comment following code
 * 
 */
print $_SESSION['useradmin'];
if(!isset( $_SESSION['useradmin'] )) {
	echo 'Access denied, check file '.basename(__FILE__);
	exit();
}
/*if(!isset( $_SESSION['user'] )) {
	echo 'Access denied, check file '.basename(__FILE__);
	exit();
}*/

?>
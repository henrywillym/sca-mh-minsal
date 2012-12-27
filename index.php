<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	
	//header('Location: '.$uri.'/sca-mh-minsal/web/app_dev.php/SidPla');
	exit;
?>
Something is wrong with the XAMPP installation :-(

<?php
	header("Content-type: text/html; charset=utf-8");
	require_once('config.php');
	require_once('xsdhyphp/xsdhy.php');
	define('APP_PATH','admin/');
	define('CACHEZT',0);
	XSDHY::run($config);
?>
<?php
	//error_reporting(0);
	header("Content-type: text/html; charset=utf-8");
	require_once('config.php');
	require_once('xsdhyphp/xsdhy.php');
	define('APP_PATH','home/');
	define('APP_ROOT',dirname(__FILE__));
	define('CACHEZT',0);
	XSDHY::run($config);
?>
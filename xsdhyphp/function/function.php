<?php
	function C($name, $method){
		require_once('libs/'.APP_PATH.'controller/'.$name.'Controller.class.php');
		eval('$obj = new '.$name.'Controller();$obj->'.$method.'();');
	}
	function M($name){
		require_once('libs/'.APP_PATH.'Model/'.$name.'Model.class.php');
		//$testModel = new testModel();
		eval('$obj = new '.$name.'Model();');
		return $obj;
	}
	function V($name){
		require_once('libs/'.APP_PATH.'View/'.$name.'View.class.php');
		//$testView = new testView();
		eval('$obj = new '.$name.'View();');
		return $obj;
	}
	function ORG($name, $params=array()){// 
		require_once('suseframe/org/'.$name.'/'.$name.'.class.php');
		$obj = new $name();
		if(!empty($params)){
		foreach($params as $key=>$value){
				$obj->$key = $value;
			}
		}
		return $obj;
	}
	function daddslashes($str){
		return (!get_magic_quotes_gpc())?addslashes($str):$str;
	}
	function showmessage($info, $url=''){
		echo "<script>alert('$info');window.location.href='$url'</script>";
	}
	function encrypt($nencrypted) {
    $salt="SUSEmaASHdDSJAsdksSADIN";  
    $encrypted=$nencrypted.$salt;
    $encrypted=md5($encrypted);
    return $encrypted;
	}
	function setconf($oneset){
		$file = fopen("set.conf","r");
		//$date=array();//如需获取所有值，设置这个
		while(!feof($file)) {
			$str=fgets($file);
			$res=explode('=',$str);
			if ($res[0]==$oneset) {
				return $res[1];
			}
			//$date=array_merge($date,array($res[0]=>$res[1]));
		}
		fclose($file);
	}
	function curip(){
		$ip='';
		if(Getenv('HTTP_CLIENT_IP') And StrCaseCmp(Getenv('HTTP_CLIENT_IP'),'unknown')){
			$ip=Getenv('HTTP_CLIENT_IP');
		}elseif(Getenv('HTTP_X_FORWARDED_FOR') And StrCaseCmp(Getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
			$ip=Getenv('HTTP_X_FORWARDED_FOR');
		}elseif(Getenv('REMOTE_ADDR')And StrCaseCmp(Getenv('REMOTE_ADDR'),'unknown')){
			$ip=Getenv('REMOTE_ADDR');
		}elseif(isset($_SERVER['REMOTE_ADDR']) And $_SERVER['REMOTE_ADDR'] And StrCaseCmp($_SERVER['REMOTE_ADDR'],'unknown')){
			$ip=$_SERVER['REMOTE_ADDR'];
		}else{
			$ip='127.0.0.1';
		}
		return $ip;
	}
?>
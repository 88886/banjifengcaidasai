<?php
	define('SCRIPT_ROOT',dirname(__FILE__).'/data/cookie/');
	header('Content-Type:image/png');
	showAuthcode('http://61.139.105.138/CheckCode.aspx');
	/**
	 * 加载目标网站图片验证码
	 * @param string $authcode_url 目标网站验证码地址
	 */
	function showAuthcode($authcode_url){
		$bh = $_GET['bh'];//获取首页中产生的随机字符串，加到cookie文件中以防多人访问时文件重名
	    $cookieFile = SCRIPT_ROOT.'cookie'.$bh.'.tmp';
	    $ch = curl_init($authcode_url);//模拟登陆
	    curl_setopt($ch,CURLOPT_COOKIEJAR, $cookieFile); // 把返回来的cookie信息保存在文件中
	    curl_exec($ch);
	    curl_close($ch);
	}
?>
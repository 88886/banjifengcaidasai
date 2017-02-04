<?php
	class indexController{
		public function __construct(){
			$sql="select * from vote_slide";
			$res=DB::findAll($sql);
			VIEW::assign("slide",$res);
			$sql="select * from vote_cate";
			$res=DB::findAll($sql);
			VIEW::assign("cate",$res);

			session_start();
			if(!(isset($_SESSION['xh'])))
			{
				VIEW::assign("uid","");
			}else{
				$xh=$_SESSION['xh'];
				$result = DB::findOne("select * from vote_user where xh = $xh");
				VIEW::assignarr($result);
				$votedata = DB::findALL("select * from vote_event INNER JOIN vote_option ON vote_event.oid = vote_option.oid where vote_event.uid = {$result['uid']}");
				VIEW::assign("votedata",$votedata);
			}
		}
		function index(){
			if (isset($_GET['p'])) {
				if (!is_numeric($_GET['p'])) {
					showmessage('恭喜你，你已经触发了本站的安全机制。你的操作涉嫌非法，现将跳转至主页。消逝的红叶防护', 'index.php');
		       		exit;
				}
			}
			$page=isset($_GET['p'])?intval($_GET['p']):1;
			$num=8;
			if($total=mysql_num_rows(DB::query("select * from vote_option"))){
			$pagenum=ceil($total/$num); 
			if($page>$pagenum || $page == 0){
		       showmessage('非法操作', 'index.php?c=index&m=index');
		       exit;
			}
			$offset=($page-1)*$num;
			if (isset($_GET['cid'])) {
				$cid=daddslashes($_GET['cid']);
				if(!is_numeric($cid)){
					showmessage('恭喜你，你已经触发了本站的安全机制。你的操作涉嫌非法，现将跳转至主页。消逝的红叶防护', 'index.php');
		       		exit;
				}
			    $sql="select * from vote_option where cid=$cid order by votes desc limit $offset,$num";
			}else{
				$sql="select * from vote_option order by votes desc limit $offset,$num";
			}
			$res=DB::findAll($sql);
			VIEW::assign("option",$res);
			$pages="";
			if($pagenum>1){
				$allurl=$_SERVER['PHP_SELF']."?c=index&m=index";
				$pages.="<ul data-am-widget=\"pagination\" class=\"am-pagination am-pagination-default\">";
				if($page!=1){
				$pages.="<li class=\"am-pagination-first\"><a href=\"".$allurl."&p=1\">首页</a></li>";
				$pages.="<li class=\"am-pagination-prev\"><a href=\"".$allurl."&p=".($page-1)."\">上一页</a></li>";
				}
				$pages.="<li class=\"am-active\"><span class=\"am-active\">".$page."</span></li>";
				if($page!=$pagenum){
				$pages.="<li class=\"am-pagination-next\"><a href=\"".$allurl."&p=".($page+1)."\">下一页</a></li>";
				$pages.="<li class=\"am-pagination-last\"><a href=\"".$allurl."&p=".$pagenum."\">尾页</a></li>";
				}
				$pages.="</ul>";
			}
			VIEW::assign("page",$pages);
			}
			VIEW::display('index.html');
		}
		function login(){//
			require_once(APP_ROOT.'/curl.class.php');
			$bh = $_POST['bh'];
			$cookieFile= APP_ROOT.'/data/cookie/cookie'.$bh.'.tmp';
			$code = $_POST['code'];
			$xh = $_POST['xh'];
			$password = $_POST['password'];
			$mysuse=new suseurl($xh,$password,$code,$cookieFile);
			$data=$mysuse->mydata();
			if ($data!=NULL) {
				$result = DB::findOne("select * from vote_user where xh = $xh");
				if ($result==NULL) {
					$arrayName = array('xh' =>$xh ,'uname'=>$data['3'] ,'college'=>$data['0'],'specialty'=>$data['1'],'class'=>$data['2']);
					DB::insert('vote_user',$arrayName);
					$_SESSION['xh']=$xh;
					showmessage('首次登陆成功', 'index.php');
				}else{
					$_SESSION['xh']=$xh;
					showmessage('登陆成功', 'index.php');
				}
				
			}
			
		}
		function option(){//
			$oid=daddslashes($_GET['oid']);
			if (is_numeric($oid)) {
				$sql="select * from vote_option where oid=$oid";
				$list=DB::findone($sql);
				VIEW::assignarr($list);
				VIEW::display('option.html');
			}else{
				showmessage('恭喜你，你已经触发了本站的安全机制。你的操作涉嫌非法，现将跳转至主页。消逝的红叶防护', 'index.php');
			}
			
		}

		function tp(){//
			$oid=daddslashes($_POST['oid']);
			if (!is_numeric($oid)) {
				showmessage('恭喜你，你已经触发了本站的安全机制。你的操作涉嫌非法，现将跳转至主页。消逝的红叶防护', 'index.php');
				exit;
			}
			$xh=$_SESSION['xh'];
			$result = DB::findOne("select * from vote_user where xh = $xh");
			if($result['surplus_num']>0){
				$even = DB::findAll("select * from vote_event where uid = {$result['uid']}");
				foreach ($even as $key => $val){
	            	if ($val['oid']==$oid) {
	            		echo '{"state":3}';
	            		return;
	            	}
            	}
				$ip=curip();//加这个有点慢，等有条件了，不要调用
				$thistime=time();
				$eventarr = array('uid' =>$result['uid'],'oid'=>$oid,'ip'=>$ip,'time'=>$thistime);
				DB::query("update vote_user set surplus_num=surplus_num-1 where xh = $xh");
				DB::query("update vote_option set votes=votes+1 where oid = $oid");
				DB::insert('vote_event',$eventarr);
				$user = DB::findOne("select * from vote_user where xh = $xh");
				$option = DB::findOne("select * from vote_option where oid = $oid");
				$res=array('surplus_num'=>$user['surplus_num'],'votes'=>$option['votes'],'state'=>1);
				echo json_encode($res);
				return;
			}else{
				echo '{"state":2}';
				return;
			}
			exit;
		}
		public function logout(){
			unset($_SESSION['xh']);
			showmessage('退出成功！', 'index.php');
		}


	}
?>
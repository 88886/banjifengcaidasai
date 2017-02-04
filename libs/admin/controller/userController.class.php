<?php
	class userController{
		public function __construct(){
			session_start();
			if(!(isset($_SESSION['admintel']))&&(SUSE::$method!='login')){
				showmessage('请登录后在操作！', 'admin.php?c=index&m=login');
				exit;
			}
		}
		public function __call($func="",$param="")
		{
			showmessage('页面不存在', 'admin.php?c=user&m=index');
			exit;
		}
		public function index(){
			$page=isset($_GET['p'])?intval($_GET['p']):1;
			$num=15;   
			if($total=mysql_num_rows(DB::query("select * from vote_user"))){
			$pagenum=ceil($total/$num); 
			if($page>$pagenum || $page == 0){
		       showmessage('非法操作', 'admin.php?c=user&m=index');
		       exit;
			}
			$offset=($page-1)*$num;
			$sql="select * from vote_user limit $offset,$num";
			$res=DB::findAll($sql);
			VIEW::assign("user",$res);
			$pages="";
			if($pagenum>1){
				$allurl=$_SERVER['PHP_SELF']."?c=user&m=index";
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
			VIEW::display('user.html');
		}
		//查看用户投了哪些,还没写
		public function getuser(){
			$cate = DB::findone("select * from vote_user where uid= {$_GET['uid']}");
			echo json_encode($cate);
		}
	}
?>
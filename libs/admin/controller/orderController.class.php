<?php
	class orderController{
		public function __construct(){
			session_start();
			if(!(isset($_SESSION['admintel']))&&(SUSE::$method!='login')){
				showmessage('请登录后在操作！', 'admin.php?c=index&m=login');
				exit;
			}
		}
		public function __call($func="",$param="")
		{
			showmessage('页面不存在', 'admin.php?c=order&m=index');
			exit;
		}
		public function index(){
			$page=isset($_GET['p'])?intval($_GET['p']):1;
			$num=22;   
			if($total=mysql_num_rows(DB::query("select * from vote_event"))){
			$pagenum=ceil($total/$num); 
			if($page>$pagenum || $page == 0){
		       showmessage('非法操作', 'admin.php?c=order&m=index');
		       exit;
			}
			$offset=($page-1)*$num;
			//$sql="select * from vote_event left join vote_user on vote_event.uid=vote_user.uid order by vote_event.oid desc limit $offset,$num";
			$sql="SELECT * FROM vote_user INNER JOIN vote_event ON vote_user.uid = vote_event.uid INNER JOIN vote_option ON vote_event.oid = vote_option.oid order by vote_event.eid desc limit $offset,$num";
			$res=DB::findAll($sql);
			VIEW::assign("order",$res);
			$pages="";
			if($pagenum>1){
				$allurl=$_SERVER['PHP_SELF']."?c=order&m=index";
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
			VIEW::display('orderlist.html');
		}
		public function getorder(){
			$orderid=$_GET['order_no'];
			$sql="select * from vote_eventgood where order_no = $orderid";
			$res=DB::findAll($sql);
			echo json_encode($res);
			return;
		}
	}
?>
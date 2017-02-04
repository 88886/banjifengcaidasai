<?php
	class goodController{
		public function __construct(){
			session_start();
			if(!(isset($_SESSION['admintel']))&&(SUSE::$method!='login')){
				showmessage('请登录后在操作！', 'admin.php?c=index&m=login');
				exit;
			}
		}
		public function __call($func="",$param="")
		{
			showmessage('页面不存在', 'admin.php?c=good&m=index');
			exit;
		}
		public function index(){
			$sql="select * from vote_cate order by c_order";
			$res=DB::findAll($sql);
			VIEW::assign("cate",$res);
			$page=isset($_GET['p'])?intval($_GET['p']):1;
			$num=10;
			if($total=mysql_num_rows(DB::query("select * from vote_option"))){
			$pagenum=ceil($total/$num); 
			if($page>$pagenum || $page == 0){
		       showmessage('非法操作', 'admin.php?c=good&m=index');
		       exit;
			}
			$offset=($page-1)*$num;
			if (isset($_GET['cid'])) {
			    $sql="select * from vote_option where cid={$_GET['cid']} order by votes desc limit $offset,$num";
			}else{
				$sql="select * from vote_option order by votes desc limit $offset,$num";
			}
			$res=DB::findAll($sql);
			VIEW::assign("good",$res);
			$pages="";
			if($pagenum>1){
				$allurl=$_SERVER['PHP_SELF']."?c=good&m=index";
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
			VIEW::display('goodlist.html');
		}
		public function addgood(){
			$sql="select * from vote_cate";
			$res=DB::findAll($sql);
			VIEW::assign("cate",$res);
			if($_POST){
				$fileInfo=$_FILES['img'];
				$allowExt=array('jpeg','jpg','png','JPEG','JPG','PNG','gif');
				$ext=pathinfo($fileInfo['name'],PATHINFO_EXTENSION);
				if(!in_array($ext,$allowExt)){
					showmessage('请上传图片文件', 'admin.php?c=good&m=addgood');
					exit;
				}
				ORG('uploadfile');
				$upload = new UploadFile();
				$upload->maxSize  = 3145728 ;
				$upload->allowExts  = array('jpg','gif','png','jpeg');
				$upload->savePath =  './public/uploads/voteoption/';
				if(!$upload->upload()) {
				}else{
					$info =  $upload->getUploadFileInfo();
				}
				if(!empty($info)){
					$_POST['img'] = $info[0]['savename'];
				}
				$_POST['infor'] =stripslashes($_POST['infor']);
				DB::insert("vote_option",$_POST);
				showmessage('成功', 'admin.php?c=good&m=addgood');
			}
			VIEW::display('addgood.html');
		}

		public function editgood(){
			$sql="select * from vote_cate";
			$res=DB::findAll($sql);
			VIEW::assign("cate",$res);
			if (isset($_GET['oid'])) {
				$res = DB::findone("select * from vote_option where oid= {$_GET['oid']}");
				VIEW::assignarr($res);
			}
			if($_POST){
				ORG('uploadfile');
				$upload = new UploadFile();
				$upload->maxSize  = 3145728 ;
				$upload->allowExts  = array('jpg','gif','png','jpeg');
				$upload->savePath =  './public/uploads/voteoption/';
				if(!$upload->upload()) {
				}else{
					$info =  $upload->getUploadFileInfo();
				}
				if(!empty($info)){
					$_POST['img'] = $info[0]['savename'];
				}
				$_POST['infor'] =stripslashes($_POST['infor']);
				DB::update("vote_option",$_POST,"oid ={$_POST['oid']}");
				showmessage('成功', 'admin.php?c=good&m=index');
			}
			VIEW::display('editgood.html');
		}
	}
?>
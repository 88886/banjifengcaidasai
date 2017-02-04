<?php
/**
* 四川理工学院正方教务管理系统
*/
class suseurl{
  private $cookiefiles;//在这里定义的这个私有成员，只是为了可以用析构函数来删除这个文件使用的，其他没有任何意义。因为，在其他方法使用过程中，都是进行了cookie文件参数的传递的
  //构造函数完成了登陆。其他的功能交给这个类中的其他方法来完成
  private $xh="";
  public function __construct($xh,$password,$code,$cookieFile){
    $this->cookiefiles=$cookieFile;
    $this->xh=$xh;
    $post['act'] = 'login';
    $post['__VIEWSTATE'] = $this->getView('http://61.139.105.138/default2.aspx');
    $post['txtUserName'] = $xh;
    $post['TextBox2'] = $password;
    $post['txtSecretCode'] = $code;
    $post['lbLanguage'] = '';
    $post['hidPdrs'] = '';
    $post['hidsc'] = '';
    $post['RadioButtonList1'] = iconv('utf-8', 'gb2312', '学生');
    $post['Button1'] = iconv('utf-8', 'gb2312', '登录');
    // $targetUrl curl 提交的目标地址
    $targetUrl = 'http://61.139.105.138/default2.aspx';
    // 登陆
    $ch = curl_init($targetUrl);
    curl_setopt($ch,CURLOPT_COOKIEFILE, $cookieFile); //同时发送Cookie
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $post); //提交查询信息
    $content = curl_exec($ch);
    curl_close($ch);
    //下面这段代码是对登录失败的检验的。
    if(!stripos($content,"here")){//这个是匹配是否出现object move here，在这里把出现这个标识为登陆成功。但是我也没有检验过，是不是在任何状态下都是这样
      $codebs=iconv('utf-8', 'gb2312', '验证码不正确');
      if (stripos($content,$codebs)) {//这里是检测是否出现验证码不正确这几个字
        showmessage('验证码不正确', 'index.php');
        exit;
      }else{
        showmessage('密码错误', 'index.php');
        exit;
      }
    }
  }
  function __destruct(){
    unlink($this->cookiefiles);//删除本次查询的cookie文件
    //删除300秒前的所有cookie文件
    $thistime=time();
    $thistime=$thistime-300;
    $dirName=APP_ROOT.'/data/cookie';
    if ( $handle = opendir( "$dirName" ) ) {  
       while ( false !== ( $item = readdir( $handle ) ) ) {  
         if ( $item != "." && $item != ".." ) {  
           if ( is_dir( "$dirName/$item" ) ) {  
                delFileUnderDir( "$dirName/$item" );  
           } else { 
              $a=filectime("$dirName/$item"); 
              if($a<$thistime){
                unlink( "$dirName/$item");
              }
           }  
          }  
        }  
      closedir( $handle );  
    }
  }
  /**
   * 获取隐藏字段值
   */
  function getView($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_REFERER, $url); 
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    $pattern = '/<input type="hidden" name="__VIEWSTATE" value="(.*?)" \/>/is';
    preg_match_all($pattern, $data, $matches);
    $res= $matches[1][0];
    return $res;
  }
  public function mydata(){
    $url="http://61.139.105.138/xsgrxx.aspx?xh=".$this->xh;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_REFERER, $url); 
    curl_setopt($curl,CURLOPT_COOKIEFILE, $this->cookiefiles); //同时发送Cookie
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);//设置cURL允许执行的最长秒数。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    if (curl_errno($curl)) {
      return curl_error($curl);
    }
    curl_close($curl);
    $data=mb_convert_encoding($data, "utf-8", "gb2312");
  //学院
    $pattern = '/<span id="lbl_xy"[\w\W]*?>([\w\W]*?)<\/span>/';
    preg_match_all($pattern, $data, $matches);
    $res[0] = $matches[0][0];
  //专业
    $pattern = '/<span id="lbl_zymc"[\w\W]*?>([\w\W]*?)<\/span>/';
    preg_match_all($pattern, $data, $matches);
    $res[1] = $matches[0][0];
  //班级
    $pattern = '/<span id="lbl_xzb"[\w\W]*?>([\w\W]*?)<\/span>/';
    preg_match_all($pattern, $data, $matches);
    $res[2] = $matches[0][0];
  //姓名
    $pattern = '/<span id="xm"[\w\W]*?>([\w\W]*?)<\/span>/';
    preg_match_all($pattern, $data, $matches);
    $res[3] = $matches[0][0];
    return $res;
  }
}
?>


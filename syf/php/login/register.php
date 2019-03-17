<?php
// header("Content-Type:text/html;charset=utf-8;");
// $arr = array ('Version_code'=>2,'Version_name'=>'UpdateVersion','Versoin_desc'=>urlencode('更新了地图功能'),'Versoin_path'=>urlencode('http://nnddkj.com/BusIot/APK/BusIot.apk'));
// echo urldecode(json_encode($arr));

header('content-type:text/html;charset=utf-8');
$connect=mysql_connect('localhost','root','');
if(!$connect){
   die('数据库连接失败'.mysql_error());
}else{
  echo '数据库连接成功';
}
mysql_select_db('syf');
mysql_query('SET NAMES UTF8');

var_dump($GLOBALS['HTTP_RAW_POST_DATA']);
var_dump($_POST);
$command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
$j =json_decode( $command,true);//true,转化成数组
var_dump($j['admin']);
$admin=$j['admin'];
// if(isset($_POST['phone'])||isset($_POST['submit'])){
//    $phone=$_POST['phone'];
// }else{exit('非法操作');}

$search=mysql_query("select * from user where admin='$admin'");

if(mysql_fetch_array($search)){
   echo '用户重名';
}else{
   echo '用户不重名';
};

$adm=$j['admin'];
$code=$j['code'];
$Thename=$j['Thename'];

mysql_query("INSERT INTO user (adm,code,Thename) 
VALUES ('$adm','$code', '$Thename')");

echo "<script>alert('注册成功！请登录')</script>";
   // header('location:http://localhost/conversetest/converse/src/html/');

?>
<?php
header('content-type:text/html;charset=utf-8');
$connect=mysql_connect('localhost','root','');
if(!$connect){
    die('数据库连接失败'.mysql_error());
}else{
}
mysql_select_db('syf');
mysql_query('SET NAMES UTF8');

$command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
$j =json_decode( $command,true);

$id=$j['id'];


$search=mysql_query("select * from lightnovel where id='$id'");
$row=mysql_fetch_array($search);

$arr = array (
    'errcode'=>0,
    'errmsg'=>urlencode('获取成功'),
    'data'=>array(
        'title'=>$row['title'],
        'content'=>$row['content']
    )
);
echo urldecode(json_encode($arr));

?>
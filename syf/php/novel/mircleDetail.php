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

$chapterTitle=$j['chapterTitle'];
$paragraphTitle=$j['paragraphTitle'];

$search=mysql_query("select * from heavynovel where chapterTitle='$chapterTitle' and paragraphTitle='$paragraphTitle'");
$row=mysql_fetch_array($search);

$arr = array (
    'errcode'=>0,
    'errmsg'=>urlencode('获取成功'),
    'data'=>array(
        'title'=>$row['paragraphTitle'],
        'content'=>$row['content']
    )
);
echo urldecode(json_encode($arr));

?>
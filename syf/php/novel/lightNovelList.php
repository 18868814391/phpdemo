<?php
header('content-type:text/html;charset=utf-8');
mysql_connect('localhost','root','');

mysql_select_db('syf');
mysql_query('SET NAMES UTF8');

$result=mysql_query("select * from lightnovel");

$arr=array();
//echo ($result);
for($i=0;$i<mysql_num_rows($result);$i++){
    $row=mysql_fetch_array($result,MYSQLI_ASSOC);
    $arr[$i]=array(
        'id'=>urlencode($row['id']),
        'title'=>urlencode($row['title']),
    );
//    $arr[$i]=urlencode($row['title']);
}
$arr2 = array (
    'errcode'=>0,
    'errmsg'=>urlencode('获取成功'),
    'data'=>$arr
);
echo urldecode(json_encode($arr2));
?>
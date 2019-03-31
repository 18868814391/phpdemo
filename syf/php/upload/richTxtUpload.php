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
$title=$j['title'];

$search=mysql_query("select * from lightnovel where title='$title'");

if(mysql_fetch_array($search)){
    $arr = array (
        'errcode'=>99,
        'errmsg'=>urlencode('重名')
    );
    echo urldecode(json_encode($arr));
    die();
}else{

};

$title=$j['title'];
$content=$j['content'];
$updataTime=$j['updataTime'];
$chapterTitle=$j['chapterTitle'];
$paragraphTitle=$j['paragraphTitle'];

if($chapterTitle){
    mysql_query("INSERT INTO heavynovel (content,updataTime,chapterTitle,paragraphTitle) VALUES ('$content', '$updataTime','$chapterTitle','$paragraphTitle')");

    $arr = array (
        'errcode'=>0,
        'errmsg'=>urlencode('创建成功'),
        'data'=>array(
            'title'=>$title,
            'content'=>$content
        )
    );
    echo urldecode(json_encode($arr));
}else{
    mysql_query("INSERT INTO lightnovel (title,content,updataTime) VALUES ('$title','$content', '$updataTime')");

    $arr = array (
        'errcode'=>0,
        'errmsg'=>urlencode('创建成功'),
        'data'=>array(
            'title'=>$title,
            'content'=>$content
        )
    );
    echo urldecode(json_encode($arr));
}


?>
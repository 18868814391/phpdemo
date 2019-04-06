<?php
header('content-type:text/html;charset=utf-8');
mysql_connect('localhost','root','');

mysql_select_db('syf');
mysql_query('SET NAMES UTF8');

$result=mysql_query("select * from heavynovel");

$arr=array();
//echo ($result);
for($i=0;$i<mysql_num_rows($result);$i++){
    $row=mysql_fetch_array($result,MYSQLI_ASSOC);
    if($i>0){
        if(urlencode($row['chapterTitle'])!=$arr[count($arr)-1]){
            array_push($arr,urlencode($row['chapterTitle']));
        }
    }else{
        array_push($arr,urlencode($row['chapterTitle']));
    }
}
$arrTwice=array();
for($k=0;$k<count($arr);$k++){
    $tit=urldecode($arr[$k]);
//    var_dump($tit);
    $arrTwice[$tit]=array();
//    var_dump($arrTwice);
//    die();

    $result=mysql_query("select * from heavynovel where chapterTitle='$tit'");
    for($j=0;$j<mysql_num_rows($result);$j++){
        $row=mysql_fetch_array($result,MYSQLI_ASSOC);
        array_push($arrTwice[$tit],urlencode($row['paragraphTitle']));
    }
}
//var_dump($arrTwice);
//echo $arrTwice;
$ar = array (
    'errcode'=>0,
    'errmsg'=>urlencode('获取成功'),
    'data'=>$arrTwice
);
echo urldecode(json_encode($ar));
?>
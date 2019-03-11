<?php
    header("Content-Type:text/html;charset=utf-8");
//    $name='syf';
//    $$name='沈怡帆';
//    echo $syf;
//    $a=1000;
//    $b=&$a;
//    $a=999;
//    echo $b;
//    $aaa=true;
//    var_dump($aaa);
//    $bb='syf';
//    $cc="12{$bb}3";
//    echo $cc;
//    $ccc=<<<qq
//qweqweqweqweqw''''""""""e
//qq;
//    echo $ccc;
//    define('SYF','沈怡帆');
//    echo SYF;
//    echo __file__;
//$arr=array(
//    'one','two','three','four','five'
//);
//$arr2=array(
//    'name'=>'syf',
//    'age'=>28,
//    'sex'=>1,
//    'hobby'=>'novel',
//    'add'=>'hangzhou'
//);
//print_r($arr);
//echo '</br>';
//print_r($arr2);
//echo '</br>';
//print_r(array_chunk($arr,3,TRUE));
//foreach ($arr2 as $key=>$value){
//    echo '<br>键名'.$key.'键值'.$value;
//}
//echo $arr[0];
//echo $arr2['name'];
//date_default_timezone_get('Asia/Shanghai');
//echo time().'<br>';
//echo date('y/m/d').'<br>';
//echo date('y/m/d-h:i:sa').'<br>';
//$now=mktime();
//echo date('y/m/d-h:i:sa',$now).'&nbsp;&nbsp;&nbsp;'.'this is now'.'<br>';
//$myDate=strtotime('next sunday');
//echo date('y/m/d-h:i:sa',$myDate).'&nbsp;&nbsp;'.'str时间'.'<br>';

//header('Content-type:image/jpeg');
//$width=120;
//$height=40;
//$element=array('a','b','c','d','e','f','g');
//$code=$element[rand(0,count($element)-1)].$element[rand(0,count($element)-1)].$element[rand(0,count($element)-1)];
//$img=imagecreatetruecolor($width,$height);
//$colorBg=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
//$colorBorder=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
//$colorString=imagecolorallocate($img,rand(10,100),rand(10,100),rand(10,100));
//imagefill($img,0,0,$colorBg);
//imagerectangle($img,0,0,$width-1,$height-1,$colorBorder);
//for($i=0;$i<100;$i++){
//    imagesetpixel($img,rand(0,$width-1),rand(0,$height-1),imagecolorallocate($img,rand(10,100),rand(10,100),rand(10,100)));
//}
//for($i=0;$i<3;$i++){
//    imageline($img,rand(0,$width/2),rand(0,$height),rand($width/2,$width),rand(0,$height),imagecolorallocate($img,rand(10,100),rand(10,100),rand(10,100)));
//}
//imagettftext($img,14,rand(-30,30),rand(30,50),25,$colorString,'font/Helvetica Bold Oblique.ttf',$code);
//imagejpeg($img);
//imagedestroy($img);
echo 123;
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}
?>

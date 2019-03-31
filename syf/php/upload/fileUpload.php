<?php
if ($_FILES["file"]["error"] > 0)
{
    echo "Error: " . $_FILES["file"]["error"] . "<br />";
}
else
{
    $fileName = $_FILES["file"]["name"];
    $type = $_FILES["file"]["type"];
    $size = ($_FILES["file"]["size"] / 1024)." kb" ;
    $tmp_name =  $_FILES["file"]["tmp_name"] ;
    move_uploaded_file($tmp_name,"upload/" .$fileName);
    $arr = array (
        'errcode'=>0,
        'errmsg'=>urlencode('上传成功'),
        'data'=>array(
            'fileName'=>$fileName,
            'Type'=>$type,
            'Size'=>$size,
            'Stored_in'=>$tmp_name,

        )
    );
    echo urldecode(json_encode($arr));
}
?>

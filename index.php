<?php
    header("Content-Type:text/html;charset=utf-8");
    $name='syf';
    $$name='沈怡帆';
    echo $syf;
    $a=1000;
    $b=&$a;
    $a=999;
    echo $b;
    $aaa=true;
    var_dump($aaa);
    $bb='syf';
    $cc="12{$bb}3";
    echo $cc;
    $ccc=<<<qq
qweqweqweqweqw''''""""""e
qq;
    echo $ccc;


?>

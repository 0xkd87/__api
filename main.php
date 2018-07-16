<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
 //    header("Content-Type: text/plain;base64; charset=UTF-8");
?>
<?php
    include_once('./cl.dbDriver.php');

    include_once('./defs/cl.UDT.php');
?>


<?php


    $db = new dbDriver('./../_dbTmp','a','.db');
    $db1 = new dbDriver('./../_dbTmp','b','.dbb');
    $t1 = new UDT();
    $t2 = new UDT();
    

    echo   $t1->jsonEncodeAttr(0);
?>
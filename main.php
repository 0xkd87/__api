<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
 //    header("Content-Type: text/plain;base64; charset=UTF-8");
?>
<?php
    include_once('./cl.dbDriver.php');

    include_once('./defs/e.php');
?>


<?php


    $db = new dbDriver('./../_dbTmp','a','.db');
    $db1 = new dbDriver('./../_dbTmp','b','.dbb');
    $t1 = new e();
    $t2 = new e();

//    $t2->_addNewAttr('newattr', 'rrr');
//    $s = $t2->serializeAttr();
//    $t1->setAttr($s);
 //   echo $t1->serializeAttr();
 //   echo $s;
    

    echo   $t1->jsonEncode('rev',0);
?>
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

    $tbl = "x";


    $db = new dbDriver('./../_dbTmp','a','.db');
    $db->dbExQuery("CREATE TABLE IF NOT EXISTS $tbl 
    (
        udt STRING PRIMARY KEY NOT NULL
    )");

    $postdata = file_get_contents("php://input");
    $t1 = new UDT();
    $t1->jsonDecodeAttr($postdata);

    //echo $t1->_Attr['plcTag']['name'];
    $ser = $t1->serializeAttr();
    //var_dump($ser);
    $db->dbExQuery("INSERT INTO '$tbl' (udt) VALUES ('$ser')");
        
    echo   $t1->jsonEncodeAttr(0);

    //$t1 = new UDT();
    

   //echo   $t1->jsonEncodeAttr(0);
?>
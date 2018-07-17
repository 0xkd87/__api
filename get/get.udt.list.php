<?php
    include('./../defs/httpHeaders.php');

    include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');

    $DirPath_ROOT_LibUDT = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);
?>


<?php

MakeDir($DirPath_ROOT_LibUDT);
$tbl = "x";


$db = new dbDriver($DirPath_ROOT_LibUDT,'LibUDT','.db');
//var_dump($db);
$row = array();
$results = $db->dbQuery("SELECT * FROM '$tbl' ");



while($r = $results->fetchArray())
{
    $c = new UDT();
    $c->setAttr($r['udt']);
    $row[] =  $c->jsonEncodeAttr(0);
}
    $jEnc = json_encode($row);
    echo $jEnc;

    $db->_dbDisconnect();
    exit;


?>
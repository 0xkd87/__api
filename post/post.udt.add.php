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
    $db->dbExQuery("CREATE TABLE IF NOT EXISTS $tbl 
    (
        udt STRING NOT NULL
    )");

    $postdata = file_get_contents("php://input");
    if($postdata)
    {
        $t1 = new UDT();
        $t1->jsonDecodeAttr($postdata);
    
        $t1->_Attr['plcTag']['name'] = 'server modified this';
        $ser = $t1->serializeAttr();
    
        $db->dbExQuery("INSERT INTO '$tbl' (udt) VALUES ('$ser')");

        //if query success
        echo $t1->jsonEncodeAttr(0);
    }

    exit;
?>
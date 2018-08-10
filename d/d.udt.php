
<?php
    include('./../defs/httpHeaders.php');

    include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');

    $DirPath_ROOT_LibUDT = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);
    include_once('./../drivers/drv.libUDT.php');

?>


<?php


    $drv = new drvLibUDT();
    if($drv)
    {
        echo $drv->deleteUDT();
    }
    else{
        echo "error";
    }
    exit;
?>
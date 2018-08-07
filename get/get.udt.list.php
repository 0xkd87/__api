<?php
    include('./../defs/httpHeaders.php');

    include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');
// 
    $DirPath_ROOT_LibUDT = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);

    include_once('./../drivers/drv.libUDT.php');
?>


<?php
/*     if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) 
    {
        ob_start("ob_gzhandler"); 
    } else {
        ob_start();
    } */
MakeDir($DirPath_ROOT_LibUDT);

    $drv = new drvLibUDT();

    echo $drv->getUDTList();
    // echo "xx";
    exit;


?>
<?php
    include('./../defs/httpHeaders.php');

    include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.prj.php');
// 
    // $DirPath_ROOT_LibUDT = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);

    include_once('./../drivers/drv.project.php');
?>


<?php

// MakeDir($DirPath_ROOT_LibUDT);

    $drv = new drvPrj();

    echo $drv->getActiveList();
    // echo "xx";
    exit;


?>
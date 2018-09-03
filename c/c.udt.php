<?php
    include('./../defs/httpHeaders.php');

    // include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');

    include_once('./../drivers/drv.libUDT.php');

?>


<?php


    $drv = new drvLibUDT();
    if($drv)
    {
        echo $drv->addNewUDT();
    }
    else{
        echo "error";
    }
    exit;
?>
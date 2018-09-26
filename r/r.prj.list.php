<?php
    include('./../defs/httpHeaders.php');

    include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.prj.php');

    include_once('./../drivers/drv.project.php');
?>


<?php

    $drv = new drvPrj();

    echo $drv->__r();
    exit;


?>
<?php
    include('./../defs/httpHeaders.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');

    include_once('./../drivers/drv.libUDT.php');

?>


<?php

    // var_dump( file_get_contents("php://input"));
    // var_dump($_REQUEST);

    // $drv = new drvLibUDT();
    // if($drv)
    // {
    //     echo $drv->addNewUDT();
    // }
    // else{
    //     echo "error";
    // }
//=====

        switch ($_REQUEST["op"]) {
            case 'c':
                $drv = new drvLibUDT();
                if($drv) {
                    echo $drv->addNewUDT();
                }
                break;
            
            default:
                    echo "Wrong Opcode requested..";
                break;
        }

    exit;
?>
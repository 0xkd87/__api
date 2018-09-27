<?php
    include('./../defs/httpHeaders.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');
    include_once('./../defs/cl.prj.php');

    include_once('./../drivers/drv.libUDT.php');
    include_once('./../drivers/drv.project.php');

?>


<?php

    // var_dump( file_get_contents("php://input"));
    // var_dump($_REQUEST);

    $drv;
    // check:1 - Valid driver op code check
    if(!array_key_exists("op", $_REQUEST))
    {
        echo "Missing Request Argument: [Valid Op-Code]";
        exit;
    }

    // check:1 - Valid driver op code check
    if(!array_key_exists("drv", $_REQUEST))
    {
        echo "Missing Request Argument: [Valid Driver for request processing]";
        exit;
    } else {
        // Valid driver is found in the request parameter
        switch ($_REQUEST["drv"]) {
            case 'libUDT':
                $drv = new drvLibUDT();
                break;

            case 'prj':
                $drv = new drvPrj();
                break;
            
            default:
                echo "Wrong Dirver requested..";
            break;
        }
    }

        switch ($_REQUEST["op"]) {
            case 'c':
                if($drv) {
                    echo $drv->__c();
                }
                break;
            case 'u':
                if($drv) {
                    echo $drv->__u();
                }
                break;
            case 'd':
                if($drv) {
                    echo $drv->__d();
                }
                break;

            case 'r':
                if($drv) {
                    echo $drv->__r();
                }
                break;
            
            default:
                    echo "Wrong Opcode requested..";
                break;
        }

    exit; // success exit END
?>
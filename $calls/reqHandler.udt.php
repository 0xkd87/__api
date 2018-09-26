<?php
    include('./../defs/httpHeaders.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');

    include_once('./../drivers/drv.libUDT.php');

?>


<?php
    if(array_key_exists("op", $_REQUEST))
    { 
        $drv = new drvLibUDT();
        switch ($_REQUEST["op"]) {
            case 'c':
                if($drv) {
                    echo $drv->addNewUDT();
                }
                break;
            case 'u':
                if($drv) {
                    echo $drv->updateUDT();
                }
                break;
            case 'd':
                if($drv) {
                    echo $drv->deleteUDT();
                }
                break;

            case 'r':
                if($drv) {
                    echo $drv->getUDTList();
                }
                break;
            
            default:
                    echo "Wrong Opcode requested..";
                break;
        }
    } else {
        echo "OP-code is missing";
    }

    exit;
?>
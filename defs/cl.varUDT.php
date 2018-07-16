<?php
    include_once('cl.plcTag.php');

    class udtTag 
    extends plcTag  //This is a PLC Tag too..!
   {

       function __construct
        (
           bool $isDiagEv = FALSE //is this a diagnosic event (triggers a/w/m?)
        )
        {
            parent::__construct(); // call parent constuct first = adds all defualt attribute nodes
            if($isDiagEv)
            {
                $this->_addNewAttrFromSchema('diagEv');
            }

            $this->_Attr['ident']['objType'] = CONST_OBJTYPE::UDT_VAR;
        }

   
   
    }



?>
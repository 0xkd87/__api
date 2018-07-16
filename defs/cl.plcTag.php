<?php
    include_once('cl.objDef.php');

    class plcTag extends objDef
   {

       function __construct()
        {
            parent::__construct(); // call parent constuct first = adds all defualt attribute nodes

            $this->_addNewAttrFromSchema('plcTag');
            
        }

   
   
    }



?>
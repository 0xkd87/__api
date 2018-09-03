<?php
    include_once('cl.plcTag.php');
    include_once('cl.varUDT.php');

    class UDT 
    extends plcTag  //This is a PLC Tag too..!
   {
       // Member variables after base class's members
        public $vars = array();


// Construct
        function __construct()
        {
            parent::__construct(); // call parent constuct first = adds all defualt attribute nodes

            $this->setObjType(CONST_OBJTYPE::UDT);

            $this->_addNewAttrFromSchema('vars');
        }

   
   
    }



?>
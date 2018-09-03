<?php
    include_once('cl.objDef.php');

    class PRJ 
    extends objDef  
   {
        public $prj = array();

        function __construct()
        {
            parent::__construct(); // call parent constuct first = adds all defualt attribute nodes

            $this->setObjType(CONST_OBJTYPE::PRJ);

            // Noed: Project interface
            $this->_addNewAttrFromSchema('prj'); // Add a node from schema definition
        }

   
   
    }



?>
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

        public function initDir()
        {
            $this->_addNewAttrFromSchema('fs'); // Add a node from schema definition

            $this->_Attr['fs']['dir'] = $this->_newGUID(rand(),24);

            $dArr = [];

            $dArr["lib"] = ".lib";
            $dArr["upload"] = ".upload";
            $dArr["li"] = ["awm"=>".awm", "io"=> ".io"];

            $this->_Attr['fs']['dirs'] = $dArr;
        }

        public function get_DirName()
        {
            if($this->_Attr['fs']['dir']) {
                return $this->_Attr['fs']['dir'];
            }
        }

        public function get_subDirStruct()
        {
            if($this->_Attr['fs']['dirs']) {
                return $this->_Attr['fs']['dirs'];
            }
        }
   
    }



?>
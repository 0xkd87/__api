<?php
   include_once('cl.__schemaLib.php');
?>

<?php
   class objDef extends __schemaLib
   {
        private $_Attr = array();  //this holds all the info (static declaration here| Althogh runtime creation will also be possible)
        private $_guid = "";

        protected
        function __construct()
        {
            /* populate following default attribute nodes in the attribute array
            regardless of the object type */
            $this->_addNewAttrFromSchema("ident");
            $this->_addNewAttrFromSchema("rev");

            $this->_Attr['ident']['_uid'] = $this->_newGUID(rand(),24);
            $this->setObjType(CONST_OBJTYPE::ABSTRACT);
        }
        protected
        function setObjType($ot)
        {
            $this->_Attr['ident']['objType'] = $ot;
        }
        private 
        function _newGUID($txt , $len = 40)
        {
            return substr(sha1($txt),0,$len);
        }

        //Add a new atribute: Key and Value pair are required
        private 
        function _addNewAttr($k,$v) //must be protected after tests..!
        {
            $this->_Attr[$k] = $v;
        }

        protected  //Protected: So all derived classes (extendING) can access this
        function _addNewAttrFromSchema($k)
        {
            $this->_addNewAttr($k,$this->getNodeSchema($k));
        }


/* ==== JSON En/de-codeing === */

        /* (json) encodes only the NODE (Specified by $AttrNode) 
        form the Attribute Array in the given class 
        */
        public 
        function jsonEncodeNode( string $AttrNode, int $encodeLevel=2)
        {
            $je = json_encode(array()); //initialize with default empty array
            foreach( $this->_Attr as $Node => $Arr )
            {
                if($AttrNode === $Node)
                {
                    $je = json_encode($Arr);
                }
            }

            //encoding required?
            for($i=0;$i<$encodeLevel;$i++)
            {
                $je = base64_encode($je);
            }
            return ($je);
        }

        /* 
        (json) encodes the complete Attribute Array in the given class
        */
        public 
        function jsonEncodeAttr(int $encodeLevel=2)
        {
            $je = json_encode($this->_Attr);
  
            //encoding required?
            for($i=0;$i<$encodeLevel;$i++)
            {
                $je = base64_encode($je);
            }
            return ($je);
        }


        /*
        SERIALIZATION
        */


        public 
        function serializeAttr()
        {
            return serialize($this->_Attr);
        }

        public 
        function setAttr(string $serializedString)
        {
            if($serializedString)
            {
                $this->_Attr = unserialize($serializedString);
            }
        }

    }



?>
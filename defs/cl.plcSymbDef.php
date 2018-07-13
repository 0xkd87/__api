<?php
   include_once('cl.__schemaLib.php');
?>

<?php
   class plcSymbDef extends __schemaLib//objDef
   {
        private $Attr = array();
        private $_guid = "";
        function __construct()
        {
            $this->_guid = $this->_newGUID(rand(),24);
            $this->_addNewAttrFromSchema("rev");
            $this->_addNewAttrFromSchema("rev1");

         $this->Attr['rev']['major']=$this->_newGUID(rand(),5);
         $this->Attr['rev']['minor']=$this->_newGUID(rand(),5);
         $this->Attr['rev']['by']=$this->_newGUID(rand(),15);
         $this->Attr['rev']['on']=$this->_newGUID(rand(),25);
         //$this->Attr['rev']['on']=$this->_newGUID(rand(),5);
        }

        protected 
        function _newGUID($txt , $len = 40)
        {
            return substr(sha1($txt),0,$len);
        }

        //Add a new atribute: Key and Value pair are required
        private 
        function _addNewAttr($k,$v) //must be protected after tests..!
        {
            $this->Attr[$k] = $v;
        }

        protected
        function _addNewAttrFromSchema($k)
        {
            $this->_addNewAttr($k,$this->getNodeSchema($k));
        }

        public function jsonEncode( string $AttrNode, int $encodeLevel=2)
        {
            $je = json_encode(array()); //initialize with default empty array
            foreach( $this->Attr as $Node => $Arr )
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

        public function serializeAttr()
        {
            return serialize($this->Attr);
        }

        public function setAttr(string $serializedString)
        {
            if($serializedString)
            {
                $this->Attr = unserialize($serializedString);
            }
        }

    }



?>
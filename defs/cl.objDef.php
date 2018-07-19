<?php
   include_once('cl.__schemaLib.php');
?>

<?php
   class objDef extends __schemaLib
   {
        public 
        $_Attr = array();  //this holds all the info (static declaration here| Althogh runtime creation will also be possible)
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

        /* Sets the Object ID which is auto assigned */
        public
        function setAttr_RowIdx(int $_rowid_)
        {
            $this->_Attr['ident']['idx'] = $_rowid_;
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

        //gets all Attr Node names as array
        public
        function getAttrNodeNamesAsArray()
        {
            $a = []; //init
            foreach( $this->_Attr as $NodeName => $ValArr )
            {
                $a[$NodeName] =  $NodeName; //add all the 1st level nodes
            }
            return $a;
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

        public 
        function jsonDecodeAttr($encodedString, int $encodeLevel=0)
        {
            $rxAttr = json_decode($encodedString,true); //fetch all the attributes from JSON stream
            //assign only the attributes which are received from Json; keeping the sensitive info as read only by the front end
            foreach( $rxAttr as $k => $v )
            {
              if( is_array( $v ) ) 
              $this->_Attr[ $k ] = $v;
            }
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
        function serializeAttrNode($AttrNode = "")
        {
            if($AttrNode !== "")
            {
                return serialize($this->_Attr[$AttrNode]);
            }
            return serialize($this->_Attr);
        }

        public 
        function unserializeToAttrNode(string $serializedString,$AttrNode = "")
        {

            if($serializedString)
            {
                if($AttrNode !== "")
                {
                    $this->_Attr[$AttrNode] = unserialize($serializedString);
                    return true; //get out
                }
                else
                $this->_Attr = unserialize($serializedString);
            }
        }

    }



?>
<?php
   //Abstract definition of any PLC symbol
?>

<?php



    //definition - strucure

    //searchhints

 abstract   
 class __schemaLib 
    {
        //basic object info
        private 
        $schemaLib = array
        (
            "metaData" => array 
            (
                "guid" => "deadbeef",
                "lang" => "en"
            ),
            "rev" => array 
            (
                "major" => 0,
                "minor" => 0,
                "on" => "",
                "by" => "",
                "comment" => array
                (
                    "en" => "en-comment"
                )
            ),
            "symbol" => array
            (
                "isF" => false,
                "name" => "",
                "datatype" => "BOOL",
                "comment" => array
                (
                    "en" => ""
                )
            )
        );

        /*
            create the new attribute node in the attribute tree
            as a name passed as an argument
        */
        protected final 
        function getNodeSchema(string $AttrNode)
        {
            $a = array();
            foreach( $this->schemaLib as $Node => $Arr )
            {
                if($AttrNode === $Node)
                {
                    $a = $this->_getNodeAsArray($Arr);
                    return ($a);  //if foud, get out
                }
                else {
                    //return an empty array
                }
            }

            /*return an empty array if nothig found*/
            return ($a);
        }


        private final
        function _getNodeAsArray( $array )
        {
            foreach( $array as $key => $value )
            {
              if( is_array( $value ) ) 
              $array[ $key ] = $this->_getNodeAsArray( $value );
            }
            return (array) $array;
          }
    }



?>

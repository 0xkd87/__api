<?php
   include_once('interface.constants.php');
?>

<?php


 abstract   
 class __schemaLib implements CONST_OBJTYPE
    {


        //basic object info
        private 
        $schemaLib = array
        (
            "ident" => array 
            (
                "_uid" => "deadbeef", //unique object id - assigned at the time of construct
                "idx" => -1, // the index (Auto assigned by DB) which is used to call this element from the App
                "lang" => "en",
                "objType" => "", //Tag,FB,UDT,AlarmList....
                "hasChildern" => false
            ),
            "rev" => array 
            (
                "major" => 0,
                "minor" => 0,
                "on" => "",
                "by" => "",
                "comment" => array
                (
                    "en" => "en-comment."
                )
            ),
            "plcTag" => array //basic plc tag object (Tag = Symbol, FB, FC, UDT, DB, I/O...)
            (
                "isF" => false,
                "name" => "",
                "datatype" => "BOOL",
                "address" => "",
                "comment" => array
                (
                    "en" => ""
                )
            ),


            "varUDT" => array
            (
                "rowIdx" => 0,
                "isDiagEv" => false // is this UDT variable contains additional Diag Event (AWM) info?
            ),

            "diagEv" => array //= Diagnostic Event
            (
                "evCat" => "", //diagnosis category (alarm/Warning/Message)
                "evHelp" => array
                (   
                    "lang" => "en",

                    "desc" => array
                    (
                        "idx" => -1,
                        "text" => ""
                    ),
                    "cause" => array
                    (
                        "idx" => -1,
                        "text" => ""
                    ),
                    "check" => array
                    (
                        "idx" => -1,
                        "text" => ""
                    ),
                    "reset" => array
                    (
                        "idx" => -1,
                        "text" => ""
                    )
                )

            ),

            "project" => array
            (
                "status" => "",
                "team" => array
                (

                ),
                "name" => "",
                "num" => "",

                "created" => array //set when object is created - and locked
                (
                    "on" => "",
                    "by" => ""
                ),
                "customer" => array
                (
                    "name" => "",
                    "address" => "",
                    "email" => array(),
                    "tel" => array()
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

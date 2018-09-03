<?php


interface CONST_OBJTYPE
{
    CONST ABSTRACT = "ABSTRACT";
    CONST UDT = "UDT";
    CONST UDT_VAR = "UDT_VAR";
    CONST PRJ = "PRJ";
   // private function __construct(){}

};

?>

<?php

/** 
 * Any function or operation result codes
*/
    interface RETURN_CODE
    {
        CONST RETURN_SUCCESS = 0;
        CONST RETURN_ERROR = -1; // Generaic error; failed operation
        CONST RETURN_FILE_EXISTS = 2;

    }

?>
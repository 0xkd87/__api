<?php

abstract
class DATATYPES_SQLite3 extends SplEnum
{
    const INT = "INTEGER"; 
    const INTEGER = "INTEGER"; 

    const CHAR = "TEXT"; 
    const VARCHAR = "TEXT"; 
    const STRING = "TEXT"; 
    const TEXT = "TEXT"; 

    const REAL = "REAL"; 
    const DOUBLE = "REAL"; 
    const FLOAT = "REAL"; 

    const BLOB = "BLOB";

    const NUMERIC = "NUMERIC";
    const BOOL = "NUMERIC";
    const DEC = "NUMERIC";
    const HEX = "NUMERIC";
    const DATE = "NUMERIC";
    const DATETIME = "NUMERIC";

    const __default = self::TEXT;
};

class defTableField implements DATATYPES_SQLite3
{
    private     $_name = '';
    private     $_type = ''; //acceptable SQLITE datatype
    private     $_is_pk = false; //primary key
    private     $_is_nn = false; //not null constraint
    private     $_is_unq = false; //unique constraint
    private     $_is_ai = false; //auto increment

   public function  __construct
   (
       string $name,
       DATATYPES_SQLite3 $type,
       bool $isPrimaryKey = false,
       bool $isNotNull = false,
       bool $isUnique = false,
       bool $isAutoIncrement = false
   )
   {
        if($isAutoIncrement)
        {
            $this->_is_ai = true;
            $this->_is_pk = true;
        }

        if(!$isPrimaryKey)
        {
            $this->_is_ai = false;
            $this->_is_pk = false;
        }
        $this->_is_unq = $isUnique;
        $this->_is_nn = $isNotNull;

        
   }




};


?>
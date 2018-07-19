<?php

interface CONST_SQL_TABLE
{
    const FIELDTYPE_INT = "INTEGER"; 
    const FIELDTYPE_INTEGER = "INTEGER"; 

    const FIELDTYPE_CHAR = "TEXT"; 
    const FIELDTYPE_VARCHAR = "TEXT"; 
    const FIELDTYPE_STRING = "TEXT"; 
    const FIELDTYPE_TEXT = "TEXT"; 

    const FIELDTYPE_REAL = "REAL"; 
    const FIELDTYPE_DOUBLE = "REAL"; 
    const FIELDTYPE_FLOAT = "REAL"; 

    const FIELDTYPE_BLOB = "BLOB";

    const FIELDTYPE_NUMERIC = "NUMERIC";
    const FIELDTYPE_BOOL = "NUMERIC";
    const FIELDTYPE_DEC = "NUMERIC";
    const FIELDTYPE_HEX = "NUMERIC";
    const FIELDTYPE_DATE = "NUMERIC";
    const FIELDTYPE_DATETIME = "NUMERIC";

    const FIELDTYPE_SERIALIZED_OBJ = "TEXT"; 

    const OP_CREATE = "CREATE";
    const OP_DROP = "DROP";
    const OP_ALTER = "ALTER";
};

class sqlTableField 
{
    private     $_name = '';
    private     $_type = ''; //acceptable SQLITE datatype
    private     $_is_pk = false; //primary key
    private     $_is_nn = false; //not null constraint
    private     $_is_unq = false; //unique constraint
    private     $_is_ai = false; //auto increment

   public function  __construct
   (
       string $name, //Field name [Don't use "_rowid_", "oid", or "RowId"]
       string $type, //Expected data type as [String] from one of the constants defined with the interface
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

        //Datatype sanity check
        $this->_type = $type;
        
        //Name: Check for "prohibited" names?
        $this->_name = $name;
    }

    public function getSqlString()
    {
        $sqlStr = $this->_name . "    " . $this->_type; 
        if($this->_is_nn)
        {
            $sqlStr.= " NOT NULL";
        }
        if($this->_is_pk)
        {
            $sqlStr.= " PRIMARY KEY";
        }
        if($this->_is_ai)
        {
            $sqlStr.= " AUTOINCREMENT";
        }
        if($this->_is_unq)
        {
            $sqlStr.= " UNIQUE";
        }

        return ($sqlStr);
    }
};



class sqlTable implements CONST_SQL_TABLE
{
    private $_name = ''; //Table name
    private $_field = []; //array of fields

    function __construct(string $tableName)
    {
        if($tableName !== '')
        {
            $this->_name = $tableName;
        }
        //Add first field "idx" as defualt
        $this->addField("idx",self::FIELDTYPE_INTEGER,true,true,true,true);
    }

    public
    function addField
    (
        string $name, //Field name [Don't use "_rowid_", "oid", or "RowId"]
        string $type, //Expected data type as [String] from one of the constants defined with the interface
        bool $isPrimaryKey = false,
        bool $isNotNull = false,
        bool $isUnique = false,
        bool $isAutoIncrement = false
    )
    {
        $this->_field[] = new sqlTableField  (   $name,
                                                    $type,
                                                    $isPrimaryKey,
                                                    $isNotNull,
                                                    $isUnique,
                                                    $isAutoIncrement);
    }

    private 
    function _getSqlStr_CREATE()
    {
        $sqlStr = "CREATE TABLE IF NOT EXISTS ";

        $sqlStr.= $this->getTableName();

        $sqlStr.= "( ";

        foreach ($this->_field as $col) {
            $sqlStr.= $col->getSqlString();
            if(next($this->_field))
            {
                $sqlStr.= ", "; // add "," if it's not the last element
            }
        }

        $sqlStr.= " )";
        return ($sqlStr);
    }

    private 
    function _getSqlStr_DROP()
    {

    }
    public function getTableName()
    {
        return ($this->_name);
    }

    public function getSqlString(string $op)
    {
        switch ($op) 
        {
            case self::OP_CREATE:
                    return ($this->_getSqlStr_CREATE());
                break;
            case self::OP_DROP:
                return ($this->_getSqlStr_DROP());
            break;
            default:
                break;
        }
        
    }


}


?>
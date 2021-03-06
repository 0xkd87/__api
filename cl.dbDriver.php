<?php

?>

<?php
class dbDriver
{

    private
    $_dbParam = array
    (
        "dbName" => "", //name of the db (file)
        "dbFileExt" => ".db", //custom file extension, if applicable
        "dbPath" => "../", //path where db is stored
        "flags" => array 
        (
            "createNew" => true,  //create new if file (db) does not exist
            "readOnly" => false  //open as read only db
        )
    );
    private $_db = null;

    //Constructor
    function __construct(string $dbPath, string $dbName, string $dbFileExt = 'db', bool $dbCreate = TRUE, bool $dbOpenReadOnly = FALSE)
    {
       
        //Set db properties
        $this->_dbParam["dbName"] = $dbName;
        $this->_dbParam["dbFileExt"] = $dbFileExt;
        $this->_dbParam["dbPath"] = $dbPath;
        $this->_dbParam["flags"] ["createNew"] = $dbCreate;
        $this->_dbParam["flags"] ["readOnly"] = $dbOpenReadOnly;
      

        if($this->_dbConnect($this->_dbParam))
        {
            echo("Errrrrrrr");
        }
    }

    function __destruct()
    {
        //$this->_dbVacuum();
        /* Close the DB connection on desctruction of the object : good practice..! */
        if($this->_db)
        {
            $this->_db->close();
        }
    }
/**
 * Vacuum the DB: Garbage collection
 * Provide this vacuum method to public. instead of keeping it private and calling on destruction.
 * API caller may not want to perform garbage collection on each operation. 
 * it's better to call it on each delete trigger
 */
    public
    function dbGC() //Garbage Collect
    {
        $this->dbExQuery("VACUUM");
    }

    private 
    function _dbConnect($dbParam = []) : int
    {
        $f = 0;
        if($dbParam["flags"] ["createNew"])
        {
            $f =  SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE;
        }
        elseif((!$dbParam["flags"] ["createNew"]) & ($dbParam["flags"] ["readOnly"]))
        {
            $f = SQLITE3_OPEN_READONLY;
        }
        else
        {
            $f = SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE;
        }

        $dbFile = $dbParam["dbPath"]. '/' .$dbParam["dbName"].$dbParam["dbFileExt"];
        $this->_db = new SQLite3($dbFile,$f);

        if($this->_db)
        {
            return 0;
        }
        return -1;
    }

    public function dbExQuery(string $qStatement)
    {
        if($this->_db)
        {
            $this->_db->exec($qStatement);
        }
    }

    public function dbQuery(string $query)
    {
        if($this->_db)
        {
           return($this->_db->query($query));
        }
    }

    /*
    creates/initialized tables in the db
    */
    public
    function initTable(string $sqlStr)
    {
        if($sqlStr !== '')
        {
            $this->dbExQuery($sqlStr);
        }
    }


}
?>
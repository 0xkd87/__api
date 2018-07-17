<?php

?>

<?php
class dbDriver
{

    public $_dbParam = array
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

    private function _dbConnect($dbParam = []) : int
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
    private function _dbDisconnect()
    {

    }

    public function dbExQuery(string $qStatement)
    {
        if($this->_db)
        {
            $this->_db->exec($qStatement);
        }
    }

}
?>
<?php
    include('./../defs/httpHeaders.php');

    include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');
    $DirPath_ROOT_LibUDT = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);

    class drvLibUDT
    {
        const DB = "libUDT";
        const DB_FILE_EXT = ".db";
        const TABLE_UDT = "x";
        const TABLE_UDT_CATEGORY = "cat";

        const PATH = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);

        private  $_dbDrv = null;
        /* Initialize databse driver */
        private
        function _initDB()
        {
            $this->_dbDrv = new dbDriver(self::PATH,self::DB,self::DB_FILE_EXT);
        }

        private
        function _initTables()
        {
            $this->_dbDrv->dbExQuery("CREATE TABLE IF NOT EXISTS ". self::TABLE_UDT .
            "(
                udt STRING NOT NULL
            )"
            );
        
        }

        public
        function __construct()
        {
            $this->_initDB();
            $this->_initTables();
        }

        public
        function isInitialized() : bool
        {
            if($this->_dbDrv)
            {
                return true;
            }
            return false;
        }
        public
        function getUDTList()
        {
            $row = array();

            if($this->isInitialized())
            {
                $results = $this->_dbDrv->dbQuery("SELECT * FROM ". self::TABLE_UDT);
                
                
                while($r = $results->fetchArray())
                {
                    $c = new UDT();
                    $c->setAttr($r['udt']);
                    $row[] =  $c->jsonEncodeAttr(0);
                }
                $this->_dbDrv->_dbDisconnect();
            }
                $jEnc = json_encode($row);
                return $jEnc;
            

        }
    }

?>
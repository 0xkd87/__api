<?php
    include('./../defs/httpHeaders.php');

    include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');

    include_once('./../defs/service.sqlTable.php');
    $DirPath_ROOT_LibUDT = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);

    class drvLibUDT
    {
        const DB = "libUDT";
        const DB_FILE_EXT = ".db";
        const TABLE_UDT = "x";
        const TABLE_UDT_CATEGORY = "cat";

        const PATH = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);
        private $_arrNode = [];
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
            //Create a temporary object for function call
            $this->_arrNode = (new UDT())->getAttrNodeNamesAsArray(); //Node name array is populated
            $x = new sqlTable(self::TABLE_UDT);
            foreach ($this->_arrNode as $k => $v) 
            {
                $x->addField( $v,$x::FIELDTYPE_SERIALIZED_OBJ);
            }

            //var_dump($x);

            $this->_dbDrv->initTable($x->getSqlString($x::OP_CREATE));
            

        
        }

        public
        function __construct()
        {
            $this->_initDB();
            $this->_initTables();
        }

        public
        function __destruct()
        {

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
                    foreach ($this->_arrNode as $k => $v) 
                    {
                        $c->unserializeToAttrNode($r[$v],$v);
                    }
                    $c->setAttr_RowIdx($r['idx']);
                    $row[] =  $c->jsonEncodeAttr(0);
                }
            }
                $jEnc = json_encode($row);
                return $jEnc;
            

        }
/* Adds a new UDT to the data base... */
        public
        function addNewUDT()
        {

            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $newUDT = new UDT(); //init a new OBJ
                $newUDT->jsonDecodeAttr($postdata);
            
                $newUDT->_Attr['plcTag']['name'] = GenerateRandomString();
                $ser = array();

                $sqlInsertStr = "INSERT INTO ". self::TABLE_UDT . " (";
                foreach ($this->_arrNode as $k => $v) 
                {
                    $ser[$v] = $newUDT->serializeAttrNode($v);
                    $sqlInsertStr.= $k;
                    if(next($this->_arrNode))
                    {
                        $sqlInsertStr.= ", "; // add "," if it's not the last element
                    }
                }
                $sqlInsertStr.= ") VALUES (";
                
                foreach ($ser as $k => $v) 
                {                     
                    $sqlInsertStr.= "'".$v."'";
                    if(next($ser))
                    {
                        $sqlInsertStr.= ", "; // add "," if it's not the last element
                    }
                }
                $sqlInsertStr.= ");";
                //var_dump($sqlInsertStr);
                //$ser = $newUDT->serializeAttrNode("plcTag");
                if($this->isInitialized())
                {
                    $this->_dbDrv->dbExQuery($sqlInsertStr);
                }
        
                //if query success
                return $newUDT->jsonEncodeAttr(0);
            }

/*             MakeDir($DirPath_ROOT_LibUDT);
            $tbl = "x";
        
        
            $db = new dbDriver($DirPath_ROOT_LibUDT,'LibUDT','.db');
            $db->dbExQuery("CREATE TABLE IF NOT EXISTS $tbl 
            (
                udt STRING NOT NULL
            )");
        
            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $t1 = new UDT();
                $t1->jsonDecodeAttr($postdata);
            
                $t1->_Attr['plcTag']['name'] = 'server modified this';
                $ser = $t1->serializeAttr();
            
                $db->dbExQuery("INSERT INTO '$tbl' (udt) VALUES ('$ser')");
        
                //if query success
                echo $t1->jsonEncodeAttr(0);
            } */
        }
    }

?>
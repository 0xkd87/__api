<?php
    include('./../defs/httpHeaders.php');

    // include_once('./../GlobalDef.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.UDT.php');

    include_once('./../services/service.sqlTable.php');

    include_once('./../services/service.pathProvider.php');

    class drvLibUDT
    {
        const DB = "libUDT";
        const DB_FILE_EXT = ".db";
        const TABLE_UDT = "x";
        const TABLE_UDT_CATEGORY = "categories";
        private $PATH;
        // const PATH = (PATH__DATA_ROOT . DIRNAME__LIBUDT_ROOT);
        // const PATH = ((new pathProvider("lib/libUDT"))->buildPath());

        private $_arrNode = [];
        private  $_dbDrv = null;
        /* Initialize databse driver */
        private
        function _initDB()
        {
            $this->_dbDrv = new dbDriver($this->PATH,self::DB,self::DB_FILE_EXT);
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

            $this->_dbDrv->initTable($x->getSqlString($x::OP_CREATE));
            

        
        }

        public
        function __construct(string $dest = "lib/libUDT")
        {
            $this->PATH = ((new pathProvider($dest))->buildPath());

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
        function __r(bool $getSorted = true)
        {
            $row = array();

            if($this->isInitialized())
            {
                /**
                 * Dirty way, but fetch and send everything in this case
                 */
                $sqlStr = "SELECT * FROM ". self::TABLE_UDT;
                if($getSorted === true)
                {
                    $sqlStr.= " ORDER BY idx DESC";
                }
                $results = $this->_dbDrv->dbQuery($sqlStr);
                
                
                while($r = $results->fetchArray())
                {
                    $c = new UDT();
                    foreach ($this->_arrNode as $k => $v) 
                    {
                        $c->unserializeToAttrNode($r[$v],$v);
                    }
                    /**
                     * Very important..! 
                     * Write a [IDX] stored as a separate column to the Object before sending to Front-end
                     * The IDX is not stored in the serialized object in the DB..!
                     */
                    $c->setAttr_RowIdx($r['idx']);

                    $row[] =  $c->jsonEncodeAttr(0);
                }
            }
                $jEnc = json_encode($row);
                return $jEnc;
            

        }
/* Adds a new UDT to the data base... */
        public
        function __c()
        {

            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $newUDT = new UDT(); //init a new OBJ
                //$newUDT->jsonDecodeAttr($postdata); //safe
                $newUDT->jsonDecodeAttr($postdata,["plcTag", "vars", "rev"],0); //safe
            
                // $newUDT->_Attr['plcTag']['name'] = GenerateRandomString(8);
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
                    $sqlInsertStr.= "'".$v."'"; //=> Important: surround by the single quotes..!
                    if(next($ser))
                    {
                        $sqlInsertStr.= ", "; // add "," if it's not the last element
                    }
                }
                $sqlInsertStr.= ");";

                if($this->isInitialized())
                {
                    $this->_dbDrv->dbExQuery($sqlInsertStr);
                }
        
                //if query success
                return $newUDT->jsonEncodeAttr(0);
            }

        }

        public
        function __u()
        {
            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $newUDT = new UDT(); //init a new OBJ
                $newUDT->jsonDecodeAttr($postdata,["plcTag", "ident", "rev", "vars"],0); //safe
                
                $ser = array();

                $sqlInsertStr = "UPDATE ". self::TABLE_UDT . " SET ";
                foreach ($this->_arrNode as $k => $v) 
                {
                    $ser[$v] = $newUDT->serializeAttrNode($v);
                    $sqlInsertStr.= $k;
                    $sqlInsertStr.= " = ";
                    $sqlInsertStr.= "'".$ser[$v]."'"; //=> Important: surround by the single quotes..!
                    if(next($this->_arrNode))
                    {
                        $sqlInsertStr.= ", "; // add "," if it's not the last element
                    }
                }
                $sqlInsertStr.= " WHERE ";
                $sqlInsertStr.= "idx = ";
                $sqlInsertStr.= $newUDT->getAttr_RowIdx();
                $sqlInsertStr.= ";";

                if($this->isInitialized())
                {
                    $this->_dbDrv->dbExQuery($sqlInsertStr);
                    $this->_dbDrv->dbGC(); /** Garbage collect (Vacuum) */
                }
        
                //if query success
                return $newUDT->jsonEncodeAttr(0);
            }

        }

        public
        function __d()
        {
            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $delUDT = new UDT(); //init a new OBJ
                $delUDT->jsonDecodeAttr($postdata,["plcTag", "ident", "rev"],0); //safe
                
                $sqlInsertStr = "DELETE FROM ". self::TABLE_UDT . " ";
                $sqlInsertStr.= " WHERE ";
                $sqlInsertStr.= "idx = ";
                $sqlInsertStr.= $delUDT->getAttr_RowIdx();
                $sqlInsertStr.= ";";

                if($this->isInitialized())
                {
                    $this->_dbDrv->dbExQuery($sqlInsertStr);
                    $this->_dbDrv->dbGC(); /** Garbage collect (Vacuum) */
                }
        
                /*if query success return the from end with this object:
                for further message or printing*/
                return $delUDT->jsonEncodeAttr(0);
            }
        }
    }

?>
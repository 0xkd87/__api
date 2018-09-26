<?php
    include('./../defs/httpHeaders.php');

    include_once('./../cl.dbDriver.php');
    include_once('./../defs/cl.prj.php');

    include_once('./../services/service.sqlTable.php');

    include_once('./../services/service.pathProvider.php');

    class drvPrj
    {
        const DB = "projects";
        const DB_FILE_EXT = ".prjDB";
        const TABLE_ACTIVE_PRJ = "active";
        private $PATH;

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
            $p = new PRJ();
            // $p->initDir();
            $this->_arrNode = $p->getAttrNodeNamesAsArray(); //Node name array is populated
            $x = new sqlTable(self::TABLE_ACTIVE_PRJ);
            foreach ($this->_arrNode as $k => $v) 
            {
                $x->addField( $v,$x::FIELDTYPE_SERIALIZED_OBJ);
            }
            $x->addField( "fs",$x::FIELDTYPE_SERIALIZED_OBJ);



            $this->_dbDrv->initTable($x->getSqlString($x::OP_CREATE));
            

        
        }

        public
        function __construct()
        {
            $this->PATH = ((new pathProvider("projects"))->buildPath());

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
                $sqlStr = "SELECT * FROM ". self::TABLE_ACTIVE_PRJ;
                if($getSorted === true)
                {
                    $sqlStr.= " ORDER BY idx DESC";
                }
                $results = $this->_dbDrv->dbQuery($sqlStr);
                
                
                while($r = $results->fetchArray())
                {
                    $c = new PRJ();
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
        function __c(
            $TableName = self::TABLE_ACTIVE_PRJ // Table name where new object is to be inserted (Default = Active list)
            )
        {

            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $new = new PRJ(); //init a new OBJ

                // file system operations - Create dir/folders and set path
          



                $new->jsonDecodeAttr($postdata,["prj","rev"],0); //safe
                $new->initDir();


                $ser = array();

                $sqlInsertStr = "INSERT INTO ". self::TABLE_ACTIVE_PRJ . " (";

                $this->_arrNode = $new->getAttrNodeNamesAsArray();

                foreach ($this->_arrNode as $k => $v) 
                {
                    $ser[$v] = $new->serializeAttrNode($v);
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
        


                $pp = "projects/" . $new->get_DirName();
                (new pathProvider($pp))->buildPath($new->get_subDirStruct());
                //if query success
                return $new->jsonEncodeAttr(0);
            }

        }

        /** 
         * Update / Modify the object posted by client
         */
        public
        function __u()
        {
            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $new = new PRJ(); //init a new OBJ
                $new->jsonDecodeAttr($postdata,["prj", "ident", "rev"],0); //safe
                $ser = array();

                $sqlInsertStr = "UPDATE ". self::TABLE_ACTIVE_PRJ . " SET ";
                foreach ($this->_arrNode as $k => $v) 
                {
                    $ser[$v] = $new->serializeAttrNode($v);
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
                $sqlInsertStr.= $new->getAttr_RowIdx();
                $sqlInsertStr.= ";";

                if($this->isInitialized())
                {
                    $this->_dbDrv->dbExQuery($sqlInsertStr);
                    $this->_dbDrv->dbGC(); /** Garbage collect (Vacuum) */
                }
        
                //if query success
                return $new->jsonEncodeAttr(0);
            }

        }

        /** 
         * DELETE the existing object
         * Delete it from the active list and move it to the obsolete list
         */
        public
        function __d(bool $moveToObsolete = true)
        {
            $postdata = file_get_contents("php://input");
            if($postdata)
            {
                $del = new PRJ(); //init a new OBJ
                $del->jsonDecodeAttr($postdata,["prj", "ident", "rev"],0); //safe
                
                $sqlInsertStr = "DELETE FROM ". self::TABLE_ACTIVE_PRJ . " ";
                $sqlInsertStr.= " WHERE ";
                $sqlInsertStr.= "idx = ";
                $sqlInsertStr.= $del->getAttr_RowIdx();
                $sqlInsertStr.= ";";

                if($this->isInitialized())
                {
                    $this->_dbDrv->dbExQuery($sqlInsertStr);
                    $this->_dbDrv->dbGC(); /** Garbage collect (Vacuum) */
                }
        
                /*if query success return the from end with this object:
                for further message or printing*/
                return $del->jsonEncodeAttr(0);
            }
        }
    }

?>
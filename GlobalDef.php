
<?php
//Path includes

include_once('CommonUtil.php');

/*Folder Names - in plain text */
define("DIRNAME__DATA_ROOT",GenerateSHA1("_Data",8));
define("PATH__DATA_ROOT", $_SERVER['DOCUMENT_ROOT'] .DIRECTORY_SEPARATOR. DIRNAME__DATA_ROOT .DIRECTORY_SEPARATOR);


/*LibUDT Databse Directory*/
define("DIRNAME__LIBUDT_ROOT",GenerateSHA1("LibUDT",8));
/*User created Projects*/
define("DIRNAME__PROJECT_ROOT",GenerateSHA1("Projects",8));
define("DIRNAME__TEMP",GenerateSHA1("WebTemp",24));


/*Functions to retrive relative Path*/
function _GET_DIRPATH__DataRoot($ScriptLocation,$_DIR = DOC_ROOT_ABSOLUTE)
{
  /*
  $dirpath = _GetRelativePath(__DIR__,$_DIR) . PATH__DATA_ROOT . DIRNAME__DATA_ROOT;
  if(!file_exists($dirpath))
  {
    mkdir($dirpath,0777,true);
  }
  */
  return  _GetRelativePath($ScriptLocation,$_DIR).PATH__DATA_ROOT.DIRNAME__DATA_ROOT.DIRECTORY_SEPARATOR;
}

function __GET_DIRPATH($getdir,$CallingScriptLocation,$_DOCROOT = DOC_ROOT_ABSOLUTE)
{

  /*
  $dirpath = _GET_DIRPATH__DataRoot(__DIR__,$_DOCROOT).$getdir;

//create the directory if it doesn't exist yet
  if(!file_exists($dirpath))
  {
    mkdir($dirpath,0777,true);
  }
*/
  return  _GET_DIRPATH__DataRoot($CallingScriptLocation,$_DOCROOT).$getdir.DIRECTORY_SEPARATOR;
}

function GET_DIRPATH_LibUDT_ROOT($ScriptLocation,$_DOCROOT = DOC_ROOT_ABSOLUTE)
{

 // return (__GET_DIRPATH(DIRNAME__LIBUDT_ROOT,$ScriptLocation,$_DOCROOT));

 
}

function GET_DIRPATH_Projects_ROOT($ScriptLocation,$_DOCROOT = DOC_ROOT_ABSOLUTE)
{
  return (__GET_DIRPATH(DIRNAME__PROJECT_ROOT,$ScriptLocation,$_DOCROOT));
}
function GET_DIRPATH_TEMP($ScriptLocation,$_DOCROOT = DOC_ROOT_ABSOLUTE)
{
  return (__GET_DIRPATH(DIRNAME__TEMP,$ScriptLocation,$_DOCROOT));
}
function GET_DIRPATH_LIB_ROOT($ScriptLocation,$_DOCROOT = DOC_ROOT_ABSOLUTE)
{
  $libPath = _GetRelativePath($ScriptLocation,$_DOCROOT);
  $libPath = "../" . $libPath;
  $libPath = $libPath . "/exLib" . DIRECTORY_SEPARATOR;

  return $libPath;
}

/*Return Values/ Results*/
$ResultValues_ =  array
(
  "SUCCESS" => 0,
  "ERROR_CREATION" => -1,
  "OBJECT_EXISTING" => 2
 );
define("RESULT",$ResultValues_);

?>

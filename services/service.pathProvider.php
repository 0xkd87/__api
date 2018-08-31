
<?php
//Path includes

// include_once('CommonUtil.php');

// /*Folder Names - in plain text */
// define("DIRNAME__DATA_ROOT",GenerateSHA1("_Data",8));
// define("PATH__DATA_ROOT", $_SERVER['DOCUMENT_ROOT'] .DIRECTORY_SEPARATOR. DIRNAME__DATA_ROOT .DIRECTORY_SEPARATOR);


// /*LibUDT Databse Directory*/
// define("DIRNAME__LIBUDT_ROOT",GenerateSHA1("LibUDT",8));
// /*User created Projects*/
// define("DIRNAME__PROJECT_ROOT",GenerateSHA1("Projects",8));
// define("DIRNAME__TEMP",GenerateSHA1("WebTemp",24));



class pathProvider
{

  const HASH_LEN = 16;
  const STORAGE_ROOT = 'C:\Program Files (x86)\EasyPHP-Devserver-17\eds-www\\';
  const DIRNAME_DATA = 'data';
  private 
  $_dirName = array 
  (
    "data" => "data",
    "lib" => "lib",
    "lib.udt" => "lib.UDT",
    "lib.wiki" => "lib.Wiki",
    "prj" => "Projects",
    "temp" => "Temp",
    "upload" => "Upload"
  );

  private $_path = 'dumpDir';

  function __construct($path)
  {
    $this->_path = $path;
  }

  private
  function _hash(string $dir)
  {
    if($dir!=='')
    {
      return substr(sha1($dir), 0, self::HASH_LEN);
    }
  }

  /**
   * $path - path in form of "x/y/z"
   */
  public
  function buildPath()
  {
    $p = $this->_path;
    $dirArr = explode("/", $p);
    $dirPath = self::STORAGE_ROOT .DIRECTORY_SEPARATOR. $this->_hash(self::DIRNAME_DATA). DIRECTORY_SEPARATOR;

    foreach ($dirArr as $dir) 
    {
        $dirPath.= $this->_hash($dir);
        if(next($dirArr))
        {
            $dirPath.= DIRECTORY_SEPARATOR; // add "/" if it's not the last element
        }
    }

    // make dir path, if does not exist
    $this->_mkDir($dirPath);

    return ($dirPath);
  }

  private 
  function _mkDir($FullPathToNewDir)
  {
    if(!file_exists($FullPathToNewDir))
    {
      if(mkdir($FullPathToNewDir,0777,true))
      {
        return 0; /*Successfully Added*/
      }
      else
      {
        return -1;
      }
    }
    else
    {
        return 1;
    }

  }
}


?>

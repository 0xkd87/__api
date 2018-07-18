
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



class pathProvider
{

  const HASH_LEN = 8;
  const DATA_ROOT = 'C:\Program Files (x86)\EasyPHP-Devserver-17\eds-www\\';
  private 
  $dirName = array 
  (
    "db" => "_db",
    "lib" => "lib",
    "lib.udt" => "lib.UDT",
    "lib.wiki" => "lib.Wiki",
    "prj" => "Projects",
    "temp" => "Temp",
    "upload" => "Upload"
  );

  function construct()
  {

  }

  private
  function _hash(string $dir)
  {
    if($dir!=='')
    {
      return substr(sha1($dir), 0, $this->HASH_LEN);
    }
  }

  public function getDirPath()
  {

  }
}


?>

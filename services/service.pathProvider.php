
<?php

 include_once('./../defs/interface.constants.php');




class pathProvider implements RETURN_CODE
{

  const HASH_LEN = 16;
  const STORAGE_ROOT = 'C:\Program Files (x86)\EasyPHP-Devserver-17\eds-www\\';
  const DIRNAME_DATA = 'data';


  private $_path = 'dumpDir';

  function __construct($location)
  {
    $this->_path = $location;
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


    /** 
     * create sub-dir structure
     */
    // $dArr = [];

    // $dArr["f1"] = "F1";
    // $dArr["f2"] = "F2";
    // $dArr["f3"] = ["F31","F32"];

    // $this->__mkSubDirStruct($dArr,$dirPath);

    return ($dirPath);
  }

  private 
  function _mkDir($fullPath)
  {
    if(!file_exists($fullPath))
    {
      if(mkdir($fullPath,0777,true)) // mkdir = system call
      {
        return (self::RETURN_SUCCESS); /*Successfully Added*/
      }
      else
      {
        return (self::RETURN_ERROR); // Filed to create this dir
      }
    }
    else
    {
        return (self::RETURN_FILE_EXISTS); // existing dir
    }

  }

  private 
  function __mkSubDirStruct($dirArray,$dirPath)
  {
      $created = 0;
      $failed = 0;
      
      foreach ($dirArray as $i=>$dir) 
      {
          if(is_array($dir))
          {
              $d = $dirPath.DIRECTORY_SEPARATOR.$i;
              if(!file_exists($d))
              {
                  if($this->_mkDir($d) === self::RETURN_SUCCESS)
                  {
                      if(file_exists($d))
                      {
                          // echo "[+] Dir With sub Dir Created:" . $d. "</br>" ;
                          $this->__mkSubDirStruct($dir,$d);
                      }
                  }
              }
          }
          else
          {
              $d = $dirPath.DIRECTORY_SEPARATOR.$dir;
              if(!file_exists($d))
              {
                  if($this->_mkDir($d) === self::RETURN_SUCCESS)
                  {
                      if(file_exists($d))
                      {
                          // echo "Dir Created:" . $d. "</br>" ;
                      }
                  }
              }

          }
      }

      
  }
}


?>

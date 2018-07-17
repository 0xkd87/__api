
<?php
include_once(__DIR__. "\info.php");

/*
[Random String Generator]
Generate a random string of a desired length
The function uses random number generation module and uses the result to creat the SH1 hash of that string.
The generated hash is then stripped away by the length specified by the function argument
*/
function GenerateRandomString($len = 8)
{
    return substr(sha1(rand()), 0, $len);
}
function GenerateSHA1($Text,$len = 40)
{
    return substr(sha1($Text),0,$len);
}
/*
function
*/
function CreateDir($path)
{

}

function GetScriptName()
{
  return "\"". pathinfo(__FILE__,PATHINFO_BASENAME) . "\"";
}

function phpLineBreak()
{
  echo ("<br>");
}

/* credits: php webpage*/
function _GetRelativePath($start_dir, $final_dir)
{
        //
        $firstPathParts = explode(DIRECTORY_SEPARATOR, $start_dir);
        $secondPathParts = explode(DIRECTORY_SEPARATOR, $final_dir);
        //
        $sameCounter = 0;
        for($i = 0; $i < min( count($firstPathParts), count($secondPathParts) ); $i++) {
            if( strtolower($firstPathParts[$i]) !== strtolower($secondPathParts[$i]) ) {
                break;
            }
            $sameCounter++;
        }
        if( $sameCounter == 0 ) {
            return $final_dir;
        }
        //
        $newPath = '';
        for($i = $sameCounter; $i < count($firstPathParts); $i++) {
            if( $i > $sameCounter ) {
                $newPath .= DIRECTORY_SEPARATOR;
            }
            $newPath .= "..";
        }
        if( count($newPath) == 0 ) {
            $newPath = ".";
        }
        for($i = $sameCounter; $i < count($secondPathParts); $i++) {
            $newPath .= DIRECTORY_SEPARATOR;
            $newPath .= $secondPathParts[$i];
        }
        //
        return $newPath;
    }

/*Get all the Sub-Folders in a given Folder..!*/
function GetAllSubDir($path)
{
    $result = [];
    $FolderScan = glob($path . '/*');
    foreach($FolderScan as $item)
    {
      if(is_dir($item))
          $result[basename($item)] = GetAllSubDir($item);
      else
          $result[] = basename($item);
    }
    return $result;
}

function __GetFolderContentAsNodeArr($path,$pid=0)
{
    $result = [];
    $FolderScan = glob($path . '/*');
    foreach($FolderScan as $item)
    {
      if(is_dir($item))
          $result[basename($item)] = GetAllSubDir($item);
      else
          $result[] = basename($item);
    }
    return $result;
}

function MakeDir($FullPathToNewDir)
{
  if(!file_exists($FullPathToNewDir))
  {
    if(mkdir($FullPathToNewDir,0777,true))
    {
      return RESULT["SUCCESS"]; /*Successfully Added*/
    }
    else
    {
      return RESULT["ERROR_CREATION"];
    }
  }
  else
  {
      return RESULT["OBJECT_EXISTING"];
  }

}
function __dTreeCreateRecursiveDirNode($dArr,$d="d",$id,$pid=0)
{
    $html = "";
    $_id = $id;
    $_pid = $pid;
    foreach($dArr as $dir)
    {
        if(is_array($dArr))
        {

        }
        else
        {
            $html .= $d .".add(0,-1,'UDT Categories');";
        }
    }

    return $html;
}

function dTreeCreateDirStructure($directory,$d="d")
{
    $html = "";
    $html = '<script type="text/javascript" >';
    $html .= $d . "= new dTree('" . $d."');";

    $html .= $d .".add(0,-1,'UDT Categories');";
   // $html .= __dTreeCreateRecursiveDirNode($directory,$d);

    $html .= "document.write(" . $d . ");";
    $html .= '</script>';

    return $html;
}
function createTree($directory)
{

    $html = "<ul>";
    foreach($directory as $keyDirectory => $eachDirectory)
    {
        if(is_array($eachDirectory))
        {
            $html .= "<li class='closed' style = 'display:block'><span class='folder'>" . $keyDirectory . "</span> ";
            $html .= createTree($eachDirectory);
            $html .=  "</li><br>";
        }
        else
        {
            $html .= "<li><span class='file'>" . $eachDirectory . "</span></li>";
        }
    }
    $html .= "</ul>";


    $html .="<br><br>";
//PHP dTree 



    return $html;
}

?>

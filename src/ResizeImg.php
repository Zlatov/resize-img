<?php
namespace Zlatov;

use ResizeImg\ResizeImg_Errors as Err;
use ResizeImg\ResizeImg_Exception as Exc;

class ResizeImg
{
  // Properties for constructor
  private $pathToFile;
  private $pathInfo;
  private $source;
  private $sourceWidth;
  private $sourceHeight;
  private $validTypes = ["jpg", "jpeg", "png"];

  // Params for resize
  private $width;
  private $height;
  private $kind;
  private $subFolder;
  private $nameSufix;

  // Some prop
  private $pathToDestinFile;
  private $destinPath;
  private $destinName;

  // For display in browser
  public $imgTag;

  public function __construct($pathToFile)
  {
    $this->pathToFile = $pathToFile;
    $this->pathInfo = pathinfo($this->pathToFile);
    
    if (!in_array(mb_strtolower($this->pathInfo['extension']), $this->validTypes))
    {
      throw new Exc(Err::INVALIDFILEEXT,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
    }
    if (filesize($pathToFile) > 9 * 1024 * 1024)
    {
      throw new Exc(Err::INVALIDFILESIZE,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
    }
    if (!list($sourceWidth, $sourceHeight) = getimagesize($pathToFile))
    {
      throw new Exc(Err::INVALIDIMGSIZE,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
    }
    else
    {
      $this->sourceWidth = $sourceWidth;
      $this->sourceHeight = $sourceHeight;
    }

    switch ($this->pathInfo['extension']) {
      case 'jpeg':
        $this->source = imagecreatefromjpeg($this->pathToFile);
        break;
      case 'jpg':
        $this->source = imagecreatefromjpeg($this->pathToFile);
        break;
      case 'gif':
        $this->source = imagecreatefromgif($this->pathToFile);
        break;
      case 'png':
        $this->source = imagecreatefrompng($this->pathToFile);
        break;
      case 'bmp':
        $this->source = imagecreatefromwbmp($this->pathToFile);
        break;
    }
  }

  public function resize($params)
  {
    foreach ($params as $var => $value)
    {
      $this->{'set'.ucfirst($var)}($value);
    }

    if ($this->subFolder) {
      $this->destinPath = $this->pathInfo['dirname'] . DIRECTORY_SEPARATOR . 'resize-img';
      if (!is_dir($this->destinPath))
        if (!mkdir($this->destinPath))
          throw new Exc(Err::INVALIDSUBFOLDER,[$this->destinPath]);
    } 
    else {
      $this->destinPath = $this->pathInfo['dirname'];
    }

    if ($this->nameSufix) {
      $this->destinName = self::translit($this->pathInfo['filename']).'-thumbnail';
    }else{
      $this->destinName = self::translit($this->pathInfo['filename']);
    }

    $this->pathToDestinFile = $this->destinPath . DIRECTORY_SEPARATOR . $this->destinName . '.jpg';

    if (!imagejpeg($this->sourceToDestination(), $this->pathToDestinFile, 100))
    {
      throw new Exc(Err::INVALIDSAVE);
    }
    $this->returnImgTag();
    return $this;
  }

  public function __call($method_name, $argument)
  {
    $args = preg_split('/(?<=\w)(?=[A-Z])/', $method_name);
    $action = array_shift($args);
    $property_name = strtolower(implode('_', $args));
 
    switch ($action)
    {
      case 'get':
        return isset($this->$property_name) ? $this->$property_name : null;
 
      case 'set':
        $this->$property_name = $argument[0];
        return $this;
    }
  }

  public function setHeight($value)
  {
    if (is_int((int)$value)&&($value>10)&&($value<2000))
    {
      $this->height = $value;
    }
    else
    {
      throw new Exc(Err::INVALIDSIZE);
    }
  }

  public function setWidth($value)
  {
    if (is_int((int)$value)&&($value>10)&&($value<2000))
    {
      $this->width = $value;
    }
    else
    {
      throw new Exc(Err::INVALIDSIZE);
    }
  }

  public function setKind($value)
  {
    if (is_string($value)&&in_array($value, ['cover','contain'])) {
      $this->kind = $value;
    }
    else
    {
      throw new Exc(Err::INVALIDTYPE);
    }
  }

  public function setNameSufix($value)
  {
    if (is_bool($value))
    {
      $this->nameSufix = $value;
    }
    else
    {
      throw new Exc(Err::INVALIDNAMESUFIX);
    }
  }

  public function setSubFolder($value)
  {
    if (is_bool($value))
    {
      $this->subFolder = $value;
    }
    else
    {
      throw new Exc(Err::INVALIDTYPEPATH);
    }
  }

  public function sourceToDestination()
  {
    $source_ratio = $this->sourceWidth / $this->sourceHeight;
    $destination_ratio = $this->width / $this->height;
    
    $frame_width = $this->sourceWidth;
    $frame_height = $this->sourceHeight;
    $frame_x = $frame_y = 0;

    switch ($this->kind) {
      case 'cover':
        if ($source_ratio > $destination_ratio) {
          $frame_width = floor($this->width * $this->sourceHeight / $this->height);
          $frame_x = floor($this->sourceWidth / 2 - $frame_width / 2);
        } 
        else {
          $frame_height = floor($this->height * $this->sourceWidth / $this->width);
          $frame_y = floor($this->sourceHeight / 2 - $frame_height / 2);
        }
        break;

      case 'contain':
        if ($source_ratio > $destination_ratio) {
          $this->height = floor($this->sourceHeight * $this->width / $this->sourceWidth);
        } 
        else {
          $this->width = floor($this->sourceWidth * $this->height / $this->sourceHeight);
        }
        break;
    }
    
    $destination = imagecreatetruecolor($this->width, $this->height);
    imagefill($destination, 0, 0, imagecolorallocate($destination, 255, 255, 255));
    imagecopyresampled($destination, $this->source, 0, 0, $frame_x, $frame_y, $this->width, $this->height, $frame_width, $frame_height);
    return $destination;
  }

  public function returnImgTag()
  {
    $path = $this->destinPath.DIRECTORY_SEPARATOR;
    if (DIRECTORY_SEPARATOR=='\\') {
      $path = str_replace('\\','/',$path);
      $path = substr($path,strlen($_SERVER['DOCUMENT_ROOT']));
    }
    $this->imgTag = sprintf('<img src="%1$s%2$s%3$s">', $path, $this->destinName, '.jpg');
  }

  public static function translit($text) {
    if (DIRECTORY_SEPARATOR == '\\') {
      $text = iconv('windows-1251', 'UTF-8', $text);
    }
    $text = mb_strtolower($text, 'UTF-8');
    $replace = array(
      "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ё" => "e", "ж" => "j", "з" => "z", "и" => "i", 
      "й" => "y", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", 
      "у" => "u", "ф" => "f", "х" => "h", "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "", "ы" => "y", "ь" => "", 
      "э" => "e", "ю" => "yu", "я" => "ya", 
      " " => "-"
    );
    $text = strtr($text, $replace);
    $text = preg_replace('/[^a-z0-9_-]/', '', $text);
    $text = preg_replace('/[-]{2,}/', '-', $text);
    $text = preg_replace('/[_]{2,}/', '_', $text);
    $text = trim($text, '-_');
    return $text;
  }
}

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
  private $scaleType;           // Вместить в новый размер или покрыть
  private $destination = false; // Путь к новому месту назначения или false
  private $nameSuffix = '';
  private $namePrefix = '';

  // Some prop
  private $pathToDestinFile;
  private $destinPath;
  private $destinName;

  public function __construct($pathToFile) {
    $this->pathToFile = $pathToFile;
    $this->pathInfo = pathinfo($this->pathToFile);
    if (!in_array(mb_strtolower($this->pathInfo['extension']), $this->validTypes)) {
      throw new Exc(Err::INVALIDFILEEXT,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
    }
    if (filesize($pathToFile) > 9 * 1024 * 1024) {
      throw new Exc(Err::INVALIDFILESIZE,[$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
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
    if (!list($this->sourceWidth, $this->sourceHeight) = getimagesize($pathToFile)) {
      throw new Exc(Err::INVALIDIMGSIZE, [$this->pathInfo['filename'] . '.' . $this->pathInfo['extension']]);
    }
  }

  public function resize($params) {
    foreach ($params as $var => $value) {
      $this->{'set' . ucfirst($var)}($value);
    }
    if ($this->destination) {
      $this->destinPath = $this->destination;
    } else {
      $this->destinPath = $this->pathInfo['dirname'];
    }

    $this->destinName = $this->namePrefix . $this->pathInfo['filename'] . $this->nameSuffix . '.jpg';

    $this->pathToDestinFile = $this->destinPath . DIRECTORY_SEPARATOR . $this->destinName;

    if (!imagejpeg($this->sourceToDestination(), $this->pathToDestinFile, 100)) {
      throw new Exc(Err::INVALIDSAVE);
    }
    return [
      'file_path' => $this->pathToDestinFile,
      'dir_path' => $this->destinPath,
      'file_name' => $this->destinName,
      'width' => $this->width,
      'height' => $this->height,
      'src' => substr($this->pathToDestinFile, mb_strlen($_SERVER['DOCUMENT_ROOT'])),
    ];
  }

  public function __call($method_name, $argument) {
    $args = preg_split('/(?<=\w)(?=[A-Z])/', $method_name);
    $action = array_shift($args);
    $property_name = strtolower(implode('_', $args));
    switch ($action) {
      case 'get':
        return isset($this->$property_name) ? $this->$property_name : null;
      case 'set':
        $this->$property_name = $argument[0];
        return $this;
    }
  }

  private function setHeight($value) {
    if (is_int((int)$value)&&($value>10)&&($value<2000)) {
      $this->height = $value;
    } else {
      throw new Exc(Err::INVALIDSIZE);
    }
  }

  private function setWidth($value) {
    if (is_int((int)$value)&&($value>10)&&($value<2000)) {
      $this->width = $value;
    } else {
      throw new Exc(Err::INVALIDSIZE);
    }
  }

  private function setScaleType($value) {
    if (is_string($value) && in_array($value, ['cover','contain'])) {
      $this->scaleType = $value;
    } else {
      throw new Exc(Err::INVALIDTYPE);
    }
  }

  public function setNameSuffix($value) {
    if (is_string($value)) {
      $this->nameSuffix = $value;
    } else {
      throw new Exc(Err::INVALIDNAMESUFFIX);
    }
  }

  public function setNamePrefix($value) {
    if (is_string($value)) {
      $this->namePrefix = $value;
    } else {
      throw new Exc(Err::INVALIDNAMEPREFIX);
    }
  }

  public function setDestination($value) {
    if (is_string($value) && !is_dir($value)) {
      if (!mkdir($value)) {
        throw new Exc(Err::INVALIDSUBFOLDER,[$this->destinPath]);
      }
    }
    if (
      is_bool($value) && $value == false ||
      is_string($value) && is_dir($value)
    ) {
      $this->destination = $value;
    } else {
      throw new Exc(Err::INVALIDTYPEPATH);
    }
  }

  private function sourceToDestination() {
    $source_ratio = $this->sourceWidth / $this->sourceHeight;
    $destination_ratio = $this->width / $this->height;

    $frame_width = $this->sourceWidth;
    $frame_height = $this->sourceHeight;
    $frame_x = $frame_y = 0;

    switch ($this->scaleType) {
      case 'cover':
        if ($source_ratio > $destination_ratio) {
          $frame_width = floor($this->width * $this->sourceHeight / $this->height);
          $frame_x = floor($this->sourceWidth / 2 - $frame_width / 2);
        } else {
          $frame_height = floor($this->height * $this->sourceWidth / $this->width);
          $frame_y = floor($this->sourceHeight / 2 - $frame_height / 2);
        }
        break;

      case 'contain':
        if ($source_ratio > $destination_ratio) {
          $this->height = floor($this->sourceHeight * $this->width / $this->sourceWidth);
        } else {
          $this->width = floor($this->sourceWidth * $this->height / $this->sourceHeight);
        }
        break;
    }

    $destination = imagecreatetruecolor($this->width, $this->height);
    imagefill($destination, 0, 0, imagecolorallocate($destination, 255, 255, 255));
    imagecopyresampled($destination, $this->source, 0, 0, $frame_x, $frame_y, $this->width, $this->height, $frame_width, $frame_height);
    return $destination;
  }

}

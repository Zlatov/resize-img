<?php

class ResizeImg_Errors
{
  const INVALIDNAMESUFIX = 1001;
  const INVALIDSIZE = 1002;
  const INVALIDTYPE = 1003;
  const INVALIDTYPEPATH = 1004;
  const INVALIDFILEEXT = 1005;
  const INVALIDFILESIZE = 1006;
  const INVALIDIMGSIZE = 1007;
  const INVALIDSUBFOLDER = 1008;
  const INVALIDSAVE = 1009;

  public static function getErrorMessage($code, $options = []) {
    switch ($code) {

      case self::INVALIDNAMESUFIX:
        return 'The parameter is incorrect for the property nameSufix.';
        break;

      case self::INVALIDSIZE:
        return 'All measurements should be in the range 10 < … < 2000.';
        break;

      case self::INVALIDTYPE:
        return 'Unable to determine the kind of resizing.';
        break;

      case self::INVALIDTYPEPATH:
        return 'Unable to determine the desired folder.';
        break;

      case self::INVALIDFILEEXT:
        return sprintf("Unfavourable extension of file %s.", $options[0]);
        break;

      case self::INVALIDFILESIZE:
        return sprintf("Large file size %s.", $options[0]);
        break;

      case self::INVALIDIMGSIZE:
        return sprintf("Do not define the size of the image %s.", $options[0]);
        break;

      case self::INVALIDSUBFOLDER:
        return sprintf("Unable to create subdirectory %s.", $options[0]);
        break;

      case self::INVALIDSAVE:
        return sprintf("Unable to save image.");
        break;

      case self::UNEXPECTEDERROR:
      default:
        return 'Unknown error!';
        break;
    }
  }
}

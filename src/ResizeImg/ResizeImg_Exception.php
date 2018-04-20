<?php

class ResizeImg_Exception extends Exception
{
  public function __construct($error_code)
  {
    parent::__construct(ResizeImgErrors::getErrorMessage($error_code), $error_code);
  }
}

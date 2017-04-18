<?php


class InvalidFormatException extends Exception {

  public function errorMessage() {

    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile() .'. the format of the argument is invalid <b>'.$this->getMessage().'</b> ';
    
    return $errorMsg;
  }
}


?>
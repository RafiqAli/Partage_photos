<?php


class InvalidFormatException extends Exception {

  public function errorMessage() {

    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile() .': <b>'.$this->getMessage().'</b> the format of the argument is invalid';
    
    return $errorMsg;
  }
}


?>
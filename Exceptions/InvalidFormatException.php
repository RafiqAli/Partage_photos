<?php


class InvalidFormatException extends Exception {

	const message = "the format of the argument is invalid";

  public function errorMessage() {

    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile() .self::message.'<b>'.$this->getMessage().'</b> ';
    
    return $errorMsg;
  }


  public function simpleError()
  {
  		$simpleError = self::message . " : ".$this->getMessage()."\n";

  		return $simpleError;
  }
}

?>
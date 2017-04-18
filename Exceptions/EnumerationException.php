<?php


class EnumerationException extends Exception {

	const message = "Enumeration standards has not been respected";

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
<?php


class NullOrUnsetException extends Exception {

	const message = "the argument is either null or it has not been set.";

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
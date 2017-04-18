<?php


class ServerFileOperationException extends Exception {

	const message = "an error occured on server while executing the operation";

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
<?php


class NotFoundException extends Exception {

	 const message = "We couldn't any records for your request.";

  public function errorMessage() {

    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile().' '.$message.''.$this->getMessage().'</b> ';
    
    return $errorMsg;
  }

  public function simpleError()
  {
  		$simpleError = self::message . " : ".$this->getMessage()."\n";

  		return $simpleError;
  }

}


?>
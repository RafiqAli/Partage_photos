<?php 

class Regex {


	const NAME     = "[A-Za-z]+";

	const EMAIL    = "^[^@]+@[^@]+\.[^@]+$";

	const PHONE    = "/^[0-9()-]+$";

	const ONECHAR  = "[a-zA-Z]{1}";

	const AGE      = "\d{1,3}"; 

	const TEXT     = "[a-zA-Z]+";

	const TIME     = "(\d{1,2}:\d{1,2})";

	const DIGITS   = "\d+";

    const FLOAT    = "[+-]?([0-9]*[.])?[0-9]+";

    const RICHTEXT = '[A-Za-z0-9]{2,1000}';

	public static function parseConst(string $string) {


		$arg = strtoupper($string);

		switch ($arg) {

		case "NAME"    : return Regex::NAME   ;

		case "EMAIL"   : return Regex::EMAIL  ;

		case "PHONE"   : return Regex::PHONE  ;

		case "ONECHAR" : return Regex::ONECHAR;

		case "AGE"     : return Regex::AGE    ;

		case "TEXT"   : return Regex::TEXT    ;

		case "TIME"    : return Regex::TIME   ;

		case "DIGITS"  : return Regex::DIGITS ;

        case "FLOAT"   : return Regex::FLOAT  ;

		default        : return ".+";


		}

	}


	public static function definite_entries(array $values) {

		return implode("|",$values);

	}


	public static function validate($pattern,$raw_text) {

		if (!preg_match('/'.$pattern.'/',$raw_text))
		{
		 	return false;
		}
		else
		{
		 	return true;
		}
	}

}


?>

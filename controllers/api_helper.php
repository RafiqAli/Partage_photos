<?php

require_once($_SERVER['DOCUMENT_ROOT']."/core/Request.php");
require_once($_SERVER['DOCUMENT_ROOT']."/Exceptions/UnAuthorizedAccessException.php");


class APIHelper
{
	public static function gain_access($login,$api_key)
	{
		$result = self::query("SELECT COUNT(login) AS 'Exists' FROM users WHERE login='$login' AND api_key='$api_key'");

		$exists = $result['Exists'];
		if($exists == 0)
		{
			throw new UnAuthorizedAccessException("this APIKey is invalid");
		}
	}

	public static function query($sql)
	{
		try
		{
			return Request::execute($sql)[0];
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return null;
		}
	}
}


?>
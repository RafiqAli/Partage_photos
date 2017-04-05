<?php


class Validation {


	public static $array;
	public static $fields;
	public static $keys;


	public static function init($fields,$array)
	{
		self::$fields = $fields;
		self::$array  = $array;
		self::$keys = array_keys($array);

	}

	public static function close()
	{
		self::$fields = null;
		self::$array  = null;
		self::$keys   = null;
	}

	public static function is_null($value)
	{

		if($value == null)
		{
			return "the identifer .$value. is null";
		}
		else
		{
			return "";
		}

	}


	public static function is_undefined($key)
	{

        if(match($key,self::$keys))
        {
        	return "";
        }
        else
        {
        	return "the value of the identifier ".$key." is undefined.";
        }

	}

	public static function is_empty($value)
	{
		if(empty($value))
		{
			return "the value pf that identifer is empty";
		}
		else 
		{
			return "";
		}
	}




	public static function validate($fields,$array)
    {

    	self::init($fields,$array);


        $fields_state = [];

        $keys = array_keys($array);

        foreach ($array as $key => $value) {


                $fields_state[$key]['undefined'] = is_undefined($key);
                $fields_state[$key]['null']      = is_null($key);
                $fields_state[$key]['empty']     = is_empty($key); 
            
        }


            //if (match($key,$fields)) // make a list of boolean and indicators and return the elements that is missing. 
            // proceed with the same way with empty case.

        
    }



}




?>

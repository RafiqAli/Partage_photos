<?php 

/* Connects to a MySQL database using driver invocation */

class Connection {

    private static $_dbname    = "partage_photos";
    private static $_host      = "localhost";
    private static $_dsn       = "";
    private static $_user      = "root";
    private static $_password  = "";

    private static $connection;

    /**
     * Connects the $connection variable if 
     * not connected and returns it. 
     *
     * @returns the $connection variable
     */
    public static function getPDO() {

	    if(!self::isConnected()) self::connect();

	    return self::$connection;
        echo "string";
    }



    /**
     * Establishing a connection by creating a PDO instance
     * and returning it.
     *
     * @returns the $connection variable.
     */
    public static function connect() {

	    self::$_dsn = "mysql:dbname=".self::$_dbname.";host=".self::$_host;

	    try {

	    self::$connection = new PDO(self::$_dsn,self::$_user,self::$_password);

	    self::$connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	    } catch (PDOException $e) {

	    echo 'Connection Failed '. $e->getMessage();
	
	    }

	    return self::$connection;

    }


    // disconnect function
    public static function disconnect() {

	    self::$connection = null;
    }


    // check if connection exists
    public static function isConnected() {

	    return (self::$connection != null);
    }

}

?>

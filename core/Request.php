<?php 
require_once("enable_errors.php");
require_once("Connection.php");

/* 
 *
 */


class Request {

	private static $pdo;

    
    
    /**
     * Executes an SQL query.
     *
     * @param $query   : the string that contains the SQL instruction. 
     * @param $data    : the array that contains the mapping of values. null by
     *                   default in case of unprepared SQL queries.
     * @param $isFetsh : boolean that indicates if the SQL instruction is expecting
     *                   a return value or not e.g "INSERT","SELECT". the arguement 
     *                   is false by default.
     *
     * @returns a boolean indicating the state of the operation case $isFetsh == fasle 
     *          an associative array case $isFetsh == true or $data == null.
     */    
	public static function execute(string $query,array $data = null,bool $isFetch = false) {

		$statement =  Connection::getPDO()->prepare($query);

		if($data == null) {

			$statement->execute();

			return $statement->fetchAll(PDO::FETCH_ASSOC);
	
		}

		if($isFetch) {

			$statement->execute($data);

			return $statement->fetchAll(PDO::FETCH_ASSOC);
		
		} 

		return $statement->execute($data);
	}


    /* this function is a wrapper around the PDO
     * query function, that ensures of the connection
     * state before making the call.
     *
     * @param $query : the string that contains the
     *                 the SQL instruction. 
     */
	public static function query(string $query) {

		Connection::getPDO()->query($query);
	}

     public static function lastInsertId()
     {
          return Connection::getPDO()->lastInsertId();
     }


}


?>

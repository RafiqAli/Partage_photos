<?php 

/**
 * Examples of the usage of the execute function from the 
 * core/Request class.
 */


/**
 *   Example 1: SQL INSERT instruction 
 *   ==========
 *   $data   != null
 *   $isFetsh = false 
 */

    $query = "INSERT INTO table_name (one,two,three) VALUES (:one,:two,:three)";

    $data = array(
    ':titre'  => $one,
    ':heure'  => $two,
    ':three'  => $three
    );

    Request::execute($query,$data);

/**
 *   Example 2: SQL SELECT instruction
 *   ==========
 *   $data   != null
 *   $isFetsh = true 
 */


    $query = "SELECT * FROM admin_table WHERE user = :user AND pass = :pass;";

    $data = array(
				    ":user" => $_POST['user'],

				    ":pass" => sha1($_POST['pass']),

			    );

    $output = Request::execute($query,$data,true);

    print_r($output);
?>

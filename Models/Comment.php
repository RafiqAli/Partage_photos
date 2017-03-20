<?php 

require_once("../core/enable_errors.php");
require_once("../core/Request.php");
require_once("../core/Regex.php");

class Comment {

	public $id;
	public $content;
	public $photo_id;
	public $owner;


	public function __construct($id,$content,$photo_id,$owner) {

		$this->id = $id;
		$this->content = $content;
		$this->photo_id = $photo_id;
		$this->owner = $owner;
	}

	public static function all() {

		$list = [];

		$sql = "SELECT * FROM comments;";

		$comments = Request::execute($sql);

		if($comments != null)
		{

			foreach ($comments as $comment) {
				
				$list[] = new Comment($comment['id'],$comment['content'],$comment['photo_id'],$comment['owner']);
			}

		  	return  array('failed' => false, 'objects' => $list, 'error' => '');
	    }
	    else
	    {
	    	return array('failed' => true, 'error' => 'coudn\'t find comments on database');
	    } 
	}

	public static function find($id)
	{

      		if(Regex::validate(Regex::DIGITS,$id))
      		{

	      		$sql = "SELECT * FROM comments WHERE id=".$id;

	      		$comment = Request::execute($sql);

	      		$comment = $comment[0];

      			if($comment != null)
      			{

		    		$comment_instance = new Comment($comment['id'],$comment['content'],$comment['photo_id'],$comment['owner']);

		      		return array('failed' => false, 'object' => $comment_instance, 'error' => '');

	      		}
	      		else
	      		{
	      			return array('failed' => true, 'error' => 'we couldn\'t find a picture with this id value');
	      		}

	      	}
	      	else
	      	{
	      		return array('failed' => true, 'error' => 'please enter a numeric value for the id');
	      	}
	}

	public static function create($comment)
	{


		if(isset($comment->content)   &&  $comment->content   != null 
		&& isset($comment->photo_id)  &&  $comment->photo_id  != null
		&& isset($comment->owner)     &&  $comment->owner     != null)
		{
			$sql = "INSERT INTO comments (content,photo_id,owner) VALUES (:content,:photo_id,:owner)";

			$data = array('content'  => $comment->content,
						  'photo_id' => $comment->photo_id,
						  'owner'    => $comment->owner);

			Request::execute($sql,$data);

			return array('failed' => false, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' =>  "some values are not set or have null values");
		}

	}


	public static function update(string $content,$id)
	{

		if(Regex::validate(Regex::DIGITS,$id))
		{ 
			if(Regex::validate(Regex::RICHTEXT,$content))
			{

				$sql = "UPDATE comments SET content='".$content."' WHERE id=$id";

				Request::query($sql);

				return array('failed' => false, 'error' => '');
			}
			else
			{
				return array('failed' => true, 'error' => 'please enter valid content format.');
			}
		}
		else
		{
			return array('failed' => true, 'error' => 'please enter numeric id format.');
		}
	}




	public static function delete($id) {

		if(Regex::validate(Regex::DIGITS,$id))
		{

			$sql = "DELETE FROM comments WHERE id=$id";

			$output = Request::query($sql);

			return array('failed' => false, 'output' => $output, 'error' => '');
		}
		else
		{
			return array('failed' => true, 'error' => 'please enter a numeric value');
		}
	}




	public function __toString()
	{
		return "Comment : [content] => ".$this->content." [photo_id] => ".$this->photo_id." [owner] => ".$this->owner ."/n";
	}



}
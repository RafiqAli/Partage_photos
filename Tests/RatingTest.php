<?php

//use PHPUnit\Framework\TestCase;

require_once("PHPUnit/Framework/TestCase.php");

require_once("../Models/Rating.php");

class RatingTest extends PHPUnit_Framework_TestCase
{

	public  $photo_id;
	public  $owner;


	public function test_CreateMethod_WithArray_ReturnsArray()
	{

		// Execution path 1 : valid arguments

		$to_be_created_rating = Rating::create(array(
															'photo_id'     => 1,
															'owner'        => 'ali',
															'value'        => Rating::THREE_STARS,
															'description'  => 'description',
													  ));

		$rating_instance = new Rating(1,'ali',Rating::THREE_STARS,'description');

		$this->assertEquals($rating_instance,$to_be_created_rating['object']);
		$this->assertFalse($to_be_created_rating['failed']);
		$this->assertEmpty($to_be_created_rating['error']);

		// Execution path 2 : invalid arguments : name
		 
/*
		$invalid_name_rating = Rating::create(array(
															'name'        => '777',
															'description' => 'description',
													  ));

		$this->assertTrue($invalid_name_rating['failed']);
		$this->assertEquals('please check the format of your fields',$invalid_name_rating['error']);

		// Execution path 3 : invalid arguments : description
		
		$invalid_description_rating = Rating::create(array(
																	'name'        => 'name',
																	'description' => '@#%^&*&%',
															  ));

		$this->assertTrue($invalid_description_rating['failed']);
		$this->assertEquals('please check the format of your fields',$invalid_description_rating['error']);

		// Execution path 3 : invalid arguments : name & description

		$invalid_name_and_description_rating = Rating::create(array(
																	'name'        => '7777',
																	'description' => '$%^#@$%^&^%',
															  ));

		$this->assertTrue($invalid_name_and_description_rating['failed']);

		$this->assertEquals('please check the format of your fields',$invalid_name_and_description_rating['error']);	

*/
	}	


	public function test_findMethod_withId_ReturnsArray()
	{

		// Execution path 1 : Id exists.
		
		//self::$id = 1; 
		

		$rating  = Rating::find(2,'ali');

		$this->assertArrayHasKey('failed',$rating);
		$this->assertArrayHasKey('object',$rating);
		$this->assertArrayHasKey('error',$rating);

		$this->assertFalse($rating['failed']);
		$this->assertEmpty($rating['error']);


		// Execution path 2 : Id does not exist.

		$rating = Rating::find(9999,'someone');

		$this->assertArrayHasKey('failed',$rating);
		$this->assertArrayHasKey('error',$rating);

		$this->assertTrue($rating['failed']);
		$this->assertEquals('we couldn\'t find a rating with this id value',$rating['error']);

		// Execution path 3 : wrong argument format. 
		
		$rating = Rating::find('A',20);

		$this->assertArrayHasKey('failed',$rating);
		$this->assertArrayHasKey('error',$rating);

		$this->assertTrue($rating['failed']);
		$this->assertEquals('please enter a numeric value for the id',$rating['error']);
		 
	}


	public function test_allMethod_WithNull_ReturnsArray()
	{

		$all_categories = Rating::all();

		$this->assertFalse($all_categories['failed']);

		$this->assertCount(count($all_categories['objects']),$all_categories['objects']);

	}



	public function test_update_valueMethod_withString_ReturnsArray()
	{

		//Execution path 1 : valid value format	
		$rating  = Rating::find(1,'ali')['object'];		
	
		$exec_path_one_update_value_method_output = $rating->update_value(Rating::FIVE_STARS);

		// update the record from db
		$rating = Rating::find(1,'ali')['object']; 

		$this->assertArrayHasKey('failed',$exec_path_one_update_value_method_output);
		$this->assertArrayHasKey('error',$exec_path_one_update_value_method_output);

		$this->assertFalse($exec_path_one_update_value_method_output['failed']);
		$this->assertEmpty($exec_path_one_update_value_method_output['error']);
		$this->assertEquals(Rating::FIVE_STARS,$rating->value);

		// Execution path 2 : invalid value format

		$exec_path_two_update_value_method_output = $rating->update_value("A");

		$this->assertArrayHasKey('failed',$exec_path_two_update_value_method_output);
		$this->assertArrayHasKey('error',$exec_path_two_update_value_method_output);

		$this->assertTrue($exec_path_two_update_value_method_output['failed']);
		$this->assertEquals('please make sure that you did enter a valid value',$exec_path_two_update_value_method_output['error']);


	}



	public function test_update_descriptionMethod_withString_ReturnsArray()
	{
		//Execution path 1 : valid description format

		$rating  = Rating::find(1,'ali')['object'];

		$exec_path_one_update_description_method_output = $rating->update_description("updatedDescription");

		// update the record from db
		$rating = Rating::find(1,'ali')['object']; 

		$this->assertArrayHasKey('failed',$exec_path_one_update_description_method_output);
		$this->assertArrayHasKey('error',$exec_path_one_update_description_method_output);

		$this->assertFalse($exec_path_one_update_description_method_output['failed']);
		$this->assertEmpty($exec_path_one_update_description_method_output['error']);
		$this->assertEquals('updatedDescription',$rating->description);

		// Execution path 2 : invalid description format

		$exec_path_two_update_description_method_output = $rating->update_description("//#@$%^");

		$this->assertArrayHasKey('failed',$exec_path_two_update_description_method_output);
		$this->assertArrayHasKey('error',$exec_path_two_update_description_method_output);

		$this->assertTrue($exec_path_two_update_description_method_output['failed']);
		$this->assertEquals('please make sure that you did enter a valid description',$exec_path_two_update_description_method_output['error']);

	}


	public function test_deleteMethod_WithId_ReturnsArray()
	{
		$delete_output = Rating::delete(1,'ali');

		$this->assertFalse($delete_output['failed']);
		$this->assertEmpty($delete_output['error']);


	}

}
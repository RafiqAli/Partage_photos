<?php

//use PHPUnit\Framework\TestCase;

require_once("PHPUnit/Framework/TestCase.php");

require_once("../Models/Category.php");

class CategoryTest extends PHPUnit_Framework_TestCase
{

	public static $id;

	public $category;

	public function test_CreateMethod_WithArray_ReturnsArray()
	{

		// Execution path 1 : valid arguments

		$to_be_created_category = Category::create(array(
															'name'        => 'name',
															'description' => 'description',
													  ));

		self::$id = Request::lastInsertId();
		$category_instance = new Category(self::$id,'name','description');

		$this->assertEquals($category_instance,$to_be_created_category['object']);
		$this->assertFalse($to_be_created_category['failed']);
		$this->assertEmpty($to_be_created_category['error']);

		// Execution path 2 : invalid arguments : name
		 

		$invalid_name_category = Category::create(array(
															'name'        => '777',
															'description' => 'description',
													  ));

		$this->assertTrue($invalid_name_category['failed']);
		$this->assertEquals('please check the format of your fields',$invalid_name_category['error']);

		// Execution path 3 : invalid arguments : description
		
		$invalid_description_category = Category::create(array(
																	'name'        => 'name',
																	'description' => '@#%^&*&%',
															  ));

		$this->assertTrue($invalid_description_category['failed']);
		$this->assertEquals('please check the format of your fields',$invalid_description_category['error']);

		// Execution path 3 : invalid arguments : name & description

		$invalid_name_and_description_category = Category::create(array(
																	'name'        => '7777',
																	'description' => '$%^#@$%^&^%',
															  ));

		$this->assertTrue($invalid_name_and_description_category['failed']);

		$this->assertEquals('please check the format of your fields',$invalid_name_and_description_category['error']);	

	}	


	public function test_findMethod_withId_ReturnsArray()
	{

		// Execution path 1 : Id exists.

		$category  = Category::find(self::$id);

		$this->assertArrayHasKey('failed',$category);
		$this->assertArrayHasKey('object',$category);
		$this->assertArrayHasKey('error',$category);

		$this->assertFalse($category['failed']);
		$this->assertEmpty($category['error']);


		// Execution path 2 : Id does not exist.

		$category = Category::find(9999);

		$this->assertArrayHasKey('failed',$category);
		$this->assertArrayHasKey('error',$category);

		$this->assertTrue($category['failed']);
		$this->assertEquals('we couldn\'t find a category with this id value',$category['error']);

		// Execution path 3 : wrong argument format. 
		
		$category = Category::find('A');

		$this->assertArrayHasKey('failed',$category);
		$this->assertArrayHasKey('error',$category);

		$this->assertTrue($category['failed']);
		$this->assertEquals('please enter a numeric value for the id',$category['error']);
		 
	}

	public function test_allMethod_WithNull_ReturnsArray()
	{

		$all_categories = Category::all();

		$this->assertFalse($all_categories['failed']);

		$this->assertCount(count($all_categories['objects']),$all_categories['objects']);

	}

	public function test_update_nameMethod_withString_ReturnsArray()
	{

		//Execution path 1 : valid name format	
		$category  = Category::find(self::$id)['object'];		
	
		$exec_path_one_update_name_method_output = $category->update_name("updatedName");

		// update the record from db
		$category = Category::find(self::$id)['object']; 

		$this->assertArrayHasKey('failed',$exec_path_one_update_name_method_output);
		$this->assertArrayHasKey('error',$exec_path_one_update_name_method_output);

		$this->assertFalse($exec_path_one_update_name_method_output['failed']);
		$this->assertEmpty($exec_path_one_update_name_method_output['error']);
		$this->assertEquals('updatedName',$category->name);

		// Execution path 2 : invalid name format

		$exec_path_two_update_name_method_output = $category->update_name("777");

		$this->assertArrayHasKey('failed',$exec_path_two_update_name_method_output);
		$this->assertArrayHasKey('error',$exec_path_two_update_name_method_output);

		$this->assertTrue($exec_path_two_update_name_method_output['failed']);
		$this->assertEquals('please make sure that you did enter a valid name',$exec_path_two_update_name_method_output['error']);


	}


	public function test_update_descriptionMethod_withString_ReturnsArray()
	{
		//Execution path 1 : valid description format

		$category  = Category::find(self::$id)['object'];

		$exec_path_one_update_description_method_output = $category->update_description("updatedDescription");

		// update the record from db
		$category = Category::find(self::$id)['object']; 

		$this->assertArrayHasKey('failed',$exec_path_one_update_description_method_output);
		$this->assertArrayHasKey('error',$exec_path_one_update_description_method_output);

		$this->assertFalse($exec_path_one_update_description_method_output['failed']);
		$this->assertEmpty($exec_path_one_update_description_method_output['error']);
		$this->assertEquals('updatedDescription',$category->description);

		// Execution path 2 : invalid description format

		$exec_path_two_update_description_method_output = $category->update_description("//#@$%^");

		$this->assertArrayHasKey('failed',$exec_path_two_update_description_method_output);
		$this->assertArrayHasKey('error',$exec_path_two_update_description_method_output);

		$this->assertTrue($exec_path_two_update_description_method_output['failed']);
		$this->assertEquals('please make sure that you did enter a valid description',$exec_path_two_update_description_method_output['error']);

	}


/*	public function test_photosMethod_withNoArguments_ReturnsArray()
	{

		$photos = Category::photos();

	}*/

	public function test_deleteMethod_WithId_ReturnsArray()
	{
		$delete_output = Category::delete(self::$id);

		self::$id = null;
	}

}


?>
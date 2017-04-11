<?php

//use PHPUnit\Framework\TestCase;

require_once("PHPUnit/Framework/TestCase.php");

require_once("../Models/Category.php");

class CategoryTest extends PHPUnit_Framework_TestCase
{
	public function test_Category_findMethod_withId_ReturnsArray()
	{

		// Execution path 1 : Id exists.

		$category  = Category::find(1);

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
/*
	public function test_Category_CreateMethod_WithArray_ReturnsArray()
	{
		$to_be_created_category = Category::create(array(
															'name'        => 'name',
															'description' => 'description',
													  ));

		$category_instance = new Category(Request::lastInsertId(),'name','description');

		$this->assertEquals($category_instance,$to_be_created_category['object']);

		$this->assertFalse($to_be_created_category['failed']);

		$this->assertEmpty($to_be_created_category['error']);


	}

	*/

	public function test_Category_allMethod_WithNull_ReturnsArray()
	{

		$all_categories = Category::all();

		$this->assertCount(7,$all_categories['objects']);

	}
}


?>
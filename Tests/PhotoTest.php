<?php

//use PHPUnit\Framework\TestCase;

require_once("PHPUnit/Framework/TestCase.php");

require_once("../Models/Photo.php");
require_once("../core/Enumerations.php");

class CategoryTest extends PHPUnit_Framework_TestCase
{

	public function test_neo_search_dateMethod_withArguments_ReturnsArray()
	{
		//$output = Photo::neo_search(Search::TEXT,"content");

		$between_dates = Photo::neo_search_date(Search::BETWEEN_DATES,'2017-03-14','2017-03-17');

		//print_r($output);

		$this->assertFalse($between_dates['failed']);
		$this->assertCount(3,$between_dates['objects']);
		$this->assertEmpty($between_dates['error']);


		$exact_date = Photo::neo_search_date(Search::DATE,'2017-03-21');

		//print_r($exact_date);

		$this->assertFalse($exact_date['failed']);
		$this->assertCount(1,$exact_date['objects']);
		$this->assertEmpty($exact_date['error']);



		$before_date = Photo::neo_search_date(Search::BEFORE_DATE,'2017-03-17');

		//print_r($output);

		$this->assertFalse($before_date['failed']);
		$this->assertCount(3,$before_date['objects']);
		$this->assertEmpty($before_date['error']);


		$after_date = Photo::neo_search_date(Search::AFTER_DATE,'2017-03-14');

		//print_r($output);

		$this->assertFalse($after_date['failed']);
		$this->assertCount(4,$after_date['objects']);
		$this->assertEmpty($after_date['error']);
		

	}

	public function test_categoriesMethod_withNoArguments_ReturnsArray()
	{


		$categories = Photo::find(19)['object']->categories();

		//print_r($categories);

		$this->assertFalse($categories['failed']);
		$this->assertCount(2,$categories['objects']);
		$this->assertEmpty($categories['error']);

	}

	public function test_add_categoriesMethod_withArrayofObjects_ReturnsVoid()
	{

		// Execution path 1 : array of categories

		$list_categories = [];

		for ($i=1; $i < 4; $i++)
		{ 
			$list_categories[] = Category::create(array('name' => "name".$i,'description' => "description".$i))['object'];
		}

		Photo::find(24)['object']->add_categorties($list_categories);

		$this->assertCount(3,Photo::find(24)['object']->categories()['objects']);

		// Execution path 2 : one category object 
		
		$category = Category::create(array('name' => "nameOne",'description' => "descriptionOne".$i))['object'];

		Photo::find(24)['object']->add_categorties($category);

		$this->assertCount(4,Photo::find(24)['object']->categories()['objects']);

	}

	public function test_delete_categoriesMethod_withArrayofObjects_ReturnsVoid()
	{

		$photo = Photo::find(24)['object'];

		$list_categories = $photo->categories()['objects'];

		$list_categories_reduced = [];

		for ($i=1; $i < 3; $i++)
		{ 
			$list_categories_reduced[] = $list_categories[$i];
		}

		$photo->delete_categories($list_categories_reduced);

		$this->assertCount(2,$photo->categories()['objects']);

		foreach ($photo->categories()['objects'] as $category) {
			
			$photo->delete_categories($category);
		}

		foreach ($list_categories as $category) {
			
			Category::delete($category->id);
		}


	}

	public function test_ratingsMethod_withNoArgument_ReturnsArray()
	{

		$photo = Photo::find(19)['object'];

		$ratings_output = $photo->ratings();

		$this->assertFalse($ratings_output['failed']);
		$this->assertCount(2,$ratings_output['objects']);
		$this->assertEmpty($ratings_output['error']);

		$this->assertEquals(5,$ratings_output['objects'][0]->value);
		$this->assertEquals(5,$ratings_output['objects'][1]->value);

	}


	public function test_average_ratingMethod_withNoArgument_ReturnsArray()
	{

		$photo = Photo::find(19)['object'];

		$avg_rating_output = $photo->average_rating();

		print_r($avg_rating_output);

		$this->assertFalse($avg_rating_output['failed']);
		$this->assertEmpty($avg_rating_output['error']);
	}


}


?>
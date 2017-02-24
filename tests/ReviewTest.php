<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Review.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Review::deleteAll();
        }

        function test_save()
        {
            $review = 'it was alright';
            $user_id = 4;
            $restaurant_id = 2;
            $id = null;
            $test_review = new Review ($review, $user_id, $restaurant_id, $id);
            $test_review->save();

            $result = Review::getAll();

            $this->assertEquals($result[0], $test_review);
        }

        function test_deleteAll()
        {
            $review = 'it was alright';
            $user_id = 4;
            $restaurant_id = 2;
            $id = null;
            $test_review = new Review ($review, $user_id, $restaurant_id, $id);
            $test_review->save();

            Review::deleteAll();
            $result = Review::getAll();

            $this->assertEquals($result, []);
        }

        function test_getByRestaurantId()
        {
            $review = 'it was alright';
            $user_id = 4;
            $restaurant_id = 2;
            $id = null;
            $test_review = new Review ($review, $user_id, $restaurant_id, $id);
            $test_review->save();

            $review2 = 'it was sort of alright';
            $user_id2 = 5;
            $restaurant_id2 = 3;
            $id2 = null;
            $test_review2 = new Review ($review2, $user_id2, $restaurant_id2, $id2);
            $test_review2->save();


            $result = Review::getByRestaurant($test_review2->getRestaurant_id());

            $this->assertEquals($result[0], $test_review2);
        }



    }
?>

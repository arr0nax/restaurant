<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Restaurant.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
        }
        function test_save()
        {
            $cuisine_id = 3;
            $name = 'greek geeks';
            $spice = 2;
            $price = 3;
            $size = 4;
            $review = 'service was ok, but water had lead in it';
            $id = null;
            $test_restaurant = new Restaurant($cuisine_id, $name, $spice, $price, $size, $review, $id);
            $test_restaurant->save();

            $result = Restaurant::getAll();

            $this->assertEquals($result[0], $test_restaurant);
        }
    }

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
            $id = null;
            $test_restaurant = new Restaurant($cuisine_id, $name, $spice, $price, $size, $id);
            $test_restaurant->save();

            $result = Restaurant::getAll();

            $this->assertEquals($result[0], $test_restaurant);
        }
        function test_getAll()
        {
            $cuisine_id = 3;
            $name = 'greek geeks';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_restaurant = new Restaurant($cuisine_id, $name, $spice, $price, $size, $id);
            $test_restaurant->save();

            $cuisine_id2 = 2;
            $name2 = 'roman times';
            $spice2 = 1;
            $price2 = 2;
            $size2 = 1;
            $id2 = null;
            $test_restaurant2 = new Restaurant($cuisine_id2, $name2, $spice2, $price2, $size2, $id2);
            $test_restaurant2->save();

            $result = Restaurant::getAll();

            $this->assertEquals($result, [$test_restaurant, $test_restaurant2]);
        }

        function test_deleteAll()
        {
            $cuisine_id = 3;
            $name = 'greek geeks';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_restaurant = new Restaurant($cuisine_id, $name, $spice, $price, $size, $id);
            $test_restaurant->save();

            $cuisine_id2 = 2;
            $name2 = 'roman times';
            $spice2 = 1;
            $price2 = 2;
            $size2 = 1;
            $id2 = null;
            $test_restaurant2 = new Restaurant($cuisine_id2, $name2, $spice2, $price2, $size2, $id2);
            $test_restaurant2->save();

            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            $this->assertEquals($result, []);
        }

        function test_getById()
        {
            $cuisine_id = 3;
            $name = 'greek geeks';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_restaurant = new Restaurant($cuisine_id, $name, $spice, $price, $size, $id);
            $test_restaurant->save();

            $cuisine_id2 = 2;
            $name2 = 'roman times';
            $spice2 = 1;
            $price2 = 2;
            $size2 = 1;
            $id2 = null;
            $test_restaurant2 = new Restaurant($cuisine_id2, $name2, $spice2, $price2, $size2, $id2);
            $test_restaurant2->save();

            $result = Restaurant::getById($test_restaurant2->getId());

            $this->assertEquals($result, $test_restaurant2);
        }

        function test_update()
        {
            $cuisine_id = 3;
            $name = 'greek geeks';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_restaurant = new Restaurant($cuisine_id, $name, $spice, $price, $size, $id);
            $test_restaurant->save();

            $cuisine_id2 = 2;
            $name2 = 'roman times';
            $spice2 = 1;
            $price2 = 2;
            $size2 = 1;

            $test_restaurant->update($cuisine_id2, $name2, $spice2, $price2, $size2);

            $test_restaurant->setCuisine_id($cuisine_id2);
            $test_restaurant->setName($name2);
            $test_restaurant->setSpice($spice2);
            $test_restaurant->setPrice($price2);
            $test_restaurant->setSize($size2);

            $result = Restaurant::getAll();

            $this->assertEquals($result[0], $test_restaurant);
        }
    }

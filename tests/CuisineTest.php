<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Cuisine.php';
    require_once 'src/Restaurant.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
            Restaurant::deleteAll();
        }
        function test_save()
        {
            $type = 'greek';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_cuisine = new Cuisine($type, $spice, $price, $size, $id);
            $test_cuisine->save();

            $result = Cuisine::getAll();

            $this->assertEquals($result[0], $test_cuisine);
        }

        function test_getAll()
        {
            $type = 'greek';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_cuisine = new Cuisine($type, $spice, $price, $size, $id);
            $test_cuisine->save();

            $type2 = 'roman';
            $spice2 = 1;
            $price2 = 4;
            $size2 = 3;
            $id2 = null;
            $test_cuisine2 = new Cuisine($type2, $spice2, $price2, $size2, $id2);
            $test_cuisine2->save();

            $result = Cuisine::getAll();

            $this->assertEquals($result, [$test_cuisine, $test_cuisine2]);
        }

        function test_deleteAll()
        {
            $type = 'greek';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_cuisine = new Cuisine($type, $spice, $price, $size, $id);
            $test_cuisine->save();

            $type2 = 'roman';
            $spice2 = 1;
            $price2 = 4;
            $size2 = 3;
            $id2 = null;
            $test_cuisine2 = new Cuisine($type2, $spice2, $price2, $size2, $id2);
            $test_cuisine2->save();

            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            $this->assertEquals($result, []);
        }

        function test_getById()
        {
            $type = 'greek';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_cuisine = new Cuisine($type, $spice, $price, $size, $id);
            $test_cuisine->save();

            $type2 = 'roman';
            $spice2 = 1;
            $price2 = 4;
            $size2 = 3;
            $id2 = null;
            $test_cuisine2 = new Cuisine($type2, $spice2, $price2, $size2, $id2);
            $test_cuisine2->save();

            $result = Cuisine::getById($test_cuisine2->getId());

            $this->assertEquals($result, $test_cuisine2);
        }

        function test_deleteById()
        {
            $type = 'greek';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_cuisine = new Cuisine($type, $spice, $price, $size, $id);
            $test_cuisine->save();

            $type2 = 'roman';
            $spice2 = 1;
            $price2 = 4;
            $size2 = 3;
            $id2 = null;
            $test_cuisine2 = new Cuisine($type2, $spice2, $price2, $size2, $id2);
            $test_cuisine2->save();

            Cuisine::deleteById($test_cuisine->getId());
            $result = Cuisine::getAll();

            $this->assertEquals($result, [$test_cuisine2]);
        }

        function test_update()
        {
            $type = 'greek';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_cuisine = new Cuisine($type, $spice, $price, $size, $id);
            $test_cuisine->save();

            $type2 = 'roman';
            $spice2 = 1;
            $price2 = 4;
            $size2 = 3;
            $test_cuisine->update($type2, $spice2, $price2, $size2);
            $test_cuisine->setType($type2);
            $test_cuisine->setPrice($price2);
            $test_cuisine->setSize($size2);
            $test_cuisine->setSpice($spice2);

            $result = Cuisine::getAll();

            $this->assertEquals([$test_cuisine], $result);
        }

        function test_getRestaurants()
        {
            $type = 'greek';
            $spice = 2;
            $price = 3;
            $size = 4;
            $id = null;
            $test_cuisine = new Cuisine($type, $spice, $price, $size, $id);
            $test_cuisine->save();

            $type2 = 'roman';
            $spice2 = 1;
            $price2 = 4;
            $size2 = 3;
            $id2 = null;
            $test_cuisine2 = new Cuisine($type2, $spice2, $price2, $size2, $id2);
            $test_cuisine2->save();

            $cuisine_id = $test_cuisine->getId();
            $name = 'greek geeks';
            $spice = 2;
            $price = 3;
            $size = 4;
            $review = 'service was ok, but water had lead in it';
            $id = null;
            $test_restaurant = new Restaurant($cuisine_id, $name, $spice, $price, $size, $review, $id);
            $test_restaurant->save();

            $cuisine_id2 = $test_cuisine2->getId();
            $name2 = 'roman times';
            $spice2 = 1;
            $price2 = 2;
            $size2 = 1;
            $review2 = 'large portions, poor quality';
            $id2 = null;
            $test_restaurant2 = new Restaurant($cuisine_id2, $name2, $spice2, $price2, $size2, $review2, $id2);
            $test_restaurant2->save();

            $result = $test_cuisine->getRestaurants();

            $this->assertEquals($result[0], $test_restaurant);

        }
    }



?>

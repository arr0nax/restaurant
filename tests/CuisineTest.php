<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Cuisine.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class SourceTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Cuisine::deleteAll();
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
    }



?>

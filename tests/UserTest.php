<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/User.php';

    $server = 'mysql:host=localhost:8889;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            User::deleteAll();
        }

        function test_save()
        {
            $username = 'clayton';
            $password = 'codeboy';
            $id = null;
            $test_user = new User($username, $password, $id);
            $test_user->save();

            $result = User::getAll();

            $this->assertEquals($result[0], $test_user);

        }



    }
?>

<?php
    class User {
        private $username;
        private $password;
        private $id;

        function __construct($username, $password, $id = null) {

            $this->username = $username;
            $this->password = $password;
            $this->id = $id;
        }

        function getUsername()
        {
            return $this->username;
        }

        function setUsername($username)
        {
            $this->username = $username;
        }

        function getPassword()
        {
            return $this->password;
        }

        function setPassword($password)
        {
            $this->password = $password;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($id)
        {
            $this->id = $id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO users (username, password) VALUES ('{$this->getUsername()}', '{$this->getPassword()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function login($username, $password)
        {
            $returned_user = $GLOBALS['DB']->query("SELECT * FROM users WHERE username = '{$username}';");
            foreach ($returned_user as $user) {
                if ($username == $user['username'] and $password == $user['password'])
                {
                    $_SESSION['user'] = new User($username, $password, $user['id']);
                }
            }

        }

        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            $users = array();
            foreach ($returned_users as $user) {
                $new_user = new User($user['username'], $user['password'], $user['id']);
                array_push($users, $new_user);
            }
            return $users;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM users");
        }

    }

 ?>

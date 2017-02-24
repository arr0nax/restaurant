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
            $this->setId($GLOBALS['DB']->lastInsertId());
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

        static function getReviewsById($id)
        {
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews WHERE user_id = {$id}");
            $reviews = array();
            foreach ($returned_reviews as $review)
            {
                $new_review = new Review($review['review'], $review['user_id'], $review['restaurant_id'], $review['id']);
                array_push($reviews, $new_review);
            }
            return $reviews;
        }

        static function getById($id)
        {
            $returned_user = $GLOBALS['DB']->query("SELECT * FROM users WHERE id = {$id};");
            foreach ($returned_user as $user) {
                $new_user = new User ($user['username'], $user['password'], $user['id']);
                return $new_user;
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

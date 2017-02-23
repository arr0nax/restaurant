<?php
    class Review {

        private $review;
        private $user_id;
        private $restaurant_id;
        private $id;

        function __construct($review, $user_id, $restaurant_id, $id = null)
        {
            $this->review = $review;
            $this->user_id = $user_id;
            $this->id = $id;
        }

        function getReview()
        {
            return $this->review;
        }

        function setReview($review)
        {
            $this->review = $review;
        }

        function getUser_id()
        {
            return $this->user_id;
        }

        function setUser_id($user_id)
        {
            $this->user_id = $user_id;
        }

        function getRestaurant_id()
        {
            return $this->restaurant_id;
        }

        function setRestaurant_id($restaurant_id)
        {
            $this->restaurant_id = $restaurant_id;
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
            $GLOBALS['DB']->exec("INSERT INTO reviews (review, user_id, restaurant_id) VALUES ('{$this->getReview()}', {$this->getUser_id()}, {$this->getRestaurant_id()});");
        }

        static function getByRestaurant($id)
        {
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews WHERE restaurant_id = {$id}");
            $reviews = array();
            foreach ($returned_reviews as $review)
            {
                $new_review = new Review($review['review'], $review['user_id'], $review['restaurant_id'], $review['id']);
                array_push($reviews, $new_review);
            }
            return $reviews;
        }

        static function getAll()
        {
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews");
            $reviews = array();
            foreach ($returned_reviews as $review)
            {
                $new_review = new Review($review['review'], $review['user_id'], $review['restaurant_id'], $review['id']);
                array_push($reviews, $new_review);
            }
            return $reviews;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM reviews");
        }




    }

 ?>

<?php
    class Restaurant {

        private $id;
        private $cuisine_id;
        private $name;
        private $spice;
        private $price;
        private $size;
        private $review;

        function __construct($cuisine_id, $name, $spice, $price, $size, $review, $id = null)
        {
            $this->cuisine_id = $cuisine_id;
            $this->name = $name;
            $this->spice = $spice;
            $this->price = $price;
            $this->size = $size;
            $this->review = $review;
            $this->id = $id;
        }

        function getCuisine_id()
        {
            return $this->cuisine_id;
        }

        function setCuisine_id($cuisine_id)
        {
            $this->cuisine_id = $cuisine_id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($name)
        {
            $this->name = $name;
        }

        function getSpice()
        {
            return $this->spice;
        }

        function setSpice($spice)
        {
            $this->spice = $spice;
        }
        function getPrice()
        {
            return $this->price;
        }

        function setPrice($price)
        {
            $this->price = $price;
        }
        function getSize()
        {
            return $this->size;
        }

        function setSize($size)
        {
            $this->size = $size;
        }

        function getReview()
        {
            return $this->review;
        }

        function setReview($review)
        {
            $this->review = $review;
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
            $GLOBALS['DB']->exec("INSERT INTO restaurants (cuisine_id, name, price, spice, size, review) VALUES ({$this->getCuisine_id()},'{$this->getName()}', {$this->getPrice()}, {$this->getSpice()}, {$this->getSize()}, '{$this->getReview()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($cuisine_id, $name, $spice, $price, $size, $review)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET cuisine_id = {$cuisine_id}, name = '{$name}', spice = {$spice}, price = {$price}, size = {$size}, review = '{$review}' WHERE id = {$this->id};");
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant)
            {
                $new_restaurant = new Restaurant($restaurant['cuisine_id'], $restaurant['name'], $restaurant['spice'], $restaurant['price'], $restaurant['size'], $restaurant['review'], $restaurant['id']);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function getById($id)
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants where id = {$id};");
            $restaurants = array();
            foreach($returned_restaurants as $restaurant)
            {
                $new_restaurant = new Restaurant($restaurant['cuisine_id'], $restaurant['name'], $restaurant['spice'], $restaurant['price'], $restaurant['size'], $restaurant['review'], $restaurant['id']);
                return $new_restaurant;
            }
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants");
        }
    }


?>

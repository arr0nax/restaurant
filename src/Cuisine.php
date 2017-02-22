<?php
    class Cuisine {

        private $id;
        private $type;
        private $spice;
        private $price;
        private $size;

        function __construct($type, $spice, $price, $size, $id = null)
        {
            $this->type = $type;
            $this->spice = $spice;
            $this->price = $price;
            $this->size = $size;
            $this->id = $id;
        }

        function getType()
        {
            return $this->type;
        }

        function setType($type)
        {
            $this->type = $type;
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
            $GLOBALS['DB']->exec("INSERT INTO cuisines (type, spice, price, size) VALUES ('{$this->getType()}', {$this->getSpice()}, {$this->getPrice()}, {$this->getSize()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine)
            {
                $new_cuisine = new Cuisine($cuisine['type'], $cuisine['spice'], $cuisine['price'], $cuisine['size'], $cuisine['id']);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM animals");
        }
    }


?>
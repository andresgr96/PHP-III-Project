<?php

    class Client
    {
        private $id;
        private $name;
        private $stylist_id;
        function __construct($id=null, $name, $stylist_id)
        {
            $this->id = $id;
            $this->name = $name;
            $this->stylist_id = $stylist_id;
        }
        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients (name, stylist_id) VALUES ('{$this->getName()}', {$this->getStylistId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client) {
                $id = $client['id'];
                $name = $client['name'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($id, $name, $stylist_id);
                array_push($clients, $new_client);
            }

            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client)
            {
                $client_id = $client->getId();
                if ($client_id == $search_id)
                {
                    $found_client = $client;
                }
            }

            return $found_client;
        }
    }
 ?>

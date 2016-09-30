<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost:3307;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class Client_test extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Client::deleteAll();
            Stylist::deleteAll();
        }

        function test_save()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $cl_name = "Zachary";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($id, $cl_name, $stylist_id);
            // Act
            $test_client->save();
            // Assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $cl_name = "Zachary";
            $test_client = new Client($id, $cl_name, $stylist_id);
            $test_client->save();
            $cl_name2 = "Alexi";
            $test_client2 = new Client($id, $cl_name2, $stylist_id);
            $test_client2->save();
            // Act
            $result = Client::getAll();
            // Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $cl_name = "Zachary";
            $test_client = new Client($id, $cl_name, $stylist_id);
            $test_client->save();
            $cl_name2 = "Alexi";
            $test_client2 = new Client($id, $cl_name2, $stylist_id);
            $test_client2->save();
            // Act
            Client::deleteAll();
            // Asserts
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $cl_name = "Zachary";
            $test_client = new Client($id, $cl_name, $stylist_id);
            $test_client->save();
            $cl_name2 = "Alexi";
            $test_client2 = new Client($id, $cl_name2, $stylist_id);
            $test_client2->save();
            // Act
            $result = Client::find($test_client->getId());
            // Assert
            $this->assertEquals($test_client, $result);
        }

        function test_delete()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $cl_name = "Zachary";
            $test_client = new Client($id, $cl_name, $stylist_id);
            $test_client->save();
            $cl_name2 = "Alexi";
            $test_client2 = new Client($id, $cl_name2, $stylist_id);
            $test_client2->save();
            // Act
            $test_client->delete();
            // Assert
            $result = Client::getAll();
            $this->assertEquals([$test_client2], $result);
        }
        
        function test_update()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $stylist_id = $test_stylist->getId();
            $cl_name = "Zachary";
            $test_client = new Client($id, $cl_name, $stylist_id);
            $test_client->save();
            // Act
            $new_name = "Lazuli";
            $test_client->update($new_name);
            // Assert
            $result = $test_client->getName();
            $this->assertEquals("Lazuli", $result);
        }
    }
 ?>

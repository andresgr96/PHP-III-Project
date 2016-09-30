<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stylist.php";
    require_once "src/Client.php";

    $server = 'mysql:host=localhost:3307;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class Stylist_test extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_save()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            // Act
            $test_stylist->save();
            // Assert
            $result = Stylist::getAll();
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $name2 = "Phoebe";
            $test_stylist2 = new Stylist($id, $name2);
            $test_stylist2->save();
            // Act
            $result = Stylist::getAll();
            // Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $name2 = "Phoebe";
            $test_stylist2 = new Stylist($id, $name2);
            $test_stylist2->save();
            // Act
            Stylist::deleteAll();
            // Assert
            $result = Stylist::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $name2 = "Phoebe";
            $test_stylist2 = new Stylist($id, $name2);
            $test_stylist2->save();
            // Act
            $result = Stylist::find($test_stylist->getId());
            // Assert
            $this->assertEquals($test_stylist, $result);
        }

        function test_get_clients()
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
            $result = $test_stylist->getClients();
            // Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_delete()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            $name2 = "Phoebe";
            $test_stylist2 = new Stylist($id, $name2);
            $test_stylist2->save();
            // Act
            $test_stylist->delete();
            // Assert
            $result = Stylist::getAll();
            $this->assertEquals([$test_stylist2], $result);
        }
        
        function test_update()
        {
            // Arrange
            $id = null;
            $name = "Randy";
            $test_stylist = new Stylist($id, $name);
            $test_stylist->save();
            // Act
            $new_name = "Randal";
            $test_stylist->update($new_name);
            // Assert
            $result = $test_stylist->getName();
            $this->assertEquals("Randal", $result);
        }
    }
 ?>

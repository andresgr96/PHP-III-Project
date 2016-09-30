<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();
    $server = 'mysql:host=localhost:8889;dbname=salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/create_stylist", function() use ($app) {
        return $app['twig']->render('create_stylist.html.twig');
    });

    $app->post("/", function() use ($app) {
        $id = null;
        $stylist = new Stylist($id, $_POST['name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylist/{id}/clients", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->get("/stylist/{id}/clients/{cid}/delete", function($id, $cid) use ($app) {
        $stylist = Stylist::find($id);
        $client = Client::find($cid);
        $client->delete();
        return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->get("/stylist/{id}/new_client", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('create_client.html.twig', array('stylist' => $stylist));
    });

    $app->post("/stylist/{id}/clients", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist_id = $id;
        $new_id = null;
        $client = new client($new_id, $_POST['name'], $stylist_id);
        $client->save();
        return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->get("/stylist/{id}/clients/{cid}/update", function($id, $cid) use ($app) {
        $stylist = Stylist::find($id);
        $client = Client::find($cid);
        return $app['twig']->render('update_client.html.twig', array('stylist' => $stylist, 'client' => $client));
    });

    $app->patch("/stylist/{id}/clients/{cid}/updated", function($id, $cid) use ($app) {
        $stylist = Stylist::find($id);
        $client = Client::find($cid);
        $client->update($_POST['new_name']);
        return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->get("/stylist/{id}/update", function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('update_stylist.html.twig', array('stylist' => $stylist));
    });

    $app->patch("/update/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->update($_POST['new_name']);
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylist/{id}/delete", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->delete("/stylist/{id}/delete_all", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $clients = $stylist->getClients();
        foreach ($clients as $client) {
            if ($client->getStylistId() == $stylist->getId()) {
                $client->delete();

            }
        }
        return $app['twig']->render('clients.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getCLients()));
    });

    return $app;
 ?>

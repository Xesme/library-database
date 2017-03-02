<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    // require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // Book routes

    $app->get("/", function() use ($app) {
        return $app['twig']->render('book_search.html.twig');
    });

    $app->post("/post/book", function() use ($app) {
        return 'To do';

        // $stylist = new Stylist($_POST['stylist_name'], $_POST['stylist_contact_info']);
        // $stylist->save();
        //
        // return $app['twig']->render('stylists.html.twig',
        //     array('edit_stylist' => new Stylist, 'stylists' => Stylist::getAll())
        // );
    });

    $app->get("/get/book/{id}/edit", function($id) use ($app) {
        return 'To do';
        // $stylist = Stylist::findById($id);
        //
        // return $app['twig']->render('stylists.html.twig',
        //     array('edit_stylist' => $stylist, 'stylists' => Stylist::getAll())
        // );
    });

    $app->patch("/patch/book/{id}", function($id) use ($app) {
        return 'To do';
        // $stylist = Stylist::findById($id);
        // $stylist->update($_POST['stylist_name'], $_POST['stylist_contact_info']);
        //
        // return $app['twig']->render('stylists.html.twig',
        //     array('edit_stylist' => new Stylist, 'stylists' => Stylist::getAll())
        // );
    });

    $app->delete("/delete/book/{id}", function($id) use ($app) {
        return 'To do';
        // $stylist = Stylist::findById($id);
        // $stylist->delete();
        //
        // return $app['twig']->render('stylists.html.twig',
        //     array('edit_stylist' => new Stylist, 'stylists' => Stylist::getAll())
        // );
    });

    $app->delete("/delete/books", function() use ($app) {
        return 'To do';
        // Client::deleteAll();
        // Stylist::deleteAll();
        //
        // return $app['twig']->render('stylists.html.twig',
        //     array('edit_stylist' => new Stylist, 'stylists' => Stylist::getAll())
        // );
    });

    // CRUD for Author

    $app->get("/get/authors", function() use ($app) {
        return $app['twig']->render('author.html.twig');
    });

    $app->post("/post/author", function() use ($app) {
        return 'To do';

    });

    $app->get("/get/author/{id}/edit", function($id) use ($app) {
        return 'To do';

    });

    $app->patch("/patch/author/{id}", function($id) use ($app) {
        return 'To do';

    });

    $app->delete("/delete/author/{id}", function($id) use ($app) {
        return 'To do';

    });

    $app->delete("/delete/authors", function() use ($app) {
        return 'To do';

    });


    return $app;
?>

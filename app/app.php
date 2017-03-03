<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";

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

    $app->get("/get/book/edit", function() use ($app) {
        $search_author = '%Em%';
        $found_authors = Author::getAll($search_author);
        $book_authors = array(Author::findById(2));

        return $app['twig']->render(
            'book_edit.html.twig',
            array('search_author' => $search_author,
                'found_authors' => $found_authors,
                'book_authors' => $book_authors
            )
        );

    });

    $app->post("/post/book", function() use ($app) {
        $search_author = $_POST['search_author'];
        $found_authors = array();
        $book_authors = array();
        $remove_author_from_book_id = '';

        if (array_key_exists('remove_author_from_book_button', $_POST)) {
            $remove_author_from_book_id = $_POST['remove_author_from_book_button'];
        }

        $book_author_index = 0;
        while (array_key_exists('book_author_' . $book_author_index, $_POST)) {
            $next_author_id = $_POST['book_author_' . $book_author_index];

            if ($next_author_id != $remove_author_from_book_id) {
                array_push(
                    $book_authors,
                    Author::findById($next_author_id)
                );
            }
            $book_author_index++;
        }

        if (array_key_exists('find_authors_button', $_POST)) {
            if (gettype(strpos($search_author, '%')) == 'boolean') {
                $search_author = '%' . $search_author . '%';
            }
            $found_authors = Author::getAll($search_author);
        }

        if (array_key_exists('add_author_to_book', $_POST)) {
            array_push($book_authors, Author::findById($_POST['add_author_to_book']));
        }

        return $app['twig']->render(
            'book_edit.html.twig',
            array('search_author' => $search_author,
                'found_authors' => $found_authors,
                'book_authors' => $book_authors
            )
        );

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
        $search_expression = '';
        if (array_key_exists('author_name', $_GET)) {
            $search_expression = $_GET['author_name'];
            if (!strpos($search_expression, '%')) {
                $search_expression = '%' . $search_expression . '%';
            }
            $found_authors = Author::getAll($search_expression);
        } else {
            $found_authors = Author::getAll();
        }

        return $app['twig']->render(
            'author.html.twig',
            array('authors' => $found_authors, 'edit_author' => New Author, 'search_expression' => $search_expression)
        );
    });

    $app->post("/post/author", function() use ($app) {
        $author = new Author($_POST['author_name']);
        $author->save();
        return $app['twig']->render('author.html.twig',
            array('authors' => [$author], 'edit_author' => New Author)
        );
    });

    $app->get("/get/author/{id}/edit", function($id) use ($app) {
        $author = Author::findById($id);

        return $app['twig']->render(
            'author.html.twig',
            array('authors' => Author::getAll(), 'edit_author' => $author)
        );
    });

    $app->patch("/patch/author", function() use ($app) {
        $author = Author::findById($_POST['id']);
        $author->update($_POST['author_name']);

        return $app['twig']->render(
            'author.html.twig',
            array('authors' => Author::getAll(), 'edit_author' => New Author)
        );
    });

    $app->delete("/delete/author/{id}", function($id) use ($app) {
        $author = Author::findById($id);
        $author->delete();

        return $app['twig']->render(
            'author.html.twig',
            array('authors' => Author::getAll(), 'edit_author' => New Author)
        );
    });

    $app->delete("/delete/authors", function() use ($app) {
        return 'To do';

    });


    return $app;
?>

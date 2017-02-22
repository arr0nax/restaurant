<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";

    $server = 'mysql:host=localhost:8889;dbname=restaurant';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);
    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get('/', function() use($app) {
        $result = Cuisine::getAll();
        return $app["twig"]->render("root.html.twig", ['result' => $result]);
    });

    $app->post('/addcuisine', function() use($app) {
        $new_cuisine = new Cuisine($_POST['type'], $_POST['spice'], $_POST['price'], $_POST['size']);
        $new_cuisine->save();
        return $app->redirect('/');
    });

    $app->get('/cuisine/{id}', function($id) use($app) {
        $result = Cuisine::getById($id);
        return $app["twig"]->render("cuisine.html.twig", ['result' => $result]);
    });

    $app->get('/editcuisine/{id}', function($id) use($app) {
        $result = Cuisine::getById($id);
        return $app["twig"]->render("editcuisine.html.twig", ['result' => $result]);
    });

    $app->patch('/editcuisine/{id}', function($id) use($app) {
        Cuisine::update($_POST['type'], $_POST['spice'], $_POST['price'], $_POST['size'], $id);
        $result = Cuisine::getById($id);
        return $app->redirect('/cuisine/'.$id);
    });

    $app->delete('/deletecuisine/{id}', function($id) use($app) {
        Cuisine::deleteById($id);
        return $app->redirect('/');
    });

    return $app;
?>

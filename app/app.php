<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

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
        $cuisine = Cuisine::getAll();
        $restaurant = Restaurant::getAll();
        return $app["twig"]->render("root.html.twig", ['cuisine' => $cuisine, 'restaurant' => $restaurant]);
    });

    $app->post('/addcuisine', function() use($app) {
        $new_cuisine = new Cuisine($_POST['type'], $_POST['spice'], $_POST['price'], $_POST['size']);
        $new_cuisine->save();
        return $app->redirect('/');
    });

    $app->post('/addrestaurant', function() use($app) {
        $new_restaurant = new Restaurant($_POST['cuisine_id'], $_POST['name'], $_POST['spice'], $_POST['price'], $_POST['size'], $_POST['review']);
        $new_restaurant->save();
        return $app->redirect('/');
    });

    $app->get('/cuisine/{id}', function($id) use($app) {
        $cuisine = Cuisine::getById($id);
        $restaurants = $cuisine->getRestaurants();
        return $app["twig"]->render("cuisine.html.twig", ['cuisine' => $cuisine, 'restaurants' => $restaurants]);
    });

    $app->get('/restaurant/{id}', function($id) use($app) {
        $restaurant = Restaurant::getById($id);
        $cuisine = Cuisine::getById($restaurant->getCuisine_id());
        return $app["twig"]->render("restaurant.html.twig", ['restaurant' => $restaurant, 'cuisine' => $cuisine]);
    });

    $app->get('/editcuisine/{id}', function($id) use($app) {
        $cuisine = Cuisine::getById($id);
        return $app["twig"]->render("editcuisine.html.twig", ['cuisine' => $cuisine]);
    });

    $app->get('/editrestaurant/{id}', function($id) use($app) {
        $restaurant = Restaurant::getById($id);
        $cuisine = Cuisine::getAll();
        return $app["twig"]->render("editrestaurant.html.twig", ['cuisine' => $cuisine, 'restaurant' => $restaurant]);
    });

    $app->patch('/editcuisine/{id}', function($id) use($app) {
        $cuisine = Cuisine::getById($id);
        $cuisine->update($_POST['type'], $_POST['spice'], $_POST['price'], $_POST['size'], $id);
        return $app->redirect('/cuisine/'.$id);
    });

    $app->patch('/editrestaurant/{id}', function($id) use($app) {
        $restaurant = Restaurant::getById($id);
        $restaurant->update($_POST['cuisine_id'], $_POST['name'], $_POST['spice'], $_POST['price'], $_POST['size'], $_POST['review']);
        return $app->redirect('/restaurant/'.$id);
    });

    $app->delete('/deletecuisine/{id}', function($id) use($app) {
        Cuisine::deleteById($id);
        return $app->redirect('/');
    });

    return $app;
?>

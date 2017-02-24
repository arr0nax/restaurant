<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/User.php";
    require_once __DIR__."/../src/Review.php";

    $server = 'mysql:host=localhost:8889;dbname=restaurant';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app->register(new Silex\Provider\TwigServiceProvider(), ["twig.path" => __DIR__."/../views"]);
    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    session_start();
    if (empty($_SESSION['user'])) {
        $_SESSION['user'] = new User('annonymoose', '');
        $_SESSION['user']->save();
    };

    $app->get('/', function() use($app) {
        $cuisine = Cuisine::getAll();
        $restaurant = Restaurant::getAll();
        return $app["twig"]->render("root.html.twig", ['cuisine' => $cuisine, 'restaurant' => $restaurant, 'user' => $_SESSION['user']]);
    });

    $app->post('/signup', function() use($app) {
        $new_user = new User($_POST['username'], $_POST['password']);
        $new_user->save();
        return $app->redirect('/');
    });

    $app->post('/login', function() use($app) {
        User::login($_POST['username'],$_POST['password']);
        return $app->redirect('/');
    });

    $app->post('/addcuisine', function() use($app) {
        $new_cuisine = new Cuisine($_POST['type'], $_POST['spice'], $_POST['price'], $_POST['size']);
        $new_cuisine->save();
        return $app->redirect('/');
    });

    $app->post('/addrestaurant', function() use($app) {
        $new_restaurant = new Restaurant($_POST['cuisine_id'], $_POST['name'], $_POST['spice'], $_POST['price'], $_POST['size']);
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
        $reviews = Review::getByRestaurant($id);
        $users = User::getAll();
        return $app["twig"]->render("restaurant.html.twig", ['restaurant' => $restaurant, 'cuisine' => $cuisine, 'user' => $_SESSION['user'], 'users' => $users, 'reviews' => $reviews]);
    });

    $app->post('/writereview/{id}', function($id) use($app) {
        $review = $_POST['review'];
        $user_id = $_SESSION['user']->getId();
        $restaurant_id = $id;
        $review_id = null;
        $new_review = new Review($review, $user_id, $restaurant_id, $review_id);
        $new_review->save();
        return $app->redirect('/restaurant/'.$id);
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
        $restaurant->update($_POST['cuisine_id'], $_POST['name'], $_POST['spice'], $_POST['price'], $_POST['size']);
        return $app->redirect('/restaurant/'.$id);
    });

    $app->delete('/deletecuisine/{id}', function($id) use($app) {
        Cuisine::deleteById($id);
        return $app->redirect('/');
    });

    $app->delete('/deleterestaurant/{id}', function($id) use($app) {
        Restaurant::deleteById($id);
        return $app->redirect('/');
    });

    $app->get('/profile/{id}', function($id) use($app) {
        $user_reviews = User::getReviewsById($id);
        $user = User::getById($id);
        $restaurants = Restaurant::getAll();
        return $app["twig"]->render("profile.html.twig", ['user_reviews' => $user_reviews, 'user' => $user, 'restaurants' => $restaurants]);
    });

    return $app;
?>

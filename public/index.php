<?php
use Silex\Application;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app['debug'] = true;
$app->register(new SessionServiceProvider());
$app->register(new TwigServiceProvider(),array(
    'twig.path' => __DIR__ . '/../src/views'
));
$app->register(new \App\Provider\UserServiceProvider());
$app->mount('/users', new App\Controller\UserController($app['session']));

// Route for the registration form
$app->get('/register', function () use ($app) {
    return $app['twig']->render('register.twig');
});

// $app->post('/register', function (Request $request) use ($app) {
//     $username = $request->get('username');
//     $email = $request->get('email');
//     $password = $request->get('password');

//     // You can add validation logic here
//     if (!$username || !$email || !$password) {
//         return $app['twig']->render('register.twig', ['error' => 'All fields are required!']);
//     }
//     return json_encode([
//         'user' => $username,
//         'email' => $email,
//         'password' => $password
//     ]);
// });



$app->run();
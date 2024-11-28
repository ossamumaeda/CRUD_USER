<?php

namespace App\Controller;

require_once __DIR__ . '/../Helpers/index.php';

use App\Helpers\ResponseUtil;

use Pimple\Container;

use Silex\Api\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;

class UserController implements ControllerProviderInterface
{
    /** @var $app Container */
    protected $app;

    public function connect(Container $app)
    {
        $this->app = $app;
        $controllers = $this->app['controllers_factory'];

        $controllers->get('/', function (){
            $users = $this->app['user.service']->getAllUsers();
            // return ResponseUtil::createResponse('success', ['users' => $users]);
            return $this->app['twig']->render('list.twig',[
                'users' => $users
            ]);
        });

        $controllers->get('/{id}', function ($id) {
            $user = $this->app['user.service']->getUserById($id);
            return ResponseUtil::createResponse('success', ['user' => $user]);
        })->assert('id', '\d+'); 

        $controllers->post('/',function (Request $request) {
            $username = $request->get('username');
            $email = $request->get('email');
            $password = $request->get('password');
            $users = $this->app['user.service']->registerUser($username,$email,$password);
            return $this->app->redirect('/users');
        });

        return $controllers;
    }
}



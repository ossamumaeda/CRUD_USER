<?php

namespace App\Provider;

use Silex\Application;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use App\Service\UserService;

class UserServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        // Register the UserService class as a service
        $app['user.service'] = function () use($app) {
            return new UserService($app['session']);
        };
    }

    public function boot(Application $app)
    {
        // This method is not necessary for this service but can be used to perform any setup after service registration
    }
}

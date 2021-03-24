<?php

namespace Router\Demo\Core;

use Routing\Attribute\Route;
use Routing\Core\Router;

require_once('Router.php');

class Application
{

    public function __construct($controllerDir = 'Controller', $namespace = 'Routing\\')
    {
        $this->prepareControllerRoutes($controllerDir, $namespace);
    }

    public function prepareControllerRoutes($controllerDir, $namespace)
    {
        $controllerLoc = dirname(__DIR__) . '/' . $controllerDir;

        $controllers = array_diff(scandir($controllerLoc), ['.', '..']);

        foreach ($controllers as $controller) {
            require_once $controllerLoc . '/' . $controller;

            $controllerName = pathinfo($controller, PATHINFO_FILENAME);
            $reflectionClass = new \ReflectionClass($namespace . $controllerDir . '\\' . $controllerName);

            $rcAttr = $reflectionClass->getAttributes(Route::class);

            $prefix = '';

            if(count($rcAttr) > 0) {
                $prefix = ($rcAttr[0]->newInstance())->getPath();
                $prefix = '/'.trim($prefix, '/');
            }

            foreach ($reflectionClass->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $path = $prefix.'/'.trim($route->getPath(), '/');

                    if($path == '') {
                        $path = '/';
                    }

                    Router::register(
                        $path,
                        [$reflectionClass->getName(), $method->getName()],
                        $route->getMethod()
                    );
                }
            }

            unset($rcAttr);
            unset($prefix);
        }
    }

    public function resolve()
    {
        Router::run();
    }
}

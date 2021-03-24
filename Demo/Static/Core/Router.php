<?php


namespace Routing\Core;

use ReflectionFunction;
use ReflectionMethod;

// TODO: prefixes + / give route not found with route attribute
class Router
{
    private static array $routes = [];

    public static function register(
        string $path,
        callable|array $callable,
        string|array $method = 'GET'): void
    {
        if (array_search($path, array_column(self::$routes, 'path')) === false) {

            preg_match_all('/{([^}]+)}/', $path, $matches);

            foreach ($matches[0] as $replace) {
                $path = str_replace($replace, '(\w+)', $path);
            }

            self::$routes[] = [
                'path' => $path,
                'callable' => $callable,
                'method' => is_array($method) ? $method : [$method],
                'variables' => $matches[1]
            ];
        } else {
            echo 'Route already exists';
        }
    }

    public static function run()
    {
        // Parse the URL
        $request_uri = parse_url($_SERVER['REQUEST_URI']);

        // Get the Path
        if (isset($request_uri['path'])) {
            $path = $request_uri['path'];
        } else {
            $path = '/';
        }

        // Remove tracing /'s
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        // Get request method
        $method = $_SERVER['REQUEST_METHOD'];

        $path_found = false;
        $route_found = false;

        foreach (self::$routes as $route) {
            $route['path'] = '^' . $route['path'] . '$';

            if (preg_match('#' . $route['path'] . '#', $path, $matches)) {
                $path_found = true;

                $route['method'] = array_map('strtolower', $route['method']);

                if (in_array(strtolower($method), $route['method'])) {
                    array_shift($matches);

                    if (is_array($route['callable'])) {
                        if (method_exists($route['callable'][0], $route['callable'][1])) {
                            $route['callable'][0] = new $route['callable'][0]();
                            $reflectionMethod = new ReflectionMethod($route['callable'][0], $route['callable'][1]);

                        } else {
                            echo 'Function not found';
                        }
                    } else {
                        $reflectionMethod = new ReflectionFunction($route['callable']);
                    }

                    $args = array_combine($route['variables'], $matches);

                    $arguments = [];

                    if (count($reflectionMethod->getParameters()) !== count($args)) {
                        die('Unequal amount of parameters');
                    }

                    foreach ($reflectionMethod->getParameters() as $arg) {
                        if (isset($args[$arg->name])) {
                            $arguments[$arg->name] = $args[$arg->name];
                        } else if ($arg->isDefaultValueAvailable()) {
                            $arguments[$arg->name] = $arg->getDefaultValue();
                        } else {
                            $arguments[$arg->name] = null;
                        }
                    }


                    call_user_func_array($route['callable'], $arguments);

                    $route_found = true;
                    break;
                }
            }
        }

        if (!$route_found) {
            if ($path_found) {
                header("HTTP/1.0 405 Method Not Allowed");
                die('Method not allowed');
            } else {
                header("HTTP/1.0 404 Not Found");
                die('Not found');
            }
        }
    }
}

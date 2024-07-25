<?php

namespace App\Core;

class Router
{
    private $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function run()
    {
        $uri = $this->sanitizeUri($_SERVER['REQUEST_URI']);
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method])) {
            echo "404 Not Found";
            return;
        }

        foreach ($this->routes[$method] as $route => $action) {
            $routeRegex = $this->convertRouteToRegex($route);
            if (preg_match("#^$routeRegex$#", $uri, $matches)) {
                array_shift($matches);
                $controllerName = $action['Controller'];
                $methodName = $action['action'];
                $controllerClass = "App\\Controller\\{$controllerName}";

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $methodName)) {
                        call_user_func_array([$controller, $methodName], $matches);
                        return;
                    } else {
                        echo "Méthode {$methodName} n'existe pas dans le contrôleur {$controllerClass}";
                        return;
                    }
                } else {
                    echo "Contrôleur {$controllerClass} n'existe pas";
                    return;
                }
            }
        }

        echo "404 Not Found";
    }

    private function sanitizeUri($uri)
    {
        return '/' . trim(parse_url($uri, PHP_URL_PATH), '/');
    }

    private function convertRouteToRegex($route)
    {
        return preg_replace('/{[^}]+}/', '([^/]+)', $route);
    }
}







// namespace App\Core;

// use ReflectionClass;
// use ReflectionMethod;

// class Router
// {
//     private $routes = [];

//     public function get($uri, $controllerAction)
//     {
//         $this->addRoute('GET', $uri, $controllerAction);
//     }

//     public function post($uri, $controllerAction)
//     {
//         $this->addRoute('POST', $uri, $controllerAction);
//     }

//     private function addRoute($method, $uri, $controllerAction)
//     {
//         $uri = $this->sanitizeUri($uri);
//         $this->routes[$method][$uri] = $controllerAction;
//     }

//     public function routePage($method, $uri)
//     {
//         echo "Method: $method, URI: $uri<br>";
//         $uri = $this->sanitizeUri($uri);
//         echo "Sanitized URI: $uri<br>";

//         if (!isset($this->routes[$method])) {
//             echo "No routes defined for method $method<br>";
//             return;
//         }

//         foreach ($this->routes[$method] as $route => $controllerAction) {
//             echo "Checking route: $route<br>";
//             $pattern = $this->convertRouteToRegex($route);
//             echo "Route pattern: $pattern<br>";
//             if (preg_match($pattern, $uri, $matches)) {
//                 echo "Route matched!<br>";
//                 array_shift($matches);
//                 return $this->executeControllerAction($controllerAction, $matches);
//             }
//         }

//         echo "Route introuvable pour {$method} {$uri}";
//     }

//     private function sanitizeUri($uri)
//     {
//         $uri = parse_url($uri, PHP_URL_PATH);
//         return '/' . trim($uri, '/');
//     }

//     private function convertRouteToRegex($route)
//     {
//         $pattern = preg_replace('/\/{(.*?)}/', '/([^/]+)', $route);
//         return "#^" . $pattern . "$#";
//     }

//     private function executeControllerAction($controllerAction, $params)
//     {
//         $controllerName = $controllerAction['Controller'];
//         $action = $controllerAction['action'];

//         $controllerClass = "Src\\Controller\\{$controllerName}";

//         try {
//             $controllerInstance = $this->instantiateController($controllerClass);
//             $this->invokeAction($controllerInstance, $action, $params);
//         } catch (\Exception $e) {
//             echo $e->getMessage();
//         }
//     }

//     private function instantiateController($controllerClass)
//     {
//         $reflectionClass = new ReflectionClass($controllerClass);

//         if (!$reflectionClass->isInstantiable()) {
//             throw new \Exception("Le contrôleur {$controllerClass} n'est pas instantiable");
//         }

//         $constructor = $reflectionClass->getConstructor();
//         $dependencies = [];

//         if ($constructor !== null) {
//             $parameters = $constructor->getParameters();

//             foreach ($parameters as $parameter) {
//                 $dependencies[] = $this->resolveDependency($parameter);
//             }
//         }

//         return $reflectionClass->newInstanceArgs($dependencies);
//     }

//     private function resolveDependency($parameter)
//     {
//         // Ici, vous pouvez implémenter la logique pour résoudre les dépendances
//         // Par exemple, en utilisant un conteneur de dépendances
//         // Pour l'instant, on va simplement instancier la classe si possible
//         if ($parameter->getClass() !== null) {
//             return $this->instantiateController($parameter->getClass()->getName());
//         }

//         throw new \Exception("Impossible de résoudre la dépendance pour {$parameter->getName()}");
//     }

//     private function invokeAction($controllerInstance, $action, $params)
//     {
//         $reflectionClass = new ReflectionClass($controllerInstance);

//         if (!$reflectionClass->hasMethod($action)) {
//             throw new \Exception("La méthode {$action} n'existe pas dans le contrôleur " . $reflectionClass->getName());
//         }

//         $reflectionMethod = $reflectionClass->getMethod($action);

//         if (!$reflectionMethod->isPublic()) {
//             throw new \Exception("La méthode {$action} dans le contrôleur " . $reflectionClass->getName() . " n'est pas accessible");
//         }

//         $reflectionMethod->invokeArgs($controllerInstance, $params);
//     }
// }

<?php

namespace app\core;

use Exception;

// @package app\core
class Router
{

    public Request $request;
    public Response $response;
    protected array $routes = [];


    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView("_404", $params = ['title' => '404 Not Found']);
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if(is_array($callback)){
            $callback[0] = new $callback[0]();
        }
        return call_user_func($callback);
    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent($params);
        $viewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent($params = [])
    {
        $title = $params['title'] ?? 'My Application';
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach($params as $key => $value){
            $$key = $value;
        }

        $viewFile = Application::$ROOT_DIR . "/views/{$view}.php";
        $indexFile = Application::$ROOT_DIR . "/views/{$view}/index.php";

        ob_start();

        if(is_file($viewFile)){
            include $viewFile;
        }
        elseif(is_file($indexFile)){
            include $indexFile;
        }
        else{
            throw new \Exception("View {$view} not found");
        }
        return ob_get_clean();
    }
}

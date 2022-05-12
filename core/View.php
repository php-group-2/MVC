<?php

namespace App\core;

class View
{
    public function renderView(string $view, array $params = [])
    {
        $layout = $this->renderLayout();
        $content = $this->renderContent($view, $params);
        return str_replace("{{content}}", $content, $layout);
    }

    public function renderContent($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT . "/view/$view.php";
        return ob_get_clean();
    }

    public function renderLayout()
    {
        $layout = Application::$app->controller->layout ?? "main";
        ob_start();
        include_once Application::$ROOT . "/view/layout/$layout.php";
        return ob_get_clean();
    }
}

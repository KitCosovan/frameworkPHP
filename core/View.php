<?php

namespace PHPFramework;

class View
{
    public string $layout;
    public string $content = '';

    public function __construct($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $data = [], $layout = ''): string
    {
        extract($data);
        $view_file = VIEWS . "/{$view}.php";
        if (is_file($view_file)) {
            ob_start();
            require $view_file;
            $this->content = ob_get_clean();
        } else {
            abort("View was not found: {$view_file}", 505);
        }

        if (false === $layout) {
            return $this->content;
        }

        $layout_file_name = $layout ?: $this->layout;
        $layout_file = VIEWS . "/layouts/{$layout_file_name}.php";

        if (is_file($layout_file)) {
            ob_start();
            require_once $layout_file;
            return ob_get_clean();
        } else {
            abort("Layout was not found: {$layout_file}". 505);
        }
    }

    public function renderPartial($view, $data = []): string
    {
        extract($data);
        $view_file = VIEWS . "/{$view}.php";
        if (is_file($view_file)) {
            ob_start();
            require $view_file;
            return ob_get_clean();
        } else {
            return "File {$view_file} not found";
        }
    }
}

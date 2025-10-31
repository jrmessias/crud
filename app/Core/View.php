<?php

namespace App\Core;

use League\Plates\Engine;

class View
{
    private Engine $engine;

    public function __construct()
    {
        $this->engine = new Engine(dirname(__DIR__, 2) . '/views');
    }

    public function render(string $template, array $data = []): string
    {
        return $this->engine->render($template, $data);
    }
}

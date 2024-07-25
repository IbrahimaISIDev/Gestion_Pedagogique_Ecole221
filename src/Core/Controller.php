<?php

namespace App\Core;

class Controller
{
    protected function renderView($viewName, $data = [])
    {
        extract($data);
        include __DIR__ . '/../views/' . $viewName . '.php';
    }
}

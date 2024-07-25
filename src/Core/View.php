<?php

namespace App\Core;

class View {
    public function render($viewName, $data = []) {
        extract($data);
        include_once __DIR__ . "/../views/{$viewName}.php";
    }
}
?>

<?php

namespace App\Core;

class Entity {
    protected $attributes = [];

    public function __construct(array $attributes) {
        $this->attributes = $attributes;
    }

    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }
}
?>

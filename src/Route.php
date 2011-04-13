<?php

namespace Conductor\Route

class Route extends Base {
    private $method;
    private $path;
    private $callback;
    private $name;

    public function __construct() {
        $this->readableProperties('method', 'path', 'callback', 'name');
        $this->writableProperties('name');
    }
}

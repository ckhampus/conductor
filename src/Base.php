<?php

namespace Conductor\Base

abstract class Base {
    private $readable = array();
    private $writable = array();

    protected function readableProperties() {
        if (func_num_args() > 0) {
            $this->readable = array_merge($this->readable, func_get_args());
        }
    }

    protected fucntion writableProperties() {
        if (func_num_args() > 0) {
            $this->writable = array_merge($this->writable, func_get_args());
        }
    }

    public function __call($name, $arguments) {
        if (substr($name, 0, 3) === 'set') {
            
        }
    }
}

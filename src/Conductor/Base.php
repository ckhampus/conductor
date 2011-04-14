<?php

namespace Conductor;

/**
 * The base class that contains some basic functionality
 * 
 * @author Cristian Hampus
 */
abstract class Base {
    private $readable = array();
    private $writable = array();

    /**
     * Creates getters for the specified property names. 
     * 
     * @return void
     */
    protected function readableProperties() {
        if (func_num_args() > 0) {
            $this->readable = array_merge($this->readable, func_get_args());
        }
    }

    /**
     * Create setters for the specified property names.
     * 
     * @return void
     */
    protected function writableProperties() {
        if (func_num_args() > 0) {
            $this->writable = array_merge($this->writable, func_get_args());
        }
    }

    public function __call($name, $arguments) {
        $property = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', substr($name, 3)));

        if (property_exists(__CLASS__, $property)) {
            throw new \Exception(sprintf('Property "%s" doesn\'t exist.', $property));
        }
        
        $property = new \ReflectionProperty($this, $property);
        $property->setAccessible(TRUE);

        if (substr($name, 0, 3) === 'set' && in_array($property->getName(), $this->writable)) {
            if (empty($arguments)) {
                throw new \Exception('Excpecting arguments.');
            }

            $property->setValue($this, $arguments[0]);
        } elseif (substr($name, 0, 3) === 'get' && in_array($property->getName(), $this->readable)) {
            return $property->getValue($this);
        }
    }
}

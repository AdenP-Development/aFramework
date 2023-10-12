<?php

namespace Aden\aFramework\Core;

class Config {
    protected $cfg;

    public function __construct(array|string $config) {
        if(gettype($config)== "string") {
            $this->load($config);
        } else {
            $this->cfg = $config;
        }
    }

    public function load($path) {
        if(str_contains($path, ".env")) {
            $this->cfg = Environment::load($path);
        }
    }

    public function get($name) {
        return $this->cfg[$name];
    }

    public function set($name, $data) {
        $this->cfg[$name] = $data;
    }

    public function setvars($vars) {
        foreach($vars as $key => $val) {
            $this->cfg[$key] = $val;
        }
    }
}
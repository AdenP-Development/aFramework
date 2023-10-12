<?php

namespace Aden\aFramework\Core;

use Exception;

class Environment {
    public static function load(string $path) {
        if(!is_file($path))
            throw new Exception("No .env file was found.");

        $contents = preg_replace("/^\s*#/m", ";", file_get_contents($path));
        $data = parse_ini_string($contents, false, INI_SCANNER_RAW);

        if($data == false)
            throw new Exception("Failed to parse .env file.");

        return $data;
    }
}
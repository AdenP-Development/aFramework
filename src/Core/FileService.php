<?php
namespace Aden\aFramework\Core;

class FileService {
    /**
     * A really crude function to quickly get the file exstension of a, well, file. Will be rewrote at some point.
     * 
     * @param String $f Either the file, including its path, or a string. (ie __DIR__."/$val" or "$val")
     * 
     * @return String|Bool Returns the exstension, or false if there was an issue.
     */
    public static function GetExtension(string $f) : string|bool {
        if(is_file($f)) {
            return pathinfo($f, PATHINFO_EXTENSION);
        } else {
            $e = explode(".", $f);

            if(count($e) == 0)
                return false;
            
            return $e[count($e)-1]; // return the last extension, since thats all we really care about.
        }
    }
}
<?php

namespace Aden\aFramework\HTML;

class Responses {
    public static function API($msg, $success=true) : void {
        echo json_encode(["Message" => $msg, "Success" => $success]);
    }

    public static function Error($msg, $special=false) : void {
        if($special == false) 
            $msg = htmlentities($msg);

        echo "<div class='alert alert-danger'><b>Error!</b> $msg</div>";
    }

    public static function Success($msg, $special=false) : void {
        if($special == false) 
            $msg = htmlentities($msg);

        echo "<div class='alert alert-success'><b>Success!</b> $msg</div>";
    }

    public static function Warning($msg, $special=false) : void {
        if($special == false) 
            $msg = htmlentities($msg);

        echo "<div class='alert alert-warning'><b>Warning!</b> $msg</div>";
    }
}
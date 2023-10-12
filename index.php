<?php
namespace Aden;

use Aden\aFramework\Config;

require "vendor/autoload.php";

$db = new aFramework\SQL\Database("sqlite", null, "test");
$tbl = [
    "id" => ["type" => "INT", "primary" => true],
    "name" => ["type" => "TEXT"],
    "col3" => ["type" => "timestamp", "default" => "CURRENT_TIMESTAMP"]
];
$q = $db->CreateTable("test2", $tbl);

if($q->error) {
    die($q->error);
}

echo "not app";
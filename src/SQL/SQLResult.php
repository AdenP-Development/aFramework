<?php

namespace Aden\aFramework\SQL;

use PDO;

class SQLResult {
    public $dataAssoc, $dataNum = [];
    public $error;

    public function __construct($res) {
        if(gettype($res)== "string") {
            $this->error = $res;

            return;
        }

        $this->dataAssoc = $res->fetchAll(PDO::FETCH_ASSOC);
        $this->dataNum = $res->fetchAll(PDO::FETCH_NUM);
    }
}
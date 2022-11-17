<?php

namespace App\Models;

use PDO;

class Team extends ModelPDO{
    protected $table = 'team';
    protected $primaryKey = 'code';

    public function __construct($data = false)
    {
        $schema = array(
            'code' => PDO::PARAM_STR,
            'name' => PDO::PARAM_STR
        );
        parent::__construct($schema, $data);
    }
}
?>
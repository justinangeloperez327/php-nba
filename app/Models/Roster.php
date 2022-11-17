<?php

namespace App\Models;

use PDO;

class Roster extends ModelPDO {
    protected $table = 'roster';
    protected $primaryKey = 'id';

    public function __construct($data = false)
    {
        $schema = array(
            'id' => PDO::PARAM_STR,
            'team_code' => PDO::PARAM_STR,
            'number' => PDO::PARAM_INT,
            'name' => PDO::PARAM_STR,
            'pos' => PDO::PARAM_STR,
            'height' => PDO::PARAM_STR,
            'weight' => PDO::PARAM_INT,
            'dob' => PDO::PARAM_STR,
            'nationality' => PDO::PARAM_STR,
            'years_exp' => PDO::PARAM_STR,
            'college' => PDO::PARAM_STR,
        );

        parent::__construct($schema, $data);
    }
}
?>
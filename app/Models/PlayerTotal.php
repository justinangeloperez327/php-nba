<?php

namespace App\Models;

use PDO;

class PlayerTotal extends ModelPDO {
    protected $table = 'palyer_totals';
    protected $primaryKey = 'player_id';

    public function __construct($data = false)
    {
        $schema = array(
            'player_id' => PDO::PARAM_STR,
            'age' => PDO::PARAM_INT,
            'games' => PDO::PARAM_INT,
            'games_started' => PDO::PARAM_INT,
            'minutes_played' => PDO::PARAM_INT,
            'field_goals' => PDO::PARAM_INT,
            'field_goals_attempted' => PDO::PARAM_INT,
            '3pt' => PDO::PARAM_INT,
            '3pt_attempted' => PDO::PARAM_INT,
            '2pt' => PDO::PARAM_INT,
            '2pt_attemted' => PDO::PARAM_INT,
            'free_throws' => PDO::PARAM_INT,
            'free_throws_attempted' => PDO::PARAM_INT,
            'offensive_rebounds' => PDO::PARAM_INT,
            'defensive_rebounds' => PDO::PARAM_INT,
            'assists' => PDO::PARAM_INT,
            'steals' => PDO::PARAM_INT,
            'blocks' => PDO::PARAM_INT,
            'turnovers' => PDO::PARAM_INT,
            'personal_fouls' => PDO::PARAM_INT,
        );

        parent::__construct($schema, $data);
    }
}
?>
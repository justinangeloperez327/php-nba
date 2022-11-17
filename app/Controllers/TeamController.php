<?php

namespace App\Controllers;

use App\Models\Team;

class TeamController {
    
    public static function fetchAll()
    {
        $teams = Team::all();

        return $teams;
    }

    public function store()
    {
        $team = new Team();
        $team->code = 'LAL';
        $team->name = 'Los Angeles Lakers';
        $team->save();
        
        return [
            'message' => 'Successfully added',
            'success' => true,
        ];
    }

    public function update($id)
    {
        $team = Team::get($id);
        $team->code = 'LAC';
        $team->name = 'Los Angeles Clippers';
        $team->save();
        
        return [
            'message' => 'Updated Successfully',
            'success' => true,
        ];
    }

    public function show($id)
    {
        $team = Team::get($id);

        return [
            'team' => $team
        ];
    }

    public function delete($id)
    {
        $roster = Team::get($id);
        $roster->delete();

        return [
            'message' => 'Deleted Successfuly'
        ];
    }
}
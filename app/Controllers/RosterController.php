<?php

namespace App\Controllers;

use App\Models\Roster;

class TeamController {
    
    public function fetchAll()
    {
        $rosters = Roster::all();

        return [
            'rosters' => $rosters
        ];
    }

    public function store()
    {
        $roster = new Roster();
        $roster->name = 'Lebron James';
        $roster->team_code = 'LAL';
        $roster->save();
        
        return [
            'message' => 'Successfully added',
            'success' => true,
        ];
    }

    public function update($id)
    {
        $roster = Roster::get($id);
        $roster->name = 'Stephen Curry';
        $roster->team_code = 'GSW';
        $roster->save();
        
        return [
            'message' => 'Updated Successfully',
            'success' => true,
        ];
    }

    public function show($id)
    {
        $roster = Roster::get($id);

        return [
            'roster' => $roster
        ];
    }

    public function delete($id)
    {
        $roster = Roster::get($id);
        $roster->delete();

        return [
            'message' => 'Deleted Successfuly'
        ];
    }
}
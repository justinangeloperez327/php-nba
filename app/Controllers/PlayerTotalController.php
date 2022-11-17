<?php

namespace App\Controllers;

use App\Models\PlayerTotal;

class TeamController {
    
    public function fetchAll()
    {
        $playerTotals = PlayerTotal::all();

        return [
            'player_totals' => $playerTotals
        ];
    }

    public function store()
    {
        $playerTotal = new PlayerTotal();
        $playerTotal->age = 27;
        $playerTotal->games = 82;
        $playerTotal['3pt'] = 200;
        $playerTotal['2pt'] = 500;
        $playerTotal->save();
        
        return [
            'message' => 'Successfully added',
            'success' => true,
        ];
    }

    public function update($id)
    {
        $playerTotal = PlayerTotal::get($id);
        $playerTotal->age = 27;
        $playerTotal->games = 82;
        $playerTotal['3pt'] = 200;
        $playerTotal['2pt'] = 500;
        $playerTotal->save();
        
        return [
            'message' => 'Updated Successfully',
            'success' => true,
        ];
    }

    public function show($id)
    {
        $playerTotal = PlayerTotal::get($id);

        return [
            'playerTotal' => $playerTotal
        ];
    }

    public function delete($id)
    {
        $playerTotal = PlayerTotal::get($id);
        $playerTotal->delete();

        return [
            'message' => 'Deleted Successfuly'
        ];
    }
}
<?php

namespace App\Http\Controllers\Fleet;

use App\Models\Fleet\Fleet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FleetController extends Controller
{

    public function newFleet()
    {
        $fleet = Fleet::firstOrNew(
            ['fc' => auth()->user()->id],
            ['fleet_name' => auth()->user()->name.'\'s Fleet']

        );
        $fleet->save();
        return redirect()->back();
    }
    public function getFleets()
    {
        if(!auth()->user())
        {
            return view('no');
        }
        $active = Fleet::where('active', true)->get();
        $completed = Fleet::where('complete', true)->get();
        return view('fleets.index', compact('active','completed'));

    }
    public function joinFleet($fleetid)
    {
        $fleet = Fleet::where('id', $fleetid)->get();
        $user = auth()->user();
        $redirect = $fleet->punchIn($user);
        return $redirect;
    }
    public function leaveFleet($fleetid)
    {
        $fleet = Fleet::where('id', $fleetid)->get();
        $user = auth()->user();
        $redirect = $fleet->punchOut($user);
        return $redirect;
    }

}

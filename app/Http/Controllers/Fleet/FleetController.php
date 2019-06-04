<?php

namespace App\Http\Controllers\Fleet;

use App\Models\Fleet\Fleet;
use App\Validation\Fleet\LootValidation;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
class FleetController extends Controller
{

    public function newFleet()
    {
        $fleet =new Fleet;
        $fleet->fc= auth()->user()->id;
        $fleet->fleet_name= auth()->user()->name.'\'s Fleet';
        $fleet->save();
        return redirect()->back();
    }
    public function endFleet($fleetid)
    {
        $fleet = Fleet::find($fleetid);
        $fleet->active = false;
        $fleet->complete = true;
        $fleet->ended_at = Carbon::now();
        $fleet->save();
        return redirect()->back();

    }
    public function getFleetView($fleetid)
    {
        $fleet = Fleet::find($fleetid);


        return view('fleets.view', compact('fleet'));
    }
    public function getParticipants($fleetid)
    {

    }
    public function saveLoot(LootValidation $request, $fleetid)
    {
        $loottext = $request->loottext;

        $client = new Client(['headers' => [
            'User-Agent' => 'The TriglavDefense Loot Tool',
            'Content-Type: application/x-www-form-urlencoded'
        ]]);
        $res = $client->post('https://evepraisal.com/appraisal.json?market=jita&persist=no', [
            'form_params' => [
                'raw_textarea' => $loottext
            ]]);
        $body = $res->getBody();
        $data = json_decode($body, true);
       // dd($data);
        $appraisal= $data['appraisal'];
        $fleet = Fleet::find($fleetid);
        $fleet->loot = $appraisal;
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
       // dd($active->participants()->where('active',1)->get());
        $completed = Fleet::where('complete', true)->get();
        return view('fleets.index', compact('active','completed'));

    }
    public function joinFleet($fleetid)
    {
        $fleet = Fleet::where('id', $fleetid)->first();
        $user = auth()->user();
        $redirect = $fleet->punchIn($user);
        return $redirect;
    }
    public function leaveFleet($fleetid)
    {
        $fleet = Fleet::where('id', $fleetid)->first();
        $user = auth()->user();
        $redirect = $fleet->punchOut($user);
        return $redirect;
    }
    public function parseLoot($fleetid)
    {
    }

}

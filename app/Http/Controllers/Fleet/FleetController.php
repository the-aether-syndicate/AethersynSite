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
        $fleet->punchIn();
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
        $fleetModel = Fleet::find($fleetid);
        $fleet = [];
        $punchlist = [];

        $punches = $fleetModel->punches()->get();
        $fleetname = $fleetModel->fleet_name;
        $fleetid = $fleetModel->id;
        $fcid = $fleetModel->getfc()->id;
        $fcname = $fleetModel->getfc()->name;
        $complete = $fleetModel->complete;
        $started = $fleetModel->created_at;
        $ended = $fleetModel->ended_at;
        $duration = $fleetModel->duration();
        $count = $fleetModel->participants->count();
        $loot = $fleetModel->loot;

        $fleet = compact(
            'fcid','fcname','complete','started','ended','duration','loot','fleetname','fleetid','count'
            );


        foreach ($punches as $punch)
        {
            $userID = $punch->user_id;
            $userName = User::find($userID)->name;
            $duration = $punch->duration();

            array_push($punchlist,[

                    'userID' => $userID,
                    'userName' => $userName,
                    'duration' => $duration,

                ]);
        }
        $tempList = [];
        foreach ($punchlist as $punch) {
            $userID = $punch['userID'];
            if (!isset($tempList[$userID]))
            {
                $tempList[$userID] = $punch;
            } else {
                $tempList[$punch['userID']]['duration'] = $tempList[$punch['userID']]['duration']+$punch['duration'];
            }

        }
            $punchlist=$tempList;
       // dd(compact('fleet','punchlist'));
        return view('fleets.view', compact('fleet','punchlist'));
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
    public function rejoinFleet($fleetid)
    {
        $fleet = Fleet::where('id', $fleetid)->first();
        $user = auth()->user();
        $redirect = $fleet->rejoin($user);
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

<?php

namespace App\Http\Controllers\Fleet;

use App\Models\Fleet\Fleet;
use App\Validation\Fleet\LootValidation;
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
        $orderarray = explode("\n", Fleet::find($fleetid)->loot);
        $itemarray = [];
        $total_isk = 0;
        $itemstring = '';
        $volume = 0;
        $itemvolume=0;
        $client = new Client(['headers' => [
            'User-Agent' => 'The Aether Syndicate Ordering Tool',
            'Content-Type: application/x-www-form-urlencoded'
        ]]);
        $res = $client->post('https://evepraisal.com/appraisal.json?market=jita&persist=no', [
            'form_params' => [
                'raw_textarea' =>$order
            ]]);
        $data2 = $res->getBody();
        $data = [];
        $data = json_decode($data2, true);
        $resItemArray = [];
        $resItemArray = $data['appraisal']['items'];
        foreach ($resItemArray as $item)
        {
            $tempArray = [];
            $tempArray['itemID'] = $item['typeID'];
            $tempArray['item'] = $item['typeName'];
            $tempArray['quantity'] = $item['quantity'];
            $tempArray['cost'] = $item['prices']['sell']['min']*$item['quantity'];
            $tempArray['volume'] = $item['typeVolume'];
            $itemarray['items'][] = $tempArray;
        }
        $itemarray['Total'] = $data['appraisal']['totals']['sell'];
        $itemarray['volume'] = $data['appraisal']['totals']['volume'];
        return $itemarray;
    }

}

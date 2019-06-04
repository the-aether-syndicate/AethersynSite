<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/29/2019
 * Time: 10:18 PM
 */

namespace App\Http\Controllers;


use App\Validation\FittingValidation;
use App\Models\Doctrines\Doctrine;
use App\Models\Doctrines\Fitting;
use App\Models\Sde\InvType;
use App\Helpers\Doctrine\CalculateConstants;
use App\Helpers\Doctrine\CalculateEft;
use App\Repository\Auth\UserRepository;
use Yajra\DataTables\Services\DataTable;

class DoctrineController extends Controller
{

    use CalculateEft, UserRepository;

    private $requiredSkills = [];

    public function getDoctrineByID($id)
    {
        $fitlist = [];
        $doctrine = Doctrine::find($id);
        $fittings = $doctrine->fittings()->get();
        //dd($fittings);
        foreach ($fittings as $fit)
        {
            $ship = InvType::where('typeName', $fit->shiptype)->first();
            array_push($fitlist, [
                'id' => $fit->id,
                'name' => $fit->fitname,
                'shipType' => $fit->shiptype,
                'shipImg' => $ship->typeID,
            ]);

        }

        return $fitlist;
    }

    public function getDoctrineView($id)
    {
        $doctrineid = $id;
        return view('pages.doctrines', compact('doctrineid'));
    }
    public function saveFitting(FittingValidation $request, $id)
    {
        $doctrine = Doctrine::find($id);
        $fitting = new Fitting();

        $eft = explode("\n", $request->eftfitting);
        list($fitting->shiptype, $fitting->fitname) = explode(", ", substr($eft[0], 1, -2));
        $fitting->eftfitting = $request->eftfitting;
        $fitting->save();
        $doctrine->fittings()->save($fitting);
        $fitting->doctrine()->associate($doctrine)->save();

        return $this->getDoctrineView($id);
    }
    public function deleteDoctrine($id)
    {
        Doctrine::destroy($id);

        return "Success";
    }
    public function deleteFitting($id)
    {
        Fitting::destroy('$id');

        return redirect()->back();
    }
    public function getEftFittingById($id)
    {
        $fitting = Fitting::find($id);
        return $fitting->eftfitting;
    }
    public function getFittingById($id)
    {
        $fitting = Fitting::find($id);
        return response()->json($this->fittingParser($fitting->eftfitting));
    }

    private function fittingParser($eft)
    {
        $jsfit = [];
        $data = preg_split("/\r?\n\r?\n/", $eft);
        $jsfit['eft'] = $eft;

        $header = preg_split("/\r?\n/", $data[0]);
        list($jsfit['shipname'], $jsfit['fitname']) = explode(",", substr($header[0], 1, -1));
        array_shift($header);
        $data[0] = implode("\r\n", $header);
        // Deal with a blank line between the name and the first low slot
        $lowslot = array_filter(preg_split("/\r?\n/", $data[0]));
        if (empty($lowslot)) {
            $data = array_splice($data, 1, count($data));
        }
        $lowslot = array_filter(preg_split("/\r?\n/", $data[0]));
        $midslot = array_filter(preg_split("/\r?\n/", $data[1]));
        $highslot = array_filter(preg_split("/\r?\n/", $data[2]));
        $rigs = array_filter(preg_split("/\r?\n/", $data[3]));
        // init drones array
        if (count($data) > 4) {
            $drones = array_filter(preg_split("/\r?\n/", $data[4]));
        }
        // special case for tech 3 cruiser which may have sub-modules
        if (in_array($jsfit['shipname'], ['Tengu', 'Loki', 'Legion', 'Proteus'])) {
            $subslot = array_filter(preg_split("/\r?\n/", $data[4]));
            // bump drones to index 5
            $drones = [];
            if (count($data) > 5) {
                $drones = array_filter(preg_split("/\r?\n/", $data[5]));
            }
        }
        $this->loadSlot($jsfit, "LoSlot", $lowslot);
        $this->loadSlot($jsfit, "MedSlot", $midslot);
        $this->loadSlot($jsfit, "HiSlot", $highslot);
        if (isset($subslot)) {
            $this->loadSlot($jsfit, "SubSlot", $subslot);
        }

        $this->loadSlot($jsfit, "RigSlot", $rigs);

        if (isset($drones)) {
            foreach ($drones as $slot) {
                list($drone, $qty) = explode(" x", $slot);
                $item = InvType::where('typeName', $drone)->first();
                $jsfit['dronebay'][$item->typeID] = [
                    'name' => $drone,
                    'qty'  => $qty,
                ];
            }
        }
        return $jsfit;
    }

    /**
     * @param $types
     * @return array
     */
    private function getSkillNames($types)
    {
        $skills = [];
        foreach ($types as $skill_id => $level) {
            $res = InvType::where('typeID', $skill_id)->first();
            $skills[] = [
                'typeId' => $skill_id,
                'typeName' => $res->typeName,
                'level' => $level,
            ];
        }
        ksort($skills);
        return $skills;
    }
    private function loadSlot(&$jsfit, $slotname, $slots)
    {
        $index = 0;
        foreach ($slots as $slot) {
            $module = explode(",", $slot);
            if (! preg_match("/\[Empty .+ slot\]/", $module[0])) {
                $item = InvType::where('typeName', $module[0])->first();
                if (empty($item)) {
                    continue;
                }
                $jsfit[$slotname . $index] = [
                    'id'   => $item->typeID,
                    'name' => $module[0],
                ];
                $index++;
            }
        }
        return;
    }

}
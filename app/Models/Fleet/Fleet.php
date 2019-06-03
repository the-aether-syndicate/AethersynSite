<?php

namespace App\Models\Fleet;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $increments = true;
    protected $table = 'fleet';
    protected $fillable = [
        'fc', 'fleet_name', 'loot','active','complete'

    ];
    public function getfc()
    {
        $user = User::find($this->fc);
        return $user;
    }

    protected function punches()
    {
        return $this->hasMany(Punch::class);
    }
    public function punchIn($user)
    {
        $in_time = now();
        $punch = new Punch();
        $user->associate($punch);
        $user->save();
        $this->associate($punch);
        $this->save();
        $punch->in_time = $in_time;
        $punch->save();
        return redirect()->back();
    }
    public function punchOut($user)
    {
        $out_time = now();
        $user = auth()->user();
        $punch = new Punch();
        $user->associate($punch);
        $user->save();
        $this->associate($punch);
        $this->save();
        $punch->out_time = $out_time;
        $punch->save();
        return redirect()->back();
    }
}

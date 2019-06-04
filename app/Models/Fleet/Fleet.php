<?php

namespace App\Models\Fleet;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Fleet extends Model
{
    protected $increments = true;
    protected $table = 'fleet';
    protected $casts = [
        'loot' => 'array'
    ];
    protected $fillable = [
        'fc', 'fleet_name','active','complete'

    ];
    public function getfc()
    {
        $user = User::find($this->fc);
        return $user;
    }
    public function endFleet()
    {
        $this->active = false;
        $this->completed = true;
    }
    public function punches()
    {
        return $this->hasMany(Punch::class);
    }
    public function participants()
    {
        return $this->belongsToMany(User::class)->using( Punch::class);
    }
    public function hasMember($userid)
    {
        //$member = $this->participants()->where('user_id', $userid)->first();
        $punch = $this->punches()->where('user_id', $userid)->first();
        if($punch) {
            if ($punch->out_time == null) {
                return 1;
            }
            if ($punch->out_time != null) {
                return 2;
            }
        }
        return 0;
    }
    public function punchIn()
    {
        $in_time = now();
        $user = auth()->user();
        $punch = Punch::firstOrNew(['user_id' => $user->id, 'fleet_id'=>$this->id]);
        $punch->in_time = $in_time;
        $punch->user()->associate($user);
        $punch->fleet()->associate($this);
        $punch->save();
        return redirect()->back();
    }
    public function punchOut()
    {
        $out_time = now();
        $user = auth()->user();
        $punch = Punch::firstOrNew(['user_id' => $user->id, 'fleet_id'=>$this->id]);
        $punch->out_time = $out_time;
        $punch->save();
        return redirect()->back();
    }
    public function rejoin()
    {
        $out_time = now();
        $user = auth()->user();
        $punch = new Punch(['user_id' => $user->id, 'fleet_id'=>$this->id]);
        $punch->out_time = $out_time;
        $punch->save();
        return redirect()->back();
    }
}

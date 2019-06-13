<?php

namespace App\Models\Fleet;

use App\Models\Auth\User;
use Carbon\Carbon;
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
        'fc', 'fleet_name','active','complete','ended_at','start_at'

    ];
    public function getfc()
    {
        $user = User::find($this->fc);
        return $user;
    }
    public function endFleet()
    {
        $this->active = false;
        $this->complete = true;
        $this->ended_at = Carbon::now();
        $this->ended_at = Carbon::now();
    }
    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
    public function hasMember($userid)
    {
        //$member = $this->participants()->where('user_id', $userid)->first();
        $user = $this->participants()->find($userid);
        if($user) {
            return true;
        }
        return false;
    }
    public function duration()
    {
        $start = Carbon::parse($this->created_at);
        $end = Carbon::parse($this->ended_at);
        $hours = $end->diffInHours($start);
        $minutes = $end->diffInMinutes($start)%60;
        $seconds = $end->diffInSeconds($start)%60;

        return $seconds;
    }
    public function seconds()
    {
        $start = Carbon::parse($this->created_at);
        $end = Carbon::parse($this->ended_at);
        $seconds = $end->diffInSeconds($start);

        return $seconds;
    }
}

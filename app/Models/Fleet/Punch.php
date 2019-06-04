<?php

namespace App\Models\Fleet;

use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Punch extends Pivot
{
    protected $increments = true;
    protected $table='fleet_user';
    protected $fillable = [
        'in_time', 'out_time', 'user_id', 'fleet_id'

    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);


    }

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function duration()
    {
        $start = Carbon::parse($this->in_time);
        $end = Carbon::parse($this->out_time);
        $hours = $end->diffInHours($start);
        $minutes = $end->diffInMinutes($start)%60;
        $seconds = $end->diffInSeconds($start)%60;

        return $hours . ':' . $minutes . ':' . $seconds;
    }
    public function seconds()
    {
        $start = Carbon::parse($this->in_time);
        $end = Carbon::parse($this->out_time);
        $seconds = $end->diffInSeconds($start);

        return $seconds;
    }
    public function punchOut()
    {
        $this->out_time = now();
    }
}

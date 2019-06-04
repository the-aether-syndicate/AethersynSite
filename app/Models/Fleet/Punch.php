<?php

namespace App\Models\Fleet;

use App\Models\Auth\User;
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


    public function punchOut()
    {
        $this->out_time = now();
    }
}

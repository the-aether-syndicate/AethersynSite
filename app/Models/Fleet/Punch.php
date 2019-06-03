<?php

namespace App\Models\Fleet;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
    protected $increments = true;
    protected $table='punch';
    protected $fillable = [
        'in_time', 'out_time'

    ];

    protected function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    protected function user()
    {
        return $this->belongsTo(User::class);
    }


    public function punchOut()
    {
        $this->out_time = now();
    }
}

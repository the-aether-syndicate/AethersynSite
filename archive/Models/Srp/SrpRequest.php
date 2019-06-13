<?php

namespace App\Srp;

use Illuminate\Database\Eloquent\Model;

class SrpRequest extends Model
{
    protected $table = 'srp';
    protected $fillable =
        [
            'kill_id', 'kill_hash', 'requester_id','requester_name', 'details', 'status', 'handler'
        ];
}

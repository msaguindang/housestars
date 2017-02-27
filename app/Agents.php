<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    protected $table = 'agents';

    protected $fillable = ['agent_id', 'agency_id', 'active'];
}

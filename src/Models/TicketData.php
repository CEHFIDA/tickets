<?php

namespace Selfreliance\tickets\Models;

use Illuminate\Database\Eloquent\Model;

class TicketData extends Model
{
	protected $table = 'tickets_data';

    protected $fillable = [
        'tickets_id', 'is_admin', 'message'
    ];
}

<?php

namespace Selfreliance\tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketData extends Model
{
	use SoftDeletes;

	protected $table = 'tickets_data';

    protected $fillable = [
        'tickets_id', 'is_admin', 'message'
    ];
}

<?php

namespace Selfreliance\tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'subject'
    ];

	public function ticket_data()
	{
        return $this->hasMany('Selfreliance\Tickets\Models\TicketData', 'tickets_id');
    }
}

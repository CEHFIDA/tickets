<?php

namespace Selfreliance\tickets\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    const statusOpen = 'open';
    const statusWait = 'wait';
    const statusClose = 'close';

    use SoftDeletes;

    protected $fillable = [
        'user_id', 'subject'
    ];

	public function ticket_data()
	{
        return $this->hasMany('Selfreliance\Tickets\Models\TicketData', 'tickets_id');
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
    }
}

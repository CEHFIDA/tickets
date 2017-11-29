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

    public function setStatus($status)
    {
    	$this->status = $status;
    	$this->save();
    }

    public function scopeNotReadAdmin($query, $id)
    {
    	return $query->where('tickets_id', $id)->where('is_admin', 0)->where('read', false);
    }
}

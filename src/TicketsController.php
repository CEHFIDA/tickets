<?php

namespace Selfreliance\tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Selfreliance\tickets\Models\Ticket;
use Selfreliance\tickets\Models\TicketData;

class TicketsController extends Controller
{
    public function index()
    {
    	$tickets = Ticket::orderBy('id', 'desc')->get();
        return view('tickets::home')->with(['tickets'=>$tickets]);
    }

    public function chat($id)
    {
        $ticket = Ticket::find($id);
        if(count($ticket) > 0)
        {
            $name = User::where('id', $ticket->user_id)->value('name');
            $history = TicketData::where('tickets_id', $id)->get();
            $tickets = Ticket::orderBy('id', 'desc')->get();
            return view('tickets::chat')->with([
                'ticket_id'=>$id,
                'subject'=>$ticket->subject,
                'name'=>$name,
                'history'=>$history,
                'tickets'=>$tickets
            ]);
        }else return redirect()->route('AdminTickets');
    }

    public function send($id, Request $request)
    {
        $this->validate($request, [
            'text' => 'required|min:2'
        ]);

        $send = new TicketData;
        $send->tickets_id = $id;
        $send->is_admin = 1;
        $send->message = $request->input('text');
        $send->save();

        return redirect()->route('AdminTicketsChat', $id)->with('status', 'Сообщение было отправлено!');
    }
}
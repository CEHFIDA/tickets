<?php

namespace Selfreliance\tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Selfreliance\Tickets\Models\Ticket;
use Selfreliance\Tickets\Models\TicketData;

class TicketsController extends Controller
{
    public function index()
    {
    	$tickets = Ticket::orderBy('id', 'desc')->get();
        return view('tickets::show')->with(['tickets'=>$tickets]);
    }

    public function chat($id)
    {
        $ticket = Ticket::findOrFail($id);
        if($ticket){
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

    public function send($id, Request $request, TicketData $modelData)
    {
        $this->validate($request, [
            'text' => 'required|min:2'
        ]);

        $ticket = Ticket::findOrFail($id);
        if($ticket){
            $modelData->tickets_id = $id;
            $modelData->is_admin = 1;
            $modelData->message = $request->input('text');
            $modelData->save();
            return redirect()->route('AdminTicketsChat', $id)->with('status', 'Сообщение было отправлено!');
        }else return redirect()->route('AdminTickets');
    }

    public function create_ticket(Request $request, Ticket $model, TicketData $modelData)
    {
        $this->validate($request, [
            'to' => 'required',
            'subject' => 'required|min:2',
            'message' => 'required|min:2'
        ]);

        $user = User::where('id', $request['to'])->orWhere('email', $request['to'])->value('id');
        if($user){
            $model->user_id = $user;
            $model->from = 'Support';
            $model->subject = $request->input('subject');
            $model->save();

            $modelData->tickets_id = $model->id;
            $modelData->is_admin = 1;
            $modelData->message = $request->input('message');
            $modelData->save();

            return redirect()->route('AdminTickets')->with('status', 'Тикет успешно создан!');
        }else return redirect()->route('AdminTickets');
    }
}
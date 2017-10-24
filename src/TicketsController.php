<?php

namespace Selfreliance\tickets;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Selfreliance\Tickets\Models\Ticket;
use Selfreliance\Tickets\Models\TicketData;

class TicketsController extends Controller
{
	/**
	 * Index
	 * @return view home with tickets, info($new, $untreated, $closed)
	*/
    public function index()
    {
    	$tickets = Ticket::orderBy('id', 'desc')->get();
        
        $new = 
        $untreated = 
        $closed = 0;

        $tickets->each(
            function($row) use (&$new, &$untreated, &$closed)
            {
                if($row->status == 'close') $closed++;
                else if($row->status == 'wait') $untreated++;
                else
                {
                    $is_new = TicketData::where([
                        ['tickets_id', '=', $row->id],
                        ['is_admin', '=', 0]
                    ])->first();
                    if($is_new) $new++;
                }
            }
        );

        return view('tickets::home')->with([
            'tickets'=>$tickets,
            'new'=>$new,
            'untreated'=>$untreated,
            'closed'=>$closed
        ]);
    }

    /**
     * Chat history
     * @param int $id
     * @return view chat with: ticket_id, subject, name, history, tickets
    */
    public function chat($id)
    {
        $ticket = Ticket::findOrFail($id);
        $status = $ticket->status;
        $name = User::where('id', $ticket->user_id)->value('name');
        $history = TicketData::where('tickets_id', $id)->get();
        if(count($history) > 0)
        {
            $tickets = Ticket::orderBy('id', 'desc')->get();
            
            return view('tickets::chat')->with([
                'ticket_id'=>$id,
                'status'=>$status,
                'subject'=>$ticket->subject,
                'name'=>$name,
                'history'=>$history,
                'tickets'=>$tickets
            ]);
        }
        else return redirect()->route('AdminTicketsHome');
    }

    /**
     * Send message
     * @param int $id
     * @param request $request
     * @param \TicketData $modelData
     * @return mixed
    */
    public function send($id, Request $request, TicketData $modelData)
    {
        $this->validate($request, [
            'text' => 'required|min:2'
        ]);

        $ticket = Ticket::findOrFail($id);
        if($ticket->status != 'close')
        {
            $modelData->tickets_id = $id;
            $modelData->is_admin = 1;
            $modelData->message = $request->input('text');
            $modelData->save();

            return redirect()->route('AdminTicketsChat', $id)->with('status', 'Сообщение было отправлено!');
        }

        return redirect()->route('AdminTicketsHome')->with('status', 'Тикет закрыт!');
    }

    /**
     * Close ticket
     * @param int $id
     * @return mixed
    */
    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'close';
        $ticket->save();

        return redirect()->route('AdminTicketsHome')->with('status', 'Тикет закрыт!');
    }

    /**
     * Destroy ticket
     * @param int $id
     * @return mixed
    */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        
        return redirect()->route('AdminTicketsHome')->with('status', 'Тикет удален!');
    }

    /**
     * Create ticket
     * @param request $request
     * @param \Ticket $model
     * @param \TicketData $modelData
     * @return mixed
    */
    public function create_ticket(Request $request, Ticket $model, TicketData $modelData)
    {
        $this->validate($request, [
            'to' => 'required',
            'subject' => 'required|min:2',
            'message' => 'required|min:2'
        ]);

        $user = User::where('id', $request['to'])->orWhere('email', $request['to'])->first();

        if($user)
        {
            $model->user_id = $user->id;
            $model->from = 'Support';
            $model->subject = $request->input('subject');
            $model->save();

            $modelData->tickets_id = $model->id;
            $modelData->is_admin = 1;
            $modelData->message = $request->input('message');
            $modelData->save();

            return redirect()->route('AdminTicketsHome')->with('status', 'Тикет создан!');
        }
        else return redirect()->route('AdminTicketsHome');
    }
}
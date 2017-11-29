<?php

namespace Selfreliance\tickets;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Selfreliance\Tickets\Models\Ticket;
use Selfreliance\Tickets\Models\TicketData;
use Selfreliance\Tickets\Events\NewMessage;

class TicketsController extends Controller
{
    private $ticket, $ticketData;

    public function __construct(Ticket $model, TicketData $modelData)
    {
        $this->ticket = $model;
        $this->ticketData = $modelData;
    }

    public function index()
    {
    	$tickets = $this->ticket->orderBy('id', 'desc')->get();

        $new = 
        $untreated = 
        $closed = 0;

        $tickets->each(
            function($row) use (&$new, &$untreated, &$closed)
            {
                if($row->status == $this->ticket::statusClose) $closed++;
                else if($row->status == $this->ticket::statusWait) $untreated++;
                else
                {
                    $isNew = TicketData::where([
                        ['tickets_id', '=', $row->id],
                        ['is_admin', '=', 0]
                    ])->orderBy('created_at', 'desc')->first();
                    
                    if($isNew)
                    {
                        if($isNew->read == false && $isNew->is_admin == 0) $new++;
                    }
                }
            }
        );

        return view('tickets::home', compact('tickets', 'new', 'untreated', 'closed'));
    }

    public function chat($id)
    {
        $ticket = $this->ticket->findOrFail($id);
        $ticketID = $ticket->id;
        $ticketStatus = $ticket->status;
        $ticketSubject = $ticket->subject;

        $ticketAuthor = Ticket::where('tickets.id', $ticket->id)
        ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
        ->select('users.name')->first();

        $ticketHistory = TicketData::where('tickets_id', $id)->get();
        if(count($ticketHistory) > 0)
        {
            $tickets = $this->ticket->orderBy('id', 'desc')->get();

            return view('tickets::chat', 
                compact('ticketID', 'ticketStatus', 'ticketSubject', 'ticketAuthor', 'ticketHistory', 'tickets')
            );
        }
        else return redirect()->route('AdminTicketsHome');
    }

    public function send($id, Request $request, TicketData $modelData)
    {
        $this->validate($request, [
            'text' => 'required|min:2'
        ]);

        $ticket = $this->ticket->findOrFail($id);
        if($ticket->status != $this->ticket::statusClose)
        {
            $this->ticketData->notReadAdmin($id)->update([
                'read' => true
            ]);

            $data = [
                'tickets_id' => $ticket->id,
                'is_admin' => 1,
                'message' => $request->input('text')
            ];

            $ticketData = $this->ticketData->create($data);

            if($ticket->status != $this->ticket::statusWait)
                $ticket->setStatus($this->ticket::statusOpen);

            event(new NewMessage($ticket->user_id, intval($id), 1, null, $ticketData, 'Support'));

            flash()->success('Сообщение успешно отправлено');

            return redirect()->route('AdminTicketsChat', $id);
        }
        else
        {
            flash()->error('Тикет закрыт');

            return redirect()->route('AdminTicketsHome');
        }
    }

    public function close($id)
    {
        $ticket = $this->ticket->findOrFail($id);
        
        $ticket->setStatus($this->ticket::statusClose);

        flash()->success('Тикет закрыт');

        return redirect()->route('AdminTicketsHome');
    }

    public function destroy($id)
    {
        $ticket = $this->ticket->findOrFail($id);

        $ticket->ticket_data()->delete();

        $ticket->delete();

        flash()->success('Тикет удален');
        
        return redirect()->route('AdminTicketsHome');
    }

    public function create_ticket(Request $request, Ticket $model, TicketData $modelData)
    {
        $this->validate($request, [
            'to' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $user = \DB::table('users')->where('id', $request['to'])->orWhere('email', $request['to'])->first();

        if($user)
        {
            $data = [
                'user_id' => $user->id,
                'from' => 'Support',
                'subject' => $request->input('subject')
            ];

            $ticket = $this->ticket->create($data);

            $data = [
                'tickets_id' => $ticket->id,
                'is_admin' => 1,
                'message' => $request->input('message')
            ];

            $this->ticketData->create($data);

            event(new NewMessage($user->id, intval($ticket->id), 1, $ticket, null, 'Support'));

            flash()->success('Тикет успешно создан');
        }
        else flash()->error('Пользователь не найден');

        return redirect()->route('AdminTicketsHome');
    }
}
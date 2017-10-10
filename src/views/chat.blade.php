@extends('adminamazing::teamplate')

@section('pageTitle', 'Тикеты')
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">@yield('pageTitle')</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-0">
                                <!-- .chat-row -->
                                <div class="chat-main-box">
                                    <!-- .chat-left-panel -->
                                    <div class="chat-left-aside">
                                        <div class="open-panel"><i class="ti-angle-right"></i></div>
                                        <div class="chat-left-inner">
                                            <ul class="chatonline style-none ">
                                                @foreach($tickets as $ticket)
                                                <li>
                                                    <a class = "{{($ticket->id == $ticket_id) ? 'active' : NULL}}" href = "{{route('AdminTicketsChat', $ticket->id)}}">
                                                        <span>
                                                            @php
                                                                $name_ticket = DB::table('users')->where('id', $ticket->user_id)->value('name')
                                                            @endphp
                                                            {{$name_ticket}}
                                                        </span>
                                                    </a>
                                                </li>
                                                @endforeach
                                                <li class="p-20"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- .chat-left-panel -->
                                    <!-- .chat-right-panel -->
                                    <div class="chat-right-aside">
                                        <div class="chat-main-header">
                                            <div class="p-20 b-b">
                                                <h3 class="box-title">{{$subject}}</h3>
                                            </div>
                                        </div>
                                        <div class="chat-rbox">
                                            <ul class="chat-list p-20">
                                                @foreach($history as $message)
                                                    @if($message->is_admin == 1) 
                                                        <li class="reverse">
                                                            <div class="chat-content">
                                                                <h5>Support</h5>
                                                                <div class="box bg-light-info">{{$message->message}}</div>
                                                            </div>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <div class="chat-content">
                                                                <h5>{{$name}}</h5>
                                                                <div class="box bg-light-success">{{$message->message}}</div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="card-block b-t">
                                            <form action="{{route('AdminTicketsSend', $ticket_id)}}" method="POST" class="form-horizontal">
                                                {{ csrf_field() }} 
                                                <div class="row">
                                                    <div class="col-8">
                                                        <textarea name="text" placeholder="Type your message here" class="form-control b-0"></textarea>
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <button type="submit" class="btn btn-info btn-circle btn-lg"><i class="fa fa-paper-plane-o"></i> </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- .chat-right-panel -->
                                </div>
                                <!-- /.chat-row -->
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
        </div>        
    </div>
    <!-- Column -->
@endsection
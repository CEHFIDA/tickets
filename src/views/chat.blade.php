@extends('adminamazing::teamplate')

@section('pageTitle', 'Тикеты')
@section('content')
    <script>
    var route = '{{ route('AdminTicketsDelete') }}';
    var message = 'Вы точно хотите удалить данный тикет?';
    </script>
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
                                                    <a class="{{($ticket->id == $ticket_id) ? 'active' : NULL}}" href ="{{route('AdminTicketsChat', $ticket->id)}}">
                                                        <span>
                                                            {!! \DB::table('users')->where('id', $ticket->user_id)->value('name') !!}
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
                                                <h3 class="box-title">{{ $subject }}
                                                <a href="#deleteModal" class="delete_toggle" data-id="{{ $ticket_id }}" data-toggle="modal"><i class="fa fa-close text-danger"></i></a>
                                                <a href="{{ route('AdminTicketsClose', $ticket_id) }}"><i class="fa fa-ban text-danger"></i></a>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="chat-rbox">
                                            <ul class="chat-list p-20">
                                            @foreach($history as $letter)
                                                @if($letter->is_admin == 1)
                                                <li class="reverse">
                                                    <div class="chat-content">
                                                        <h5>Support</h5>
                                                        <div class="box bg-light-info">{{ $letter->message }}</div>
                                                    </div>
                                                </li>
                                                @else
                                                <li>
                                                    <div class="chat-content">
                                                        <h5>{{ $name }}</h5>
                                                        <div class="box bg-light-success">{{ $letter->message }}</div>
                                                    </div>
                                                </li>
                                                @endif
                                            @endforeach
                                            </ul>
                                        </div>
                                        @if($status != 'close')
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
                                        @endif
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
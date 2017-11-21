@extends('adminamazing::teamplate')

@section('pageTitle', 'Тикеты')
@section('content')
    @push('scripts')
        <script src="{{ asset('js/socket.io.js') }}"></script>
        <script>
            var socket = io("https://testdev.blockdash.io/socket.io");
            socket.on("userMessages", 
                function(message)
                {
                    if(message.data.new_ticket !== null)
                    {
                        $("#new").text(parseInt($("#new").text()) + 1);
                        $("#count").text(parseInt($("#count").text()) + 1);
                        var route = "{{route('AdminTicketsChat')}}";
                        route = route+'/'+message.data.new_ticket.id;
                        $("#list").prepend("<li><a href="+route+"><span>"+message.data.name+"</span></a></li>");
                    }
                    else
                    {
                        $("#untreated").text(parseInt($("#untreated").text()) + 1);
                    }
                }
            );
            socket.emit("subscribe", "userMessages");
        </script>
    @endpush
    @push('display')
        <button class="btn btn-success" data-toggle="modal" data-target="#createTicket"><i class="fa fa-plus" aria-hidden="true"></i> Создать тикет</button>
    @endpush
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">
                        @yield('pageTitle')
                    </h4>
                    @if(count($tickets) > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="chat-main-box">
                                    <div class="chat-left-aside">
                                        <div class="open-panel"><i class="ti-angle-right"></i></div>
                                        <div class="chat-left-inner">
                                            <ul class="chatonline style-none" id="list">
                                                @foreach($tickets as $ticket)
                                                <li>
                                                    <a href="{{route('AdminTicketsChat', $ticket->id)}}">
                                                        <span>
                                                            {!!DB::table('tickets')->where('tickets.id', $ticket->id)->leftJoin('users', 'tickets.user_id', '=', 'users.id')->select('users.name')->first()->name!!}
                                                        </span>
                                                    </a>
                                                </li>
                                                @endforeach
                                                <li class="p-20"></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="chat-right-aside">
                                        <div class="card card-block">
                                            <div class="row">
                                                <div class="col-md-12 col-lg-12 col-xlg-12">
                                                    <div class="card card-inverse card-success">
                                                        <div class="box bg-success text-center">
                                                            <h1 class="font-light text-white" id="new">{{$new}}</h1>
                                                            <h6 class="text-white">Новых</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-6 col-xlg-6">
                                                    <div class="card card-inverse card-warning">
                                                        <div class="box bg-warning text-center">
                                                            <h1 class="font-light text-white" id="untreated">{{$untreated}}</h1>
                                                            <h6 class="text-white">Необработаных</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-6 col-xlg-6">
                                                    <div class="card card-inverse card-danger">
                                                        <div class="box bg-danger text-center">
                                                            <h1 class="font-light text-white">{{$closed}}</h1>
                                                            <h6 class="text-white">Закрытыхх</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-12 col-xlg-12">
                                                    <div class="card card-inverse card-info">
                                                        <div class="box bg-info text-center">
                                                            <h1 class="font-light text-white" id="count">{{count($tickets)}}</h1>
                                                            <h6 class="text-white">Всего</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert text-center">
                        <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> Information</h3> На данный момент отсутствуют тикеты
                    </div>                              
                    @endif
                    <div class="modal fade" id="createTicket" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{route('AdminTicketsCreate')}}" method="POST" class="form-horizontal">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="user" class="col-md-12">ID или Email пользователя</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="to" id="user">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="subject" class="col-md-12">Тема</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" name="subject" id="subject">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="message" class="col-md-12">Сообщение</label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" name="message" id="message" rows="10"></textarea>
                                            </div>
                                        </div>                                            
                                    </div>
                                    <div class="modal-footer">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success">Создать</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>        
    </div>
@endsection
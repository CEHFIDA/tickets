@extends('adminamazing::teamplate')

@section('pageTitle', 'Тикеты')
@section('content')
    @push('scripts')
        <script>
            var route = '{{ route('AdminTicketsDelete') }}';
            message = 'Вы точно хотите удалить данный тикет?';
        </script>
        <script src="{{ asset('vendor/adminamazing/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('vendor/adminamazing/js/chat.js') }}"></script>
    @endpush
    @push('display')
        <a href="#deleteModal" class="delete_toggle" data-id="{{ $ticketID }}" data-toggle="modal"><button type="submit" class="btn"><i class="fa fa-trash"></i> Удалить</button></a>
        @if($ticketStatus != 'close')
            <a href="{{route('AdminTicketsClose', $ticketID)}}"><button type="submit" class="btn"><i class="fa fa-ban"></i> Закрыть</button></a>
        @endif
    @endpush
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">@yield('pageTitle')</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="card m-b-0">
                                <div class="chat-main-box">
                                    <div class="chat-left-aside">
                                        <div class="open-panel"><i class="ti-angle-right"></i></div>
                                        <div class="chat-left-inner">
                                            <ul class="chatonline style-none ">
                                                @foreach($tickets as $ticket)
                                                <li>
                                                    <a class="{{($ticket->id == $ticketID) ? 'active' : NULL}}" href ="{{route('AdminTicketsChat', $ticket->id)}}">
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
                                        <div class="chat-main-header">
                                            <div class="p-20 b-b">
                                                <div class="col-md-10">
                                                    <h3 class="box-title">{{$ticketSubject}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-rbox">
                                            <ul class="chat-list p-20">
                                            @foreach($ticketHistory as $letter)
                                                @if($letter->is_admin == 1)
                                                <li class="reverse">
                                                    <div class="chat-content">
                                                        <h5>Support</h5>
                                                        <div class="box bg-light-info">{{$letter->message}}</div>
                                                    </div>
                                                </li>
                                                @else
                                                <li>
                                                    <div class="chat-content">
                                                        <h5>{{ $ticketAuthor->name }}</h5>
                                                        <div class="box bg-light-success">{{$letter->message}}</div>
                                                    </div>
                                                </li>
                                                @endif
                                            @endforeach
                                            </ul>
                                        </div>
                                        @if($ticketStatus != 'close')
                                        <div class="card-block b-t">
                                            <form action="{{route('AdminTicketsSend', $ticketID)}}" method="POST" class="form-horizontal">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
        </div>        
    </div>
@endsection
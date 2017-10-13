@extends('adminamazing::teamplate')

@section('pageTitle', 'Тикеты')
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">@yield('pageTitle')</h4>
                    @if(count($tickets) > 0)
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
                                                    <a href="{{route('AdminTicketsChat', $ticket->id)}}">
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
                                         <form action="{{route('AdminTicketsCreate')}}" method="POST" class="form-horizontal">
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
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button class="btn btn-success">Создать тикет</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- .chat-right-panel -->
                                </div>
                                <!-- /.chat-row -->
                            </div>
                        </div>
                    </div>
                    @else
                        <div class = "alert alert-warning text-center">
                            <h4>Тикетов не найдено!</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>        
    </div>
    <!-- Column -->
@endsection
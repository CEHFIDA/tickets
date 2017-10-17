@extends('adminamazing::teamplate')

@section('pageTitle', 'Тикеты')
@section('content')
    <div class="text-right"><button class="btn btn-success" data-toggle="modal" data-target="#createTicket">Создать тикет</button></div>
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
                                    </div>
                                    <!-- .chat-right-panel -->
                                </div>
                                <!-- /.chat-row -->
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <h4>Тикетов не найдено!</h4>
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
                                        {{ csrf_field() }}
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
    <!-- Column -->
@endsection
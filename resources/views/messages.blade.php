@extends('index')

@section('message_header')
<h1 style="font-size: 140%;">{{$_COOKIE['user_name']}}</h1>
@endsection
@section('people')
    <div class="card text-bg-dark mb-3" style="max-width: 18rem;">
        <figure class="text-center">
        <div class="card-header">

            <button type="submit" class="btn btn-outline-light" onclick="show_page_friend()">Чаты</button>


            <button type="button" class="btn btn-outline-light position-relative" onclick="show_page()">
                Заявки в друзья
                @if($count_friend>0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    {{$count_friend}}
    <span class="visually-hidden">unread messages</span>
  </span>
                @endif
            </button>

        </div>
        </figure>

        <div class="card-body">
            <div class="page_friend_new">
                @if(isset($check_friends) && $check_friends != null)
                    @foreach($check_friends as $key => $value)
                        @if($value['state']=="not_confirmed")
                            <form method="GET" action="messages">
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <input type="hidden" name="name_user" value="{{$key}}">
                                <button type="button" class="btn btn-outline-secondary" disabled>{{$key}}</button>
                                <button type="submit" name="do_friend" value="notagree" class="btn btn-danger">отклонить</button>
                                <button type="submit" name="do_friend" value="agree" class="btn btn-success">принять</button>
                            </div>
                            </form>
                        @endif
                    @endforeach
                @endif
            </div>
          <div class="page_friend">
            <form method="GET" action="messages">

            <div class="input-group mb-3">
                <input type="text" name="login" class="form-control" placeholder="Введите логин" aria-label="Введите логин" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Добавить</button>
            </div>
            </form>
            <div class="d-grid gap-2">
                {{$flag_friend=false}}
                @if(isset($friends) && $friends != null)
                        @foreach($friends as $key => $value)
                            @if($value['state'] == "confirm")
                            <form method="post" action="friend_message">
                                @csrf
                            <input type="hidden" name="friend" value="{{$key}}">
                                <button class="btn btn-outline-light" type="submit" style="width: 100%;">{{$key}}</button>
                            </form>
                              <input type="hidden" {{$flag_friend=true}}>
                            @endif
                        @endforeach
                @else
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Пока друзей нет, наберить выше логин и отправьте заявку, удачи!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                @endif
                @if($flag_friend == false)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Пока друзей нет, наберить выше логин и отправьте заявку, удачи!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                    @endif
            </div>
          </div>
        </div>

    </div>
@endsection
@section('message')
 <div class="--dark-theme" id="chat">
     <div id="messages2" class="chat__conversation-board">
         @if(isset($messages) && $messages != null)
                 @foreach($messages as $key => $value)
                     @if($value['From'] == "me")
                         <div class="chat__conversation-board__message-container reversed">
                             <div class="chat__conversation-board__message__person">
                                 <div class="chat__conversation-board__message__person__avatar"><img src="https://randomuser.me/api/portraits/men/9.jpg" alt="Dennis Mikle"/></div><span class="chat__conversation-board__message__person__nickname">Dennis Mikle</span>
                             </div>
                             <div class="chat__conversation-board__message__context">
                                 <div class="chat__conversation-board__message__bubble"> <span>{{$key}}</span></div>
                             </div>
                         </div>
                         @elseif($value['From'] == "other")
                         <div class="chat__conversation-board__message-container">
                             <div class="chat__conversation-board__message__person">
                                 <div class="chat__conversation-board__message__person__avatar"><img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Monika Figi"/></div><span class="chat__conversation-board__message__person__nickname">Monika Figi</span>
                             </div>
                             <div class="chat__conversation-board__message__context">
                                 <div class="chat__conversation-board__message__bubble"> <span>{{$key}}</span></div>
                             </div>
                         </div>

                     @endif
                 @endforeach
         @elseif(isset($messages))

             <div class="alert alert-warning alert-dismissible fade show" role="alert">
                 Пока сообщений нет, напишите первый, удачи!
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>

         @endif
     </div>
     <form id="message_form2">
     <div class="chat__conversation-panel">
         <div class="chat__conversation-panel__container">
             <button class="chat__conversation-panel__button panel-item btn-icon add-file-button">
                 <svg class="feather feather-plus sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                     <line x1="12" y1="5" x2="12" y2="19"></line>
                     <line x1="5" y1="12" x2="19" y2="12"></line>
                 </svg>
             </button>
             <button class="chat__conversation-panel__button panel-item btn-icon emoji-button">
                 <svg class="feather feather-smile sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                     <circle cx="12" cy="12" r="10"></circle>
                     <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                     <line x1="9" y1="9" x2="9.01" y2="9"></line>
                     <line x1="15" y1="9" x2="15.01" y2="9"></line>
                 </svg>
             </button>
             <input type="text" name="message" id="message_input" class="chat__conversation-panel__input panel-item" placeholder="Type a message..."/>
             <button type="submit" class="chat__conversation-panel__button panel-item btn-icon send-message-button">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" data-reactid="1036">
                     <line x1="22" y1="2" x2="11" y2="13"></line>
                     <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                 </svg>
             </button>
         </div>
     </div>
     </form>
 </div>
@endsection
@section('button_header')
    <div class="btn-group" role="group" aria-label="Basic example">
        <form method="GET" action="auth">
            <button type="submit" style="" class="btn btn-outline-light">Авторизация</button>
        </form>
        <form method="GET" action="/public">
            <button type="submit" class="btn btn-outline-light">Регистрация</button>
        </form>
        <form method="GET" action="messages">
            <button type="submit" class="btn btn-outline-light">Сообщения</button>
        </form>
        <form method="GET" action="exit">
            <button type="submit" class="btn btn-outline-light">Выход</button>
        </form>
    </div>
@endsection


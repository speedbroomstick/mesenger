@extends('index')

@section('main_header')
    <h1>Авторизация</h1>
    @section('main')
        <br>
        <form method="post" action="auth1">
            @csrf

            <div class="container-fluid h-100">
                <div class="row align-items-center h-100">
                    <div class="col-sm-12">
                        <div class="row justify-content-center">
                            <div class="col-5 text-center">
                                <div style="text-align: center;">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Логин</label>
                                        <input type="text" name="login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Пароль</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                                    </div>
                                    <form id="registr">
                                        <button type="submit" class="btn btn-outline-success">Вход</button><br><br>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endsection
@endsection
@section('href')
    <div class="btn-group" role="group" aria-label="Basic example">
        <form method="GET" action="auth">
            <button type="submit" style="" class="btn btn-outline-light">Авторизация</button>
        </form>
        <form method="GET" action="/public">
            <button type="submit" class="btn btn-outline-light">Регистрация</button>
        </form>
        @if(isset($_COOKIE['state_r']))
            <form method="GET" action="messages">
                <button type="submit" class="btn btn-outline-light">Сообщения</button>
            </form>
            <form method="GET" action="exit">
                <button type="submit" class="btn btn-outline-light">Выход</button>
            </form>
        @endif
    </div>
@endsection

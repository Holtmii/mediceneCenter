@extends('layouts.app')

@section('content')
        <div class="align-items-center" style="margin-left: 40%; margin-top: 20%">
            @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" role="button" class="btn btn-secondary">Домашняя</a>
                        <a href="{{ url('/students') }}" role="button" class="btn btn-secondary">Студенты</a>
                        <a href="{{ url('/vactinations') }}" role="button" class="btn btn-secondary">Вакцинации</a>
                    @else
                        <a href="{{ route('login') }}" role="button" class="btn btn-secondary">Войти</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" role="button" class="btn btn-secondary">Зарегистрироваться</a>
                        @endif
                    @endauth
            @endif
        </div>

@endsection

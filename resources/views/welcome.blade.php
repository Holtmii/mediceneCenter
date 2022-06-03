@extends('layouts.app')

@section('content')
        <div class="align-items-center">
            @if (Route::has('login'))
                <div class="container" style="align-content: center; text-align: center; margin-top: 8%">
                    <img style="width: 30%" alt="" src="https://psv4.vkuseraudio.net/s/v1/d/9KJR4LE_MlsWjaplkREqbDIqV2nGOsISaZ6hkVJA1Cp1PVsLM9fNBf5Yi-2ixC3wTQ2cPlS5J8ywh3RpiIcwcgs7ZdVbz4uTgdcnQhL20G-P6fg3EXYYxg/logo-removebg-preview.png">
                    @auth
                        <h3>Выберите вкладку для работы</h3>
{{--                        <a href="{{ url('/home') }}" role="button" class="btn btn-secondary">Домашняя</a>--}}
                        <a href="{{ url('/students') }}" role="button" class="btn btn-secondary">Студенты</a>
                        <a href="{{ url('/flg') }}" role="button" class="btn btn-secondary">Флюорографии</a>
                        <a href="{{ url('/vactinations') }}" role="button" class="btn btn-secondary">Вакцинации</a>
                    @else
                        <h2>Приветствуем вас на сайте здравпункта!</h2>
                        <h3>Для дальнейшей работы пройдите авторизацию.</h3>
                        <a href="{{ route('login') }}" role="button" class="btn btn-secondary">Войти</a>
                    @endauth
                </div>
            @endif
        </div>

@endsection

@extends('layouts.app')

@section('content')
    <div class="container">

        <h3>Просмотр студента: имя - {{ $students->name }}</h3>

        <div class="col s12 m7">
            {{--            <h2 class="header">Horizontal Card</h2>--}}
            <div class="card horizontal">
                <div class="card-image">
                    <img src="{{ $students->picture }}">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <p><strong>ФИО:</strong> {{ $students->surname }} {{ $students->name }} {{ $students->middlename }}</p>
                        <p><strong>Телефон:</strong> {{ $students->phone }}</p>
                    </div>
                    <div class="card-action">
                        @if (Auth::check() && Auth::user()->admin == true)
                            <a href="{{ route('students.edit', $students) }}" class="btn btn-warning">Редактировать</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

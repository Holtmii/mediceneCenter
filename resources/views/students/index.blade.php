@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Студенты</h1>
                <a href="{{ url('/export') }}" role="button" class="btn btn-secondary">Скачать отчет</a>
            </div>
            <div class="col-md-10">
                <table  class="table" style="margin: 10px">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Телефон</th>
{{--                        <th></th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($students as $student)
                        <tr>
                            <td>{{$student->name}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->middlename}}</td>
                            <td>{{$student->phone}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection

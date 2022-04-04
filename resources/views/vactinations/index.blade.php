@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Вакцинации</h1>
                <a href="{{ url('/exportVac') }}" role="button" class="btn btn-secondary">Скачать отчет</a>
            </div>
            <div class="col-md-10">
                <table  class="table" style="margin: 10px">
                    <thead>
                    <tr>
                        <th>Доза</th>
                        <th>Врач</th>
                        <th>Вакцина</th>
                        <th>Студенты</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($vaccines as $vaccine)
                        <tr>
                            <td>{{$vaccine->dose}}</td>
                            <td>{{$vaccine->user_id}}</td>
                            <td>{{$vaccine->vaccine_id}}</td>
                            <td>{{$vaccine->student_id}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection

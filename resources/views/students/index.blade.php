@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-around">
            <div class="col-md-5">
                <h1>Студенты</h1>
                <a href="{{route('generateDocx', $request) }}" role="button" class="btn btn-secondary">Скачать отчет</a>
            </div>

            <div class="col-md-5" >
                <form style="margin-left: 100px" action="{{ route('students.index') }}" method="GET">
                    <select style="width: 75%" class="form-select" name="name" id="input">
                        @if($groupFiltered != null && $groupFiltered != "0")
                            <option value="{{ $groupFiltered }}" selected="true" disabled="disabled">Выбрано : {{ $groupFiltered }}</option>
                        @else
                            <option value="0" selected="true" disabled="disabled">Выбирите группу</option>
                        @endif
                        @foreach ($groups as $group)
                            <option value="{{$group->name}}">
                                {{$group->name}}
                            </option>
                        @endforeach
                    </select>
                    <br>
                    <input type="submit" class="btn btn-info" value="Фильтрация">
                    <a href="{{ url('/students') }}" role="button" class="btn btn-secondary">Очистить</a>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <table  class="table" style="margin: 10px">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Телефон</th>
                        <th>Группа</th>
                        <th>Факультет</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($students as $student)
                        <tr>
                            <td>{{$student->name}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->middlename}}</td>
                            <td>{{$student->phone}}</td>

                            @foreach($groups as $group)
                                @if($student->group_id == $group->id)
                                    <td>{{$group->name}}</td>
                                    <td>{{$group->faculty}}</td>
                                @endif
                            @endforeach

                            @if (Route::has('login'))
                                @if (Auth::check() && Auth::user()->admin == true)
                                    <td class="center">
                                        <form method="POST" action="{{ route('students.destroy', $student->id) }}">
                                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Редактировать</a>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger" type="submit" name="action">Удалить</button>
                                        </form>
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

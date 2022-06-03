@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Флюорографии</h1>
                <a href="{{ route('flg.create') }}" role="button" class="btn btn-secondary">Создать запись флюорографии</a>
            </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <form action="{{ route('students.index') }}" method="GET" style="margin-top: 20px;">
                        <select name="name" id="input">
                            <option value="0">Select group</option>
                            @foreach ($groups as $group)
                                <option value="{{$group->name}}">
                                    {{$group->name}}
                                </option>
                            @endforeach
                        </select>
                        <input type="submit" class="btn btn-danger btn-sm" value="Filter">
                    </form>
                    <div class="form-group">
                        <select onchange="filter(this.value)" name="name" id="name" class="form-control custom-control">
                            @if(sizeof($groups) > 1)

                                    <option value="" selected disabled>Выберите группу</option>
                                @foreach($groups as $group)
                                    <option value="{{$group->name}}">{{$group->name}}</option>
                                @endforeach
                            @else
                                @foreach($groups as $group)
                                    <option value="{{$group->name}}">{{$group->name}}</option>
                                @endforeach
                            @endif

                        </select>
{{--                        <a href="{{ url('/studentsSort') }}" role="button" class="btn btn-secondary">Фильтрация</a>--}}
{{--                        <a href="{{ route('students.index', $fl->id) }}" role="button" class="btn btn-secondary">Фильтрация</a>--}}

                        <a href="{{ url('/students') }}" role="button" class="btn btn-secondary">Сброс</a>
                    </div>
                </div>
            <div class="col-md-10">
                <table  class="table" style="margin: 10px">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Результат</th>
                        <th>Врач</th>
                        <th>Студент</th>
                        <th>Группа</th>
                        <th>Факультет</th>
{{--                        <th></th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($flgs as $fl)
                        <tr>
                            <td>{{$fl->created_at}}</td>
                            <td>{{$fl->result}}</td>
                            @foreach($users as $user)
                                @if($fl->user_id == $user->id)
                                    <td>{{$user->name}}</td>
                                @endif
                            @endforeach
                            @foreach($students as $student)
                                @if($fl->student_id == $student->id)
                                    <td>{{$student->name}}</td>
                                @endif
                            @endforeach
                            @foreach($groups as $group)
                                @if($student->group_id == $group->id)
                                    <td>{{$group->name}}</td>
                                    <td>{{$group->faculty}}</td>
                                @endif
                            @endforeach

                            @if (Route::has('login'))
                                @if (Auth::check() && Auth::user()->admin == true)
                                    <td class="center">
                                        <form method="POST" action="{{ route('flg.destroy', $fl->id) }}">
                                            <a href="{{ route('flg.edit', $fl->id) }}" class="btn btn-warning">Редактировать</a>
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger ajax" type="submit" name="action">Удалить</button>
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

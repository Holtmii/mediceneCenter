@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row justify-content-around">
                <div class="col-md-5">
                    <h1>Флюорографии</h1>
                    <a href="{{ route('flg.create') }}" role="button" class="btn btn-secondary">Создать запись флюорографии</a>
                </div>

                <div class="col-md-5" >
                    <form style="margin-left: 100px" action="{{ route('flg.index') }}" method="GET">
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
                        <a href="{{ url('/flg') }}" role="button" class="btn btn-secondary">Очистить</a>
                    </form>
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
                                <td>{{$fl->grname}}</td>
                                <td>{{$group->faculty}}</td>

                            @if (Route::has('login'))
                                @if (Auth::check() && Auth::user()->admin == true)
                                    <td class="center">
                                        <form method="POST" action="{{ route('flg.destroy', $fl->id) }}">
                                            <a href="{{ route('flg.edit', $fl->id) }}" class="btn btn-warning">Редактировать</a>
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

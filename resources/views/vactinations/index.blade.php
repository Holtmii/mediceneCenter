@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-md-5">
                <h1>Вакцинации</h1>
                <a href="{{ route('vactinations.create') }}" role="button" class="btn btn-secondary">Создать запись вакцинации</a>
            </div>

            <div class="col-md-5" >
                <form style="margin-left: 100px" action="{{ route('vactinations.index') }}" method="GET">
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
                    <a href="{{ url('/vactinations') }}" role="button" class="btn btn-secondary">Очистить</a>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <table  class="table" style="margin: 10px">
                    <thead>
                        <tr>
                            <th>Студент</th>
                            <td>Группа</td>
                            <th>Вакцина</th>
                            <th>Дата</th>
                            <th>Доза</th>
                            <th>Врач</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vaccines as $vaccine)
                            <tr>
                                <td>{{$vaccine->stud_fio}}</td>
                                <td>{{$vaccine->grname}}</td>
                                <td>{{$vaccine->vacname}}</td>
                                <td>{{$vaccine->date}}</td>
                                <td>{{$vaccine->dose}}</td>
                                <td>{{$vaccine->doc}}</td>
                                @if (Route::has('login'))
                                    @if (Auth::check() && Auth::user()->admin == true)
                                        <td class="center">
                                            <form method="POST" action="{{ route('vactinations.destroy', $vaccine->id) }}">
                                                <a href="{{ route('vactinations.edit', $vaccine->id) }}" class="btn btn-warning">Редактировать</a>
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-danger" type="submit" name="action">Удалить</button>
                                            </form>
                                        </td>
                                    @endif
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

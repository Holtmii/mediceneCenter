@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h4>Создание записи студента</h4>
                <form method="POST" @if (isset($students)) action="{{ route('students.update', $students) }}"
                      @else
                      action="{{ route('students.store') }}" @endif>
                    {{ isset($students) ? method_field('PUT') : method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-top: 10px">
                        <label for="name">Имя</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', isset($students) ? $students->name : null) }}">
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="surname">Фамилия</label>
                        <input class="form-control" type="text" id="surname" name="surname" value="{{ old('surname', isset($students) ? $students->surname : null) }}">
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="middlename">Отчество</label>
                        <input class="form-control" type="text" id="middlename" name="middlename" value="{{ old('middlename', isset($students) ? $students->middlename : null) }}">
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="phone">Телефон</label>
                        <input class="form-control" id="phone" name="phone" value="{{ old('phone', isset($students) ? $students->phone : null) }}">
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="group_id">Группа</label>
                            <select class="form-select" name="group_id" id="group_id">
                                <option value="{{ old('user_id', isset($students) ? $students->group_id : null) }}" selected="true" disabled="disabled">
                                @foreach($groups as $group)
                                    @if(isset($students) && $group->id == $students->group_id)
                                        {{$group->name}}
                                    @endif
                                @endforeach
                                    @if(!isset($students))
                                        Выбирите группу
                                    @endif
                                </option>
                                @foreach ($groups as $group)
                                    <option value="{{$group->id}}">
                                        {{$group->name}}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-3" style="margin-top: 3%; text-align: center; width: 100%;">
                        <button class="btn btn-success waves-effect waves-light" type="submit"
                                name="action">{{ isset($students) ? 'Обновить' : 'Добавить' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

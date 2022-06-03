@extends('layouts.app')

@section('content')
    <div class="container" style="align-content: center">
        <h4>Создание записи студента</h4>
        <form method="POST" @if (isset($students)) action="{{ route('students.update', $students) }}"
              @else
              action="{{ route('students.store') }}" @endif>
            {{ isset($students) ? method_field('PUT') : method_field('POST') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Имя</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name', isset($students) ? $students->name : null) }}">
            </div>

            <div class="form-group">
                <label for="surname">Фамилия</label>
                <input class="form-control" type="text" id="surname" name="surname" value="{{ old('surname', isset($students) ? $students->surname : null) }}">
            </div>

            <div class="form-group">
                <label for="middlename">Отчество</label>
                <input class="form-control" type="text" id="middlename" name="middlename" value="{{ old('middlename', isset($students) ? $students->middlename : null) }}">
            </div>

            <div class="form-group">
                <label for="phone">Телефон</label>
                <input class="form-control" id="phone" name="phone" value="{{ old('phone', isset($students) ? $students->phone : null) }}">
            </div>

            <div class="form-group" style="visibility: hidden">
                <label for="group_id">Телефон</label>
                <input class="form-control" id="group_id" name="group_id" value="{{ old('group_id', isset($students) ? $students->group_id : 1) }}">
            </div>

            <div class="row">
                <button class="btn btn-warning waves-effect waves-light" type="submit"
                        name="action">{{ isset($students) ? 'Обновить' : 'Добавить' }}</button>
            </div>
        </form>
    </div>
@endsection

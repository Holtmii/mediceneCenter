@extends('layouts.app')

@section('content')
    <div class="container" style="align-content: center">
        <h4>Создание записи флюорографии</h4>
        <form method="POST" @if (isset($flgs)) action="{{ route('flg.update', $flgs) }}"
              @else
              action="{{ route('flg.store') }}" @endif>
            {{ isset($flgs) ? method_field('PUT') : method_field('POST') }}
            {{ csrf_field() }}
            <div class="form-group">
                <label for="result">Результат</label>
                <input class="form-control" type="text" id="result" name="result" value="{{ old('result', isset($flgs) ? $flgs->result : null) }}">
            </div>

            <div class="form-group">
                <label for="user_id">Врач</label>
                <input class="form-control" type="text" id="user_id" name="user_id" value="{{ old('user_id', isset($flgs) ? $flgs->user_id : 1) }}">
            </div>

            <div class="form-group">
                <label for="student_id">Студент</label>
                <input class="form-control" type="text" id="student_id" name="student_id" value="{{ old('student_id', isset($flgs) ? $flgs->student_id : 2) }}">
            </div>

            <div class="row">
                <button class="btn btn-warning waves-effect waves-light" type="submit"
                        name="action">{{ isset($students) ? 'Обновить' : 'Добавить' }}</button>
            </div>
        </form>
    </div>
@endsection

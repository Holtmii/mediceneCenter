@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row justify-content-center">
{{--        <div class="container" style="align-content: center">--}}
        <div class="col-md-5">
            <h3 style="font-weight: bold;">Создание записи флюорографии</h3>
{{--            {{dd($flgs)}}--}}
            <form method="POST" @if (isset($flgs)) action="{{ route('flg.update', $flgs->id) }}"
                  @else
                  action="{{ route('flg.store') }}" @endif>
                {{ isset($flgs) ? method_field('PUT') : method_field('POST') }}
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="result">Результат</label>
                    <input class="form-control" type="text" id="result" name="result" value="{{ old('result', isset($flgs) ? $flgs->result : null) }}">
                </div>
<br>
                <div class="form-group">
                    <label for="user_id">Врач</label>
{{--                    <input class="form-control" type="text" id="user_id" name="user_id" value="{{ old('user_id', isset($flgs) ? $flgs->user_id : 1) }}">--}}
                    <select class="form-select" name="user_id" id="user_id">
                        <option value="{{ old('user_id', isset($flgs) ? $flgs->user_id : null) }}" selected="true" disabled="disabled">Выбирите мед.работника</option>

                        @foreach ($users as $user)
                            <option value="{{$user->id}}">
                                {{$user->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="student_id">Студент</label>

{{--                    <input class="form-control" type="text" id="student_id" name="student_id" value="{{ old('student_id', isset($flgs) ? $flgs->student_id : 2) }}">--}}
                    <select class="form-select" name="student_id" id="student_id">
                        <option value="{{ old('student_id', isset($flgs) ? $flgs->student_id : null) }}" selected="true" disabled="disabled">
                            @foreach ($students as $stud)
                                @if (isset($flgs) && $stud->id == $flgs->student_id)
                                    @foreach ($groups as $student)
                                        @if ($student->id == $stud->id)
                                            {{"$student->grname"}}
                                        @endif
                                    @endforeach
                                @else

                                @endif
                            @endforeach
                            @if(!isset($flgs))
                                    Выберите студента
                            @endif
                        </option>
                        @foreach ($groups as $student)
                            <option value="{{$student->id}}">
                                {{$student->grname}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3" style="margin-top: 3%; text-align: center; width: 100%;">
                    <button class="btn btn-success waves-effect waves-light" type="submit"
                            name="action">{{ isset($flgs) ? 'Обновить' : 'Добавить' }}</button>
                </div>
            </form>
        </div>

{{--        </div>--}}
    </div>
    </div>
@endsection

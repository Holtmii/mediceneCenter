@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h4>Создание записи вакцинации</h4>
                <form method="POST" @if (isset($vactinations)) action="{{ route('vactinations.update', $vactinations) }}"
                      @else
                      action="{{ route('vactinations.store') }}" @endif>
                    {{ isset($vactinations) ? method_field('PUT') : method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-top: 10px">
                        <label for="date">Дата</label>
                        <input class="form-control" type="text" id="date" name="date" value="{{ old('date', isset($vactinations) ? $vactinations->date : null) }}">
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="student_id">Студент</label>
                        <select class="form-select" name="student_id" id="student_id">
                            <option value="{{ old('student_id', isset($vactinations) ? $vactinations->student_id : null) }}" selected="true" disabled="disabled">
                                @foreach ($students as $stud)
                                    @if (isset($vactinations) && $stud->id == $vactinations->student_id)
                                        {{$stud->studname}}
                                    @endif
                                @endforeach
                                @if(!isset($vactinations))
                                    Выберите студента
                                @endif
                            </option>
                            @foreach ($students as $stud)
                                <option value="{{$stud->id}}">
                                    {{$stud->studname}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="vaccine_id">Вакцина</label>
{{--                        <input class="form-control" type="text" id="vaccine_id" name="vaccine_id" value="{{ old('vaccine_id', isset($vactinations) ? $vactinations->vaccine_id : null) }}">--}}
                        <select class="form-select" name="vaccine_id" id="vaccine_id">
                            <option value="{{ old('vaccine_id', isset($vactinations) ? $vactinations->vaccine_id : null) }}" selected="true" disabled="disabled">
                                @foreach ($vaccines as $vac)
                                    @if (isset($vactinations) && $vac->id == $vactinations->vaccine_id)
                                        {{$vac->name}}
                                    @endif
                                @endforeach
                                @if(!isset($vactinations))
                                    Выберите вакцину
                                @endif
                            </option>
                            @foreach ($vaccines as $vac)
                                <option value="{{$vac->id}}">
                                    {{$vac->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="dose">Доза</label>
                        <input class="form-control" type="text" id="dose" name="dose" value="{{ old('dose', isset($vactinations) ? $vactinations->dose : null) }}">
                    </div>

                    <div class="form-group" style="margin-top: 10px">
                        <label for="user_id">Мед.работник</label>
{{--                        <input class="form-control" id="user_id" name="user_id" value="{{ old('user_id', isset($vactinations) ? $vactinations->user_id : null) }}">--}}
                        <select class="form-select" name="user_id" id="student_id">
                            <option value="{{ old('user_id', isset($vactinations) ? $vactinations->doc_id : null) }}" selected="true" disabled="disabled">
                                {{ old('user_id', isset($vactinations) ? $vactinations->doc : "Выберите мед. работника") }}

{{--                                @foreach ($users as $user)--}}
{{--                                    @if (isset($vactinations) && $user->id == $vactinations->user_id)--}}
{{--                                        {{$user->name}}--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                                @if(!isset($vactinations))--}}
{{--                                    Выберите мед. работника--}}
{{--                                @endif--}}
                            </option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">
                                    {{$user->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

{{--                    <div class="form-group" style="margin-top: 10px">--}}
{{--                        <label for="group_id">Группа</label>--}}
{{--                        <select class="form-select" name="group_id" id="group_id">--}}
{{--                            <option value="{{ old('user_id', isset($vactinations) ? $vactinations->group_id : null) }}" selected="true" disabled="disabled">--}}
{{--                                @foreach($groups as $group)--}}
{{--                                    @if(isset($vactinations) && $group->id == $vactinations->group_id)--}}
{{--                                        {{$group->name}}--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                                @if(!isset($vactinations))--}}
{{--                                    Выбирите группу--}}
{{--                                @endif--}}
{{--                            </option>--}}
{{--                            @foreach ($groups as $group)--}}
{{--                                <option value="{{$group->id}}">--}}
{{--                                    {{$group->name}}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
                    <div class="col-md-3" style="margin-top: 3%; text-align: center; width: 100%;">
                        <button class="btn btn-success waves-effect waves-light" type="submit"
                                name="action">{{ isset($vactinations) ? 'Обновить' : 'Добавить' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

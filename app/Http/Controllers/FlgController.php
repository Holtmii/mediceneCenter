<?php

namespace App\Http\Controllers;

use App\Models\Flgs;
use App\Models\Groups;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groupFiltered = $request->query('name');

        if ($groupFiltered != null && $groupFiltered != "0") {
            $grNum = DB::select(
                DB::raw("select id from \"groups\" g where \"name\" = '$groupFiltered'"))[0];
            $grNum = get_object_vars($grNum)['id'];

            $groups = Groups::get();

            $flgs = DB::select(
                DB::raw("select f.*, g.id as grId, g.name as grName from students s
                                join flgs f ON f.student_id = s.id
                                join \"groups\" g on g.id = s.group_id
                                where g.id = '$grNum'")
            );
        } else {
            $flgs = DB::select(
                DB::raw("select f.*, g.id as grId, g.name as grName from students s
                                join flgs f ON f.student_id = s.id
                                join \"groups\" g on g.id = s.group_id")
            );

            $groups = Groups::get();
        }
//dd($request, $groupFiltered, $flgs, $groups);
//        return View('students.index', compact('students', 'groups', 'names', 'groupFiltered', 'request'));

//        $flgs = Flgs::get();
//        $groups = Groups::get();
        $users = User::get();
        $students = Students::get();

//        dd($flgs, $groups, $users, $students, $groupFiltered);
        return View('flg.index', compact('flgs', 'groups', 'users', 'students', 'groupFiltered'));
//        $groupFiltered = "0";
//        $flgs = Flgs::get();
//        $groups = Groups::get();
//        $users = User::get();
//        $students = Students::get();
//
//        return View('flg.index', compact('flgs', 'groups', 'users', 'students', 'groupFiltered'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();
        $students = Students::get();
        $groups = Groups::get();

        $groups = DB::select(
            DB::raw("select s.*, (s.surname || ' '|| s.name || ' : группа - ' ||g.\"name\") as grName from students s join \"groups\" g on g.id = s.group_id ")
        );

        return View('flg.create', compact('students', 'users', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Flgs::create($request->all());
        return Redirect('flg');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::get();
        $students = Students::get();
        $groups = DB::select(
            DB::raw("select s.*, (s.surname || ' '|| s.name || ' : группа - ' ||g.\"name\") as grName from students s join \"groups\" g on g.id = s.group_id ")
        );

        $flgs = Flgs::find($id);
        return View('flg.create', compact('flgs', 'users', 'students', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $flgs = Flgs::find($id);
        $flgs->update($request->only(['result', 'user_id', 'student_id']));
        return redirect()->route('flg.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $flg = Flgs::find($id);
        $flg->delete();
        return redirect()->route('flg.index');
    }
}


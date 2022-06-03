<?php

namespace App\Http\Controllers;

use App\Exports\VacExport;
use App\Models\Groups;
use App\Models\Students;
use App\Models\User;
use App\Models\Vaccines;
use App\Models\Vactination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use function Sodium\compare;

class VactinationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\Symfony\Component\HttpFoundation\Request $request)
    {
        $groupFiltered = $request->query('name');

        if ($groupFiltered != null && $groupFiltered != "0") {
            $grNum = DB::select(
                DB::raw("select id from \"groups\" g where \"name\" = '$groupFiltered'"))[0];
            $grNum = get_object_vars($grNum)['id'];

            $groups = Groups::get();

            $vaccines = DB::select(
                DB::raw("select v.*, u.name as doc, (s.name || ' ' || s.surname || ' ' || s.middlename) as stud_fio, v2.\"name\" as vacName, g.\"name\" as grName from vactinations v
                join students s on s.id  = v.student_id
                join users u on u.id = v.user_id
                join vaccines v2 on v2.id = v.vaccine_id
                join \"groups\" g on g.id = s.group_id
                where g.id = '$grNum'"
                )
            );
        } else {
            $vaccines = DB::select(
                DB::raw("select v.*, u.name as doc, (s.name || ' ' || s.surname || ' ' || s.middlename) as stud_fio, v2.\"name\" as vacName, g.\"name\" as grName from vactinations v
                join students s on s.id  = v.student_id
                join users u on u.id = v.user_id
                join vaccines v2 on v2.id = v.vaccine_id
                join \"groups\" g on g.id = s.group_id "
                )
            );

            $groups = Groups::get();
        }

        return View('vactinations.index', compact('vaccines', 'groups', 'groupFiltered'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = DB::select(
            DB::raw("select s.*, (s.surname || ' '|| s.name || ' : группа - ' ||g.\"name\") as studName from students s join \"groups\" g on g.id = s.group_id ")
        );
        $vaccines = Vaccines::get();
        $groups = Groups::get();
        $users = User::get();
        return View('vactinations.create', compact('students', 'vaccines', 'users', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Vactination::create($request->all());
        return Redirect('vactinations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vaccines = Vactination::find($id);
        return View('vactinations.show')
            ->with('vactinations', $vaccines);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $students = DB::select(
            DB::raw("select s.*, (s.surname || ' '|| s.name || ' : группа - ' ||g.\"name\") as studName from students s join \"groups\" g on g.id = s.group_id ")
        );
        $vactinations = Vactination::find($id);
        $vactinationsAll = DB::select(
        DB::raw("select v.*, u.name as doc, u.id as doc_id, v2.id as vac_id, (s.name || ' ' || s.surname || ' ' || s.middlename) as stud_fio, v2.\"name\" as vacName, g.\"name\" as grName from vactinations v
                join students s on s.id  = v.student_id
                join users u on u.id = v.user_id
                join vaccines v2 on v2.id = v.vaccine_id
                join \"groups\" g on g.id = s.group_id"
        )
    );
        $groups = Groups::get();
        $users = User::get();
        $vaccines = Vaccines::get();
//        dd($groups, $vactinationsAll, $vactinations);
        return View('vactinations.create', compact('students', 'vactinations', 'groups', 'vactinationsAll', 'users', 'vaccines'));
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
        $vactination = Vactination::find($id);
//        dd($vactination, $request);
        $vactination->update($request->only(['dose', 'date', 'user_id', 'student_id', 'vaccine_id']));
        return redirect()->route('vactinations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vactination $vaccines)
    {
        $vaccines->delete();
        return redirect()->route('vactinations.index');
    }

    public function exportVac()
    {
        return Excel::download(new VacExport(), 'vaccines.xlsx');
    }


}

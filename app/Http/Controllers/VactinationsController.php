<?php

namespace App\Http\Controllers;

use App\Exports\VacExport;
use App\Models\Vactination;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VactinationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vaccines = Vactination::get();
        return View('vactinations.index', compact('vaccines'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('vactinations.create');
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
        $vaccines = Vactination::find($id);
        return View('vactinations.create')
            ->with('vactinations', $vaccines);
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
        $vaccines->update($request->only(['name', 'surname', 'middlename', 'phone']));
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

<?php

namespace App\Http\Controllers;

use App\Exports\QueryExports;
use App\Exports\TestExports;
use App\Models\Groups;
use App\Models\Students;
use App\Http\Requests\StoreStudentsRequest;
use App\Http\Requests\UpdateStudentsRequest;
use App\Exports\UsersExport;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Request;

class StudentsController extends Controller
{

    public function takeParam(Request $request){

        $groups = Groups::get()->where('id', '1');

        $students = Students::get()->where('group_id', '1');

        return View('students.index', compact('students', 'groups'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        $groupFiltered = $request->query('name');
        $names = Students::get('name');

        if ($groupFiltered != null && $groupFiltered != "0") {
            $grNum = DB::select(
                DB::raw("select id from \"groups\" g where \"name\" = '$groupFiltered'"))[0];
            $grNum = get_object_vars($grNum)['id'];

            $groups = Groups::get();

            $students = Students::get()->where('group_id', $grNum);
        } else {
            $students = Students::get();

            $groups = Groups::get();
        }

        return View('students.index', compact('students', 'groups', 'names', 'groupFiltered', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentsRequest  $request
     * @return Response
     */
    public function store(StoreStudentsRequest $request)
    {
        Students::create($request->all());
        return Redirect('students');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return Response
     */
    public function show($id)
    {
        $students = Students::find($id);
        return View('students.show')
            ->with('students', $students);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Students  $students
     * @return Response
     */
    public function edit($id)
    {
        $students = Students::find($id);
        return View('students.create')
            ->with('students', $students);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentsRequest  $request
     * @param  \App\Models\Students  $students
     * @return Response
     */
    public function update(UpdateStudentsRequest $request, Students $students)
    {
        $students->update($request->only(['name', 'surname', 'middlename', 'phone']));
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Students  $students
     * @return Response
     */
    public function destroy(Students $students)
    {
        $students->delete();
        return redirect()->route('students.index');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function exportTest()
    {
        return Excel::download(new TestExports(), 'invoices.xlsx');
    }

    public function exportQuery()
    {
        return (new QueryExports())->download('query.xlsx');
    }

    public function generateDocx(Request $request)
    {

        $past = Redirect::back()->getTargetUrl();

//        $grName = Str::substr($past, -4);;

//        dd($past);
        if (Str::contains($past, ['?name'])) {
            $grName = Str::substr($past, -4);;
            $grNum = DB::select(
                DB::raw("select id from \"groups\" g where \"name\" = '$grName'"))[0];
            $grNum = get_object_vars($grNum)['id'];
            $query = DB::select(
                DB::raw("with
                kor as (
                    select s.id, max(v2.\"name\") as name, max(v.created_at)
                        from students s
                            join vactinations v on v.student_id = s.id
                            join vaccines v2 on v2.id = v.vaccine_id
                        where v2.\"name\" like 'В Корь'
                    group by s.id
                ),
                cov as (
                    select s.id, max(v2.\"name\") as name, max(v.created_at)
                        from students s
                            join vactinations v on v.student_id = s.id
                            join vaccines v2 on v2.id = v.vaccine_id
                        where v2.\"name\" like 'СПУТНИК'
                    group by s.id
                ),
                flug as (
                    select s.id, max(f.result) as result, max(f.created_at)
                        from students s
                            join flgs f on f.student_id = s.id
                    group by s.id, f.result
                )
                select ROW_NUMBER() OVER() AS Row, s.id, (s.name || ' ' || s.surname || ' ' || s.middlename) as fio, (flug.result || ' ' || flug.max) as flgs, (cov.name || ' ' || cov.max) as covi, (kor.name || ' ' || kor.max) as korb
                from students s
                left join cov on cov.id = s.id
                left join kor on kor.id = s.id
                left join flug on flug.id = s.id
                where group_id = '$grNum'")
            );
        } else {
            $query = DB::select(
                'with
                kor as (
                    select s.id, max(v2."name") as name, max(v.created_at)
                        from students s
                            join vactinations v on v.student_id = s.id
                            join vaccines v2 on v2.id = v.vaccine_id
                        where v2."name" like \'В Корь\'
                    group by s.id
                ),
                cov as (
                    select s.id, max(v2."name") as name, max(v.created_at)
                        from students s
                            join vactinations v on v.student_id = s.id
                            join vaccines v2 on v2.id = v.vaccine_id
                        where v2."name" like \'СПУТНИК\'
                    group by s.id
                ),
                flug as (
                    select s.id, max(f.result) as result, max(f.created_at)
                        from students s
                            join flgs f on f.student_id = s.id
                    group by s.id
                )
                select ROW_NUMBER() OVER() AS Row, s.id, (s.name || \' \' || s.surname || \' \' || s.middlename) as fio, (flug.result || \' \' || flug.max) as flgs, (cov.name || \' \' || cov.max) as covi, (kor.name || \' \' || kor.max) as korb
                from students s
                left join cov on cov.id = s.id
                left join kor on kor.id = s.id
                left join flug on flug.id = s.id'
            );
        }
//        dd($grName, $query);
//        }else {
//            $query = DB::select(
//                'with
//                kor as (
//                    select s.id, v2."name", max(v.created_at)
//                        from students s
//                            join vactinations v on v.student_id = s.id
//                            join vaccines v2 on v2.id = v.vaccine_id
//                        where v2."name" like \'В Корь\'
//                    group by s.id, v2."name"
//                ),
//                cov as (
//                    select s.id, v2."name", max(v.created_at)
//                        from students s
//                            join vactinations v on v.student_id = s.id
//                            join vaccines v2 on v2.id = v.vaccine_id
//                        where v2."name" like \'СПУТНИК\'
//                    group by s.id, v2."name"
//                ),
//                flug as (
//                    select s.id, f.result, max(f.created_at)
//                        from students s
//                            join flgs f on f.student_id = s.id
//                    group by s.id, f.result
//                )
//                select ROW_NUMBER() OVER() AS Row, s.id, (s.name || \' \' || s.surname || \' \' || s.middlename) as fio, (flug.result || \' \' || flug.max) as flgs, (cov.name || \' \' || cov.max) as covi, (kor.name || \' \' || kor.max) as korb
//                from students s
//                left join cov on cov.id = s.id
//                left join kor on kor.id = s.id
//                left join flug on flug.id = s.id'
//            );
//        }

//        if (Str::contains($past, ['/studentsSort'])){
//            $query = DB::select(
//                'with
//                kor as (
//                    select s.id, v2."name", max(v.created_at)
//                        from students s
//                            join vactinations v on v.student_id = s.id
//                            join vaccines v2 on v2.id = v.vaccine_id
//                        where v2."name" like \'В Корь\'
//                    group by s.id, v2."name"
//                ),
//                cov as (
//                    select s.id, v2."name", max(v.created_at)
//                        from students s
//                            join vactinations v on v.student_id = s.id
//                            join vaccines v2 on v2.id = v.vaccine_id
//                        where v2."name" like \'СПУТНИК\'
//                    group by s.id, v2."name"
//                ),
//                flug as (
//                    select s.id, f.result, max(f.created_at)
//                        from students s
//                            join flgs f on f.student_id = s.id
//                    group by s.id, f.result
//                )
//                select ROW_NUMBER() OVER() AS Row, s.id, (s.name || \' \' || s.surname || \' \' || s.middlename) as fio, (flug.result || \' \' || flug.max) as flgs, (cov.name || \' \' || cov.max) as covi, (kor.name || \' \' || kor.max) as korb
//                from students s
//                left join cov on cov.id = s.id
//                left join kor on kor.id = s.id
//                left join flug on flug.id = s.id
//                where group_id = 1'
//            );
//        } else {
//            $query = DB::select(
//                'with
//                kor as (
//                    select s.id, v2."name", max(v.created_at)
//                        from students s
//                            join vactinations v on v.student_id = s.id
//                            join vaccines v2 on v2.id = v.vaccine_id
//                        where v2."name" like \'В Корь\'
//                    group by s.id, v2."name"
//                ),
//                cov as (
//                    select s.id, v2."name", max(v.created_at)
//                        from students s
//                            join vactinations v on v.student_id = s.id
//                            join vaccines v2 on v2.id = v.vaccine_id
//                        where v2."name" like \'СПУТНИК\'
//                    group by s.id, v2."name"
//                ),
//                flug as (
//                    select s.id, f.result, max(f.created_at)
//                        from students s
//                            join flgs f on f.student_id = s.id
//                    group by s.id, f.result
//                )
//                select ROW_NUMBER() OVER() AS Row, s.id, (s.name || \' \' || s.surname || \' \' || s.middlename) as fio, (flug.result || \' \' || flug.max) as flgs, (cov.name || \' \' || cov.max) as covi, (kor.name || \' \' || kor.max) as korb
//                from students s
//                left join cov on cov.id = s.id
//                left join kor on kor.id = s.id
//                left join flug on flug.id = s.id'
//            );
//        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        if (Str::contains($past, ['?name'])){
            $date = Carbon::now();
            $grName = Str::substr($past, -4);;
            $valuev = array("Сведения о студентах группы № '$grName' от", $date);
        } else {
            $date = Carbon::now();
            $valuev = array("Сведения о всех студентах от", $date);
        }

        $section->addText("СПб ГБПОУ «Медицинский колледж им. В.М.Бехтерова»", ['bold'=>true]);
        $section->addText(join(" ",$valuev), ['bold'=>true]);


        $table1 = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '#000000',
            'afterSpacing' => 0,
            'Spacing'=> 0,
            'cellMargin'=> 0
        ]);

//        $table1->addCell()->addText("Rez");
        $table1->addRow();
        $table1->addCell(3000)->addText("№ п/п", ['bold'=>true], array('align'=>'center'));
        $table1->addCell(3000)->addText("ФИО", ['bold'=>true], array('align'=>'center'));
        $table1->addCell(3000)->addText("ФЛГ", ['bold'=>true], array('align'=>'center'));
        $table1->addCell(3000)->addText("COVID", ['bold'=>true], array('align'=>'center', 'bold'=>true));
        $table1->addCell(3000)->addText("в кори", ['bold'=>true], array('align'=>'center', 'bold'=>true));
        foreach ($query as $al) {
            $table1->addRow();
            $table1->addCell(100)->addText($al->row);
            $table1->addCell(3000)->addText($al->fio);
            $table1->addCell(3000)->addText($al->flgs);
            $table1->addCell(3000)->addText($al->covi);
            $table1->addCell(3000)->addText($al->korb);
        }
        $section->addText("");
        $section->addText("Зав.отделением____________________________________________________Докрторов А.Б.");


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        if (Str::contains($past, ['?name'])){
            $grName = Str::substr($past, -4);;
            $date = Carbon::now()->toDateString();
            $valuev = array("Группа '$grName'-", $date, ".docx");

            try {
                $objWriter->save(storage_path(join("",$valuev)));
            } catch (Exception $e) {
            }


            return response()->download(storage_path(join("",$valuev)));
        } else {
            $date = Carbon::now()->toDateString();
            $valuev = array("Все группы-", $date, ".docx");

            try {
                $objWriter->save(storage_path(join("",$valuev)));
            } catch (Exception $e) {
            }


            return response()->download(storage_path(join("",$valuev)));
        }

    }
}

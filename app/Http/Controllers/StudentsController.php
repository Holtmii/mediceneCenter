<?php

namespace App\Http\Controllers;

use App\Exports\QueryExports;
use App\Exports\TestExports;
use App\Models\Students;
use App\Http\Requests\StoreStudentsRequest;
use App\Http\Requests\UpdateStudentsRequest;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use Symfony\Component\HttpFoundation\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Students::get();
        return View('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentsRequest  $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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

    public function generateDocx()
    {
        $query = DB::select(
            'with
                kor as (
                    select s.id, v2."name", max(v.created_at)
                        from students s
                            join vactinations v on v.student_id = s.id
                            join vaccines v2 on v2.id = v.vaccine_id
                        where v2."name" like \'В Корь\'
                    group by s.id, v2."name"
                ),
                cov as (
                    select s.id, v2."name", max(v.created_at)
                        from students s
                            join vactinations v on v.student_id = s.id
                            join vaccines v2 on v2.id = v.vaccine_id
                        where v2."name" like \'СПУТНИК\'
                    group by s.id, v2."name"
                ),
                flug as (
                    select s.id, f.result, max(f.created_at)
                        from students s
                            join flg f on f.student_id = s.id
                    group by s.id, f.result
                )
                select ROW_NUMBER() OVER() AS Row, s.id, (s.name || \' \' || s.surname || \' \' || s.middlename) as fio, (flug.result || \' \' || flug.max) as flg, (cov.name || \' \' || cov.max) as covi, (kor.name || \' \' || kor.max) as korb
                from students s
                left join cov on cov.id = s.id
                left join kor on kor.id = s.id
                left join flug on flug.id = s.id'
        );

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $section->addText("СПб ГБПОУ «Медицинский колледж им. В.М.Бехтерова»", ['bold'=>true]);
        $section->addText("Сведения о студентах группы № 12 от 10.04.2022", ['bold'=>true]);


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
            $table1->addCell(3000)->addText($al->flg);
            $table1->addCell(3000)->addText($al->covi);
            $table1->addCell(3000)->addText($al->korb);
        }
        $section->addText("");
        $section->addText("Зав.отделением____________________________________________________Докрторов А.Б.");


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx'));
    }
}

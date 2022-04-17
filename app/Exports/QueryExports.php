<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;

class QueryExports implements FromQuery
{
    use Exportable;

    public function query()
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
)
select s.id, (s.name || \' \' || s.surname || \' \' || s.middlename) as fio, (cov.name || \' \' || cov.max) as covi, (kor.name || \' \' || kor.max) as korb
from students s
left join cov on cov.id = s.id
left join kor on kor.id = s.id'
        );
//dd($query);
        return compact($query);
    }
}

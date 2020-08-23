<?php
namespace App\Exports;

use App\Report;
use App\Http\Controllers\AuthController;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class ReportExport implements FromQuery, WithMapping{

    public function query(){
        return Report::where([
            ['id','>','0'],
            ['type','report'],
        ]);
    }

    public function map($report):array{
        return [
            $report->information,
            $report->value
        ];
    }
}
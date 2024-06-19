<?php

namespace App\Imports;

use App\Models\Claim;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use File;
use Auth;

class ClaimImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Claim([
            // 'hcode' => $row['1'],
            // 'hospmain' => $row['7'],
            // 'vn' => $row['0'],
            // 'hn' => $row['2'],
            // 'patient' => $row['3'],
            // 'pid' => $row['4'],
            // 'visit_date' => $row['5'],
            // // 'visit_date' => Date::excelToDateTimeObject($row['5'])->format('Y-m-d'),
            // 'icd10' => $row['6'],
            // 'drug' => $row['8'],
            // 'lab' => $row['9'],
            // 'xray' => $row['10'],
            // 'proc' => $row['11'],
            // 'service_charge' => $row['12'],
            // 'total' => $row['13'],
            // 'with_ambulance' => $row['14'],
            // 'pttype' => $row['15'],
            // 'ptname' => $row['16'],
            // 'p_status' => '1',
            // 'import_date' => date('Y-m-d'),
                'hcode' => $row['hcode'],
                'hospmain' => $row['hospmain'],
                'vn' => $row['vn'],
                'hn' => $row['hn'],
                'patient' => $row['patient'],
                'pid' => $row['pid'],
                'visit_date' => $row['visit_date'],
                'icd10' => $row['icd10'],
                'drug' => $row['drug'],
                'lab' => $row['lab'],
                'xray' => $row['xray'],
                'proc' => $row['proc'],
                'service_charge' => $row['service_charge'],
                'total' => $row['total'],
                'with_ambulance' => $row['with_ambulance'],
                'pttype' => $row['pttype'],
                'ptname' => $row['ptname'],
                'p_status' => '1',
                'import_date' => date('Y-m-d'),
        ]);
    }
}


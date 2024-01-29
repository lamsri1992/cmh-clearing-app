<?php

namespace App\Imports;

use App\Models\Claim;
use Maatwebsite\Excel\Concerns\ToModel;
use File;
use Auth;

class ClaimImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $hcode = Auth::user()->hcode;
        return new Claim([
            'hcode' => $hcode,
            'hn' => $row['4'],
            'pid' => $row['5'],
            'date_rx' => date('Y-m-d', strtotime($row['1'])),
            // 'date_rx' => $row['1'],
            'date_rec' => date('Y-m-d'),
            'icd9' => $row['12'],
            'icd10' => $row['11'],
            'reporter' => 'IMPORT',
            'h_login' => 'HOSPITAL_IMPORT',
            'p_year' => date('Y'),
            'p_month' => date('m'),
            'hospmain' => $row['7'],
            'with_ct_mri' => $row['13'],
            'pay_total' => $row['15'],
            'pay_order' => $row['16'],
            'contrast' => $row['17'],
            'contrast_pay' => $row['18'],
            'refer_no' => $row['10'],
            'pttype' => 'UC',
            'ptname' => 'OP Anywhere',
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $table = 'claim_list';
    protected $fillable = [
        'hcode',
        'hospmain',
        'vn',
        'hn',
        'patient',
        'pid',
        'visit_date',
        'icd10',
        'drug',
        'lab',
        'xray',
        'proc',
        'service_charge',
        'total',
        'with_ambulance',
        'pttype',
        'ptname',
        'p_status',
        'import_date',
    ];
    protected $guarded = [];
    public $timestamps = false;
}

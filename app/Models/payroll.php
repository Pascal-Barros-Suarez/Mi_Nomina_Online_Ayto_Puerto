<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payroll extends Model
{
    use HasFactory;

    protected $table = 'payrolls';
    protected $fillable = [
        'user_id',
        'gross_salary',
        'base_salary',
        'income_tax', //irpf
        'allowances', //complementos
        'concept',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

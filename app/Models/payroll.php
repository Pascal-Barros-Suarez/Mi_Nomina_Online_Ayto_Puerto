<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'payrolls';

    protected $fillable = [
        'user_id',
        'gross_salary',
        'base_salary',
        'income_tax',
        'destination_allowance',
        'specific_allowance',
        'specific_complement',
        'commission_attendance',
        'common_contingencies',
        'unemployment',
        'mei',
        'professional_training',
        'csic',
        'concept',
        'month',
        'year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

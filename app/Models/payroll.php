<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payroll extends Model
{
    use HasFactory;

    protected $table = 'payroll';
    protected $fillable = [
        'id_usuario',
        'sueldo_bruto',
        'sueldo_base',
        'irpf',
        'complementos',
        'concepto',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}

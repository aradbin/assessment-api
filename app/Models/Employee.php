<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Employee extends Model
{
    use SoftDeletes, HasUuids;

    protected $fillable = ['name', 'email', 'department_id'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function detail() {
        return $this->hasOne(EmployeeDetail::class);
    }
}

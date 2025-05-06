<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    protected $fillable = ['employee_id', 'designation', 'salary', 'address', 'joined_date'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}

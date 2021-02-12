<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }

    public function assignEmployee()
    {
        return $this->belongsTo(User::class,'assign_user_id');
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function customerOption()
    {
        return $this->belongsTo(CustomerOption::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

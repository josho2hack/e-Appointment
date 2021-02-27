<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customerOptions()
    {
        return $this->hasMany(CustomerOption::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function Bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publicUser()
    {
        return $this->belongsTo(User::class,'public_user_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $primaryKey = 'staff_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'position',
        'contact_number',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

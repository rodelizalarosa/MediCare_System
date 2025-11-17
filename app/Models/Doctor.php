<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $primaryKey = 'doctor_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'specialization',
        'license_number',
        'PRC_expiry',
        'contact_number',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

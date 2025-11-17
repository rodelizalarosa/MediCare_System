<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midwife extends Model
{
    use HasFactory;

    protected $primaryKey = 'midwife_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
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

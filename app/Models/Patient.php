<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'birth_date',
        'civil_status',
        'address',
        'contact_number',
        'emergency_contact_name',
        'emergency_contact_number',
        'relationship_to_patient',
        'registration_source',
        'created_by_staff',
        'record_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class, 'patient_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $table = 'medical_history';

    protected $primaryKey = 'history_id';

    protected $dates = ['last_updated'];

    protected $fillable = [
        'patient_id',
        'known_conditions',
        'allergies',
        'current_medications',
        'previous_hospitalization',
        'family_history',
        'immunization_status',
        'remarks'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}

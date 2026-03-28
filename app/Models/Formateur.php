<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'expertise_domain', 'diploma_file', 'id_card_file',
        'certificate_file', 'validation_status', 'rejection_reason', 'validated_at'
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'formateur_id');
    }

    public function getDiplomaUrlAttribute()
    {
        return $this->diploma_file ? asset('storage/formateur_documents/'.$this->diploma_file) : null;
    }

    public function getIdCardUrlAttribute()
    {
        return $this->id_card_file ? asset('storage/formateur_documents/'.$this->id_card_file) : null;
    }

    public function getCertificateUrlAttribute()
    {
        return $this->certificate_file ? asset('storage/formateur_documents/'.$this->certificate_file) : null;
    }
}
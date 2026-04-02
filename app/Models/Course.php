<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'formateur_id', 'category_id', 'title', 'slug', 'description', 
        'price', 'duration_minutes', 'thumbnail', 'cover_video', 'status', 'rejection_reason'
    ];
    
    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order_index');
    }
    
    public function quizzes()
    {
        return $this->hasMany(CourseQuiz::class);
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}

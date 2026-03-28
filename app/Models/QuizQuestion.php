<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'course_quiz_id', 'question_text', 'points'
    ];
    
    public function quiz()
    {
        return $this->belongsTo(CourseQuiz::class, 'course_quiz_id');
    }
    
    public function options()
    {
        return $this->hasMany(QuizOption::class);
    }
}

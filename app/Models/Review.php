<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Review extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','review_date','review_status','review_notes','next_review_date','reviewed_by'];
    public function student(){ return $this->belongsTo(Student::class); }
    public function reviewer(){ return $this->belongsTo(User::class, 'reviewed_by'); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Behaviour extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','behaviour_date','behaviour_type','description','points','recorded_by'];
    public function student(){ return $this->belongsTo(Student::class); }
    public function recorder(){ return $this->belongsTo(User::class, 'recorded_by'); }
}

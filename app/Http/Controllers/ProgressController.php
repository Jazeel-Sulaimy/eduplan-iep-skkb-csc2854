<?php
namespace App\Http\Controllers;
use App\Models\ProgressRecord;
use App\Models\Student;
use Illuminate\Http\Request;
class ProgressController extends Controller
{
    public function index(){ return view('progress.index',['records'=>ProgressRecord::with('student')->latest()->get()]); }
    public function create(){ return view('progress.form',['record'=>new ProgressRecord(),'students'=>Student::orderBy('student_name')->get()]); }
    public function store(Request $request){ $data=$request->validate(['student_id'=>'required|exists:students,id','progress_date'=>'required|date','academic_progress'=>'required','behaviour_progress'=>'required','teacher_comment'=>'nullable']); $data['recorded_by']=auth()->id(); ProgressRecord::create($data); return redirect()->route('progress.index')->with('success','Progress saved.'); }
    public function edit(ProgressRecord $progress){ return view('progress.form',['record'=>$progress,'students'=>Student::orderBy('student_name')->get()]); }
    public function update(Request $request, ProgressRecord $progress){ $data=$request->validate(['student_id'=>'required|exists:students,id','progress_date'=>'required|date','academic_progress'=>'required','behaviour_progress'=>'required','teacher_comment'=>'nullable']); $progress->update($data); return redirect()->route('progress.index')->with('success','Progress updated.'); }
    public function destroy(ProgressRecord $progress){ $progress->delete(); return back()->with('success','Progress deleted.'); }
}

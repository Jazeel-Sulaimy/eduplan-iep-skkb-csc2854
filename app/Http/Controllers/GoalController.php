<?php
namespace App\Http\Controllers;
use App\Models\IepGoal;
use App\Models\Student;
use Illuminate\Http\Request;
class GoalController extends Controller
{
    public function index(){ return view('goals.index',['goals'=>IepGoal::with('student')->latest()->get()]); }
    public function create(){ return view('goals.form',['goal'=>new IepGoal(),'students'=>Student::orderBy('student_name')->get()]); }
    public function store(Request $request){ $data=$request->validate(['student_id'=>'required|exists:students,id','goal_title'=>'required|max:255','goal_description'=>'required','target_date'=>'nullable|date','status'=>'required|max:50']); $data['created_by']=auth()->id(); IepGoal::create($data); return redirect()->route('goals.index')->with('success','IEP goal saved.'); }
    public function edit(IepGoal $goal){ return view('goals.form',['goal'=>$goal,'students'=>Student::orderBy('student_name')->get()]); }
    public function update(Request $request, IepGoal $goal){ $data=$request->validate(['student_id'=>'required|exists:students,id','goal_title'=>'required|max:255','goal_description'=>'required','target_date'=>'nullable|date','status'=>'required|max:50']); $goal->update($data); return redirect()->route('goals.index')->with('success','IEP goal updated.'); }
    public function destroy(IepGoal $goal){ $goal->delete(); return back()->with('success','IEP goal deleted.'); }
}

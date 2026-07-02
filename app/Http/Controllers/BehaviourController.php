<?php
namespace App\Http\Controllers;
use App\Models\Behaviour;
use App\Models\Student;
use Illuminate\Http\Request;
class BehaviourController extends Controller
{
    public function index(){ return view('behaviours.index',['behaviours'=>Behaviour::with('student')->latest()->get()]); }
    public function create(){ return view('behaviours.form',['behaviour'=>new Behaviour(),'students'=>Student::orderBy('student_name')->get()]); }
    public function store(Request $request){ $data=$request->validate(['student_id'=>'required|exists:students,id','behaviour_date'=>'required|date','behaviour_type'=>'required|max:50','description'=>'required','points'=>'required|integer']); $data['recorded_by']=auth()->id(); Behaviour::create($data); return redirect()->route('behaviours.index')->with('success','Behaviour recorded.'); }
    public function edit(Behaviour $behaviour){ return view('behaviours.form',['behaviour'=>$behaviour,'students'=>Student::orderBy('student_name')->get()]); }
    public function update(Request $request, Behaviour $behaviour){ $data=$request->validate(['student_id'=>'required|exists:students,id','behaviour_date'=>'required|date','behaviour_type'=>'required|max:50','description'=>'required','points'=>'required|integer']); $behaviour->update($data); return redirect()->route('behaviours.index')->with('success','Behaviour updated.'); }
    public function destroy(Behaviour $behaviour){ $behaviour->delete(); return back()->with('success','Behaviour deleted.'); }
}

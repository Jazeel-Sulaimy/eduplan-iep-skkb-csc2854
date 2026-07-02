<?php
namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Student;
use Illuminate\Http\Request;
class ReviewController extends Controller
{
    public function index(){ return view('reviews.index',['reviews'=>Review::with('student')->latest()->get()]); }
    public function create(){ return view('reviews.form',['review'=>new Review(),'students'=>Student::orderBy('student_name')->get()]); }
    public function store(Request $request){ $data=$request->validate(['student_id'=>'required|exists:students,id','review_date'=>'required|date','review_status'=>'required|max:50','review_notes'=>'required','next_review_date'=>'nullable|date']); $data['reviewed_by']=auth()->id(); Review::create($data); return redirect()->route('reviews.index')->with('success','Review saved.'); }
    public function edit(Review $review){ return view('reviews.form',['review'=>$review,'students'=>Student::orderBy('student_name')->get()]); }
    public function update(Request $request, Review $review){ $data=$request->validate(['student_id'=>'required|exists:students,id','review_date'=>'required|date','review_status'=>'required|max:50','review_notes'=>'required','next_review_date'=>'nullable|date']); $review->update($data); return redirect()->route('reviews.index')->with('success','Review updated.'); }
    public function destroy(Review $review){ $review->delete(); return back()->with('success','Review deleted.'); }
}

<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class ManageUserController extends Controller
{
    public function index(){ if(!auth()->user()->isAdminRole()) abort(403); return view('users.index',['users'=>User::latest()->get()]); }
    public function create(){ if(!auth()->user()->isAdminRole()) abort(403); return view('users.form',['user'=>new User()]); }
    public function store(Request $request){ if(!auth()->user()->isAdminRole()) abort(403); $data=$request->validate(['user_id'=>'required|unique:users,user_id|max:50','name'=>'required|max:255','email'=>'nullable|email|max:255','phone'=>'nullable|max:30','role'=>'required|in:school_admin,teacher,counsellor,parent,system_admin','password'=>'required|min:5']); $data['password']=Hash::make($data['password']); User::create($data); return redirect()->route('users.index')->with('success','User created.'); }
    public function edit(User $user){ if(!auth()->user()->isAdminRole()) abort(403); return view('users.form',compact('user')); }
    public function update(Request $request, User $user){ if(!auth()->user()->isAdminRole()) abort(403); $data=$request->validate(['user_id'=>'required|max:50|unique:users,user_id,'.$user->id,'name'=>'required|max:255','email'=>'nullable|email|max:255','phone'=>'nullable|max:30','role'=>'required|in:school_admin,teacher,counsellor,parent,system_admin','password'=>'nullable|min:5']); if(!empty($data['password'])) $data['password']=Hash::make($data['password']); else unset($data['password']); $user->update($data); return redirect()->route('users.index')->with('success','User updated.'); }
    public function destroy(User $user){ if(!auth()->user()->isAdminRole()) abort(403); if($user->id===auth()->id()) return back()->withErrors('You cannot delete your own account.'); $user->delete(); return back()->with('success','User deleted.'); }
}

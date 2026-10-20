<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index(){
    $users = \App\Models\User::all();
     return view('dashboard.users.index', compact('users'));
   }
public function create(){
    return view('dashboard.users.createuser');
}

public function store( Request $request){
   
 $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|unique:users',
    'password' => 'required|string|min:8',
    'role' => 'required|in:admin,user',
    'address' => 'nullable|string|max:255',
    'phone' => 'nullable|string|max:20'
]);

$user=User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => bcrypt($request->password),
    'role' => $request->role,
    'address' => $request->address,
    'phone' => $request->phone
]);
return redirect()->route('users.index')->with('success', 'User created successfully.');
    
}

 public function edit($id){
    $user = \App\Models\User::findOrFail($id);
    return view('dashboard.users.edituser', compact('user'));
 }
public function update( Request $request,$id){
    $user=User::findOrFail($id);
    $request->validate([
    'name' => 'required|string|max:255',
   'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    'password' => 'nullable|string|min:8',
    'role' => 'required|in:admin,user',
    'address' => 'nullable|string|max:255',
    'phone' => 'nullable|string|max:20'
]);


$user->update([
    'name' => $request->name,
    'email' => $request->email,
    'password' => bcrypt($request->password),
    'role' => $request->role,
    'address' => $request->address,
    'phone' => $request->phone
]);
return redirect()->route('users.index')->with('success', 'User updated successfully.');
}
 public function destroy($id){
    $user = User::findOrFail($id);
    $user->delete();
    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
 }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function index()
   {
       $users = User::paginate(15);
       return view('users.index', compact('users'));
   }

   public function create()
   {
       return view('users.create');
   }

   public function store(Request $request)
   {
$validated = $request->validate([
    'username' => 'required|unique:users',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6',
    'role' => 'required|in:admin,ops,sales,csr'
]);

       $validated['password'] = Hash::make($validated['password']);
       User::create($validated);

       return redirect()->route('users.index')->with('success', 'User created successfully');
   }

   public function edit(User $user)
   {
       return view('users.edit', compact('user'));
   }

   public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'username' => 'required|unique:users,username,'.$user->id,
        'email' => 'required|email|unique:users,email,'.$user->id,
        'password' => 'nullable|min:6',
        'role' => 'required|in:admin,ops,sales,csr'
    ]);

    if ($validated['password']) {
        $validated['password'] = Hash::make($validated['password']);
    } else {
        unset($validated['password']);
    }

    $user->update($validated);
    return redirect()->route('users.index')->with('success', 'User updated successfully');
}

   public function destroy(User $user)
   {
       if ($user->id === auth()->id()) {
           return back()->with('error', 'You cannot delete your own account');
       }
       
       $user->delete();
       return redirect()->route('users.index')->with('success', 'User deleted successfully');
   }
}
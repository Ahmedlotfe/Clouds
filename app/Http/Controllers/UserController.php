<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $users = $query->get();

        return view('users.index', compact('users'));
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        $validateData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $user->update($validateData);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function changeStatus($userId){
        $user = User::findOrFail($userId);
        if($user->deactivated){
            $user->deactivated = false;
            $user->save();
        }else{
            $user->deactivated = true;
            $user->save();
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function delete($userId){
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

}

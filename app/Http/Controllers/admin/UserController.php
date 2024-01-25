<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
      $users = User::where("status","<>",2)->get();
      return view('admin.users.index', compact('users'));
    }

  public function create()
  {
    return view('admin.users.create');
  }

  public function store(Request $request)
  {
    //dd($request);
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'idPerfil' => 'required',
      'name' => 'required',
    ]);
    //$request['password'] = bcrypt($request->password);

    User::create($request->all());
    return redirect()->route('user.index')
      ->with('success', 'Usuario created successfully.');
  }

  public function edit($id)
  {
    $data = User::find($id);
    return view('admin.users.edit', compact('data'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
        'email' => 'required|email',
        'idPerfil' => 'required',
        'name' => 'required',
      ]);
    $user = User::find($id);
    $user->update($request->all());
    return redirect()->route('user.index')
      ->with('success', 'Usuario updated successfully.');
  }

  public function destroy($id)
  {
    $user = User::find($id);
    $user->status = 2;
    $user->save();
    return redirect()->route('user.index')
      ->with('success', 'Usuario deleted successfully');
  }

}

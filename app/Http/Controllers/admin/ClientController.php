<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
      $data = Client::where("status","<>",2)->get();
      return view('admin.client.index', compact('data'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
      //dd($request);
      $request->validate([
        'name' => 'required',
        'street_address' => 'required',
        'location_lat' => 'required',
        'location_lng' => 'required',
        'status' => 'required',
      ]);
      //$request['password'] = bcrypt($request->password);

      Client::create($request->all());
      return redirect()->route('client.index')
        ->with('success', 'Client created successfully.');
    }

    public function edit($id)
    {
      $data = Client::find($id);
      return view('admin.client.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'name' => 'required',
        'street_address' => 'required',
        'location_lat' => 'required',
        'location_lng' => 'required',
        'status' => 'required',
        ]);
      $data = Client::find($id);
      $data->update($request->all());
      return redirect()->route('client.index')
        ->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
      $data = Client::find($id);
      $data->status = 2;
      $data->save();
      return redirect()->route('client.index')
        ->with('success', 'Client deleted successfully');
    }
}

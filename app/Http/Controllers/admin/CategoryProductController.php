<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function index()
    {
      $categories = CategoryProduct::where("status","<>",2)->get();
      return view('admin.categoryProduct.index', compact('categories'));
    }

    public function create()
  {
    return view('admin.categoryProduct.create');
  }

  public function store(Request $request)
  {
    //dd($request);
    $request->validate([
      'name' => 'required',
    ]);
    //$request['password'] = bcrypt($request->password);

    CategoryProduct::create($request->all());
    return redirect()->route('categoryProduct.index')
      ->with('success', 'Categoría created successfully.');
  }

  public function edit($id)
  {
    $data = CategoryProduct::find($id);
    return view('admin.categoryProduct.edit', compact('data'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
        'name' => 'required',
      ]);
    $data = CategoryProduct::find($id);
    $data->update($request->all());
    return redirect()->route('categoryProduct.index')
      ->with('success', 'Categoría updated successfully.');
  }

  public function destroy($id)
  {
    $data = CategoryProduct::find($id);
    $data->status = 2;
    $data->save();
    return redirect()->route('categoryProduct.index')
      ->with('success', 'Categoría deleted successfully');
  }

}

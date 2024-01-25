<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
      $data = Product::where("status","<>",2)->get();
      
      return view('admin.product.index', compact('data'));
    }

    public function create()
  {
    $category = CategoryProduct::where("status",1)->get();
    return view('admin.product.create', compact('category'));
  }

  public function store(Request $request)
  {
    //dd($request);
    $request->validate([
      'name' => 'required',
      'quantity' => 'required',
      'price' => 'required',
      'categoryProduct_id' => 'required',
      'status' => 'required',
    ]);
    //$request['password'] = bcrypt($request->password);

    Product::create($request->all());
    return redirect()->route('product.index')
      ->with('success', 'Producto created successfully.');
  }

  public function edit($id)
  {
    $data = Product::find($id);
    $category = CategoryProduct::where("status",1)->get();
    return view('admin.product.edit', compact('data','category'));
  }

  public function update(Request $request, $id)
  {
    $request->validate([
        'name' => 'required',
      'quantity' => 'required',
      'price' => 'required',
      'categoryProduct_id' => 'required',
      'status' => 'required',
      ]);
    $data = Product::find($id);
    $data->update($request->all());
    return redirect()->route('product.index')
      ->with('success', 'Producto updated successfully.');
  }

  public function destroy($id)
  {
    $data = Product::find($id);
    $data->status = 2;
    $data->save();
    return redirect()->route('product.index')
      ->with('success', 'Producto deleted successfully');
  }
}

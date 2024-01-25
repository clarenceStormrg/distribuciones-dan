<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {

     if(auth()->user()->idPerfil === 2)
     {
        $data = DB::select("Select o.id,c.name as cliente,
                    ven.name as vendedor,
                    con.name as conductor,
                    o.shipping_date,
                    (select count(od.quantity) from order_detail od where od.order_id = o.id) as productos,
                    o.status 
                from `order` o 
                inner join client c on c.id = o.client_id
                inner join users ven on o.vendedor_id = ven.id
                inner join users con on o.conductor_id = con.id
                where o.status != 2 and o.vendedor_id = ".auth()->user()->id);
     }else{
        $data = DB::select("Select o.id,c.name as cliente,
                ven.name as vendedor,
                con.name as conductor,
                o.shipping_date,
                (select count(od.quantity) from order_detail od where od.order_id = o.id) as productos,
                o.status 
                from `order` o 
                inner join client c on c.id = o.client_id
                inner join users ven on o.vendedor_id = ven.id
                inner join users con on o.conductor_id = con.id
                where o.status != 2 ");
     }

      return view('admin.order.index', compact('data'));
    }

    public function create()
    {
        if(auth()->user()->idPerfil === 2)
        {
            $vendedor = User::where("status",1)
            ->where("idPerfil",2)
            ->where("id",auth()->user()->id)
            ->get();
        }else{
            $vendedor = User::where("status",1)
                        ->where("idPerfil",2)
                        ->get();
        }
        

        $conductor = User::where("status",1)
                        ->where("idPerfil",3)
                        ->get();

        $cliente = Client::where("status",1)->get();

        $product = Product::where("status",1)->get();

        return view('admin.order.create', compact('vendedor','conductor','cliente','product'));
    }

    public function store(Request $request)
    {

      $request->validate([
        'client_id' => 'required',
        'conductor_id' => 'required',
        'vendedor_id' => 'required',
        'shipping_date' => 'required',
        'status' => 'required',
        'id_products' => 'required',
      ]);
      //$request['password'] = bcrypt($request->password);
      
      $order = Order::create($request->all());

      $products = explode(",", $request["id_products"]);
      foreach ($products as $value) {
        $products_item = explode("|", $value);
        $order_detail = array(
            "order_id" => $order->id,
            "product_id" => $products_item[0],
            "quantity" => $products_item[1]
        );

        OrderDetail::create($order_detail);
      }

      return redirect()->route('order.index')
        ->with('success', 'Pedido created successfully.');
    }

    public function edit($id)
    {
        $data = Order::find($id);
        $order_detail = OrderDetail::where("order_id",$id)->get();

        $products_add = "";
        foreach ($order_detail as $value) {
            $productaux = Product::find($value["product_id"]);
            $products_add.= $value["product_id"]."|".$value["quantity"]."|".$productaux->name.",";
        }
        $data["products"] = substr($products_add, 0, -1);

        if(auth()->user()->idPerfil === 2)
        {
            $vendedor = User::where("status",1)
            ->where("idPerfil",2)
            ->where("id",auth()->user()->id)
            ->get();
        }else{
            $vendedor = User::where("status",1)
                        ->where("idPerfil",2)
                        ->get();
        }

        $conductor = User::where("status",1)
                        ->where("idPerfil",3)
                        ->get();

        $cliente = Client::where("status",1)->get();

        $product = Product::where("status",1)->get();

        return view('admin.order.edit', compact('vendedor','conductor','cliente','product', 'data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required',
            'conductor_id' => 'required',
            'vendedor_id' => 'required',
            'shipping_date' => 'required',
            'status' => 'required',
            'id_products' => 'required',
        ]);
        $data = Order::find($id);
        $data->update($request->all());

        OrderDetail::where('order_id',$id)->delete();

        $products = explode(",", $request["id_products"]);
        foreach ($products as $value) {
            $products_item = explode("|", $value);
            $order_detail = array(
                "order_id" => $id,
                "product_id" => $products_item[0],
                "quantity" => $products_item[1]
            );

            OrderDetail::create($order_detail);
        }

        return redirect()->route('order.index')
        ->with('success', 'Pedido updated successfully.');
    }

    public function destroy($id)
    {
        $data = Order::find($id);
        $data->status = 2;
        $data->save();
        return redirect()->route('order.index')
        ->with('success', 'Pedido deleted successfully');
    }

    public function pickup()
    {
        
        if(auth()->user()->idPerfil === 3)
        {
            $data = DB::select("Select o.id,
                        c.name as cliente,
                        c.id as idCliente,
                        c.street_address as direccion,
                        c.location_lat,
                        c.location_lng,
                        ven.name as vendedor,
                        con.name as conductor,
                        o.shipping_date,
                        o.status 
                    from `order` o 
                    inner join client c on c.id = o.client_id
                    inner join users ven on o.vendedor_id = ven.id
                    inner join users con on o.conductor_id = con.id
                    where o.status != 2 and o.conductor_id = ".auth()->user()->id."
                    and CAST(shipping_date AS DATE) = CAST( date_sub(NOW(), interval 1 day) AS DATE) 
                    order by shipping_date");
        }else
        {
            $data = DB::select("Select o.id,
                        c.name as cliente,
                        c.id as idCliente,
                        c.street_address as direccion,
                        c.location_lat,
                        c.location_lng,
                        ven.name as vendedor,
                        con.name as conductor,
                        o.shipping_date,
                        o.status 
                    from `order` o 
                    inner join client c on c.id = o.client_id
                    inner join users ven on o.vendedor_id = ven.id
                    inner join users con on o.conductor_id = con.id
                    where o.status != 2 
                    and CAST(shipping_date AS DATE) = CAST( date_sub(NOW(), interval 1 day) AS DATE) 
                    order by o.id");
        }

        $maps = env('MAP_LAT')."|".env('MAP_LNG').",";
        foreach ($data as $value) {
            $maps.= $value->location_lat."|". $value->location_lng.",";
        }
        $maps = substr($maps, 0, -1);
      return view('admin.order.pickup', compact('data','maps'));
    }

    public function pickup2()
    {
        if(auth()->user()->idPerfil === 3)
        {
            $data = DB::select("Select o.id,
                        c.name as cliente,
                        c.id as idCliente,
                        c.street_address as direccion,
                        c.location_lat,
                        c.location_lng,
                        ven.name as vendedor,
                        con.name as conductor,
                        o.shipping_date,
                        o.status 
                    from `order` o 
                    inner join client c on c.id = o.client_id
                    inner join users ven on o.vendedor_id = ven.id
                    inner join users con on o.conductor_id = con.id
                    where o.status != 2 and o.conductor_id = ".auth()->user()->id."
                    and CAST(shipping_date AS DATE) = CAST( date_sub(NOW(), interval 1 day) AS DATE) 
                    order by shipping_date");
        }else
        {
            $data = DB::select("Select o.id,
                        c.name as cliente,
                        c.id as idCliente,
                        c.street_address as direccion,
                        c.location_lat,
                        c.location_lng,
                        ven.name as vendedor,
                        con.name as conductor,
                        o.shipping_date,
                        o.status 
                    from `order` o 
                    inner join client c on c.id = o.client_id
                    inner join users ven on o.vendedor_id = ven.id
                    inner join users con on o.conductor_id = con.id
                    where o.status != 2 
                    and CAST(shipping_date AS DATE) = CAST( NOW() AS DATE)
                    order by shipping_date");
        }
      

      return view('admin.order.pickup2', compact('data'));
    }

    public function pickupProduct(Request $request)
    {
        $id = $request->id;
        $order_detail = DB::select( "select  o.quantity,o.product_id, p.name product, p.price
                            from order_detail o 
                            inner join product p on o.product_id = p.id
                            where o.order_id = ".$id);
        return response()->json(array('data'=> $order_detail), 200);
    }

    public function print($id)
    {
        $data = DB::select( "select  o.quantity,o.product_id, p.name product, p.price
                            from order_detail o 
                            inner join product p on o.product_id = p.id
                            where o.order_id = ".$id);

        $data_cab = DB::select( "select  sum(od.quantity*p.price) total, 
                                         ROUND(sum(od.quantity*p.price)/1.18,2) subtotal,
                                        sum(od.quantity*p.price) - ROUND(sum(od.quantity*p.price)/1.18,2) igv,
                                        c.name client, c.street_address, con.name as driver, 
                                        ven.name as seller,
                                        LPAD(od.order_id,6,'0') id
                                from order_detail od 
                                inner join `order` o on od.order_id = o.id
                                inner join client c on o.client_id = c.id
                                inner join users con on o.conductor_id = con.id
                                inner join users ven on o.vendedor_id = ven.id
                                inner join product p on od.product_id = p.id
                                where od.order_id = ".$id.
                                " group by c.name,c.street_address, con.name,ven.name,od.order_id")[0];    
        
        //dd($data_cab);
        
        return view('admin.order.print', compact('data_cab','data'));
    }

}

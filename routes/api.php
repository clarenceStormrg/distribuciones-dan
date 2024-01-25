<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    return $user->createToken($request->device_name)->plainTextToken;
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/maps', function (Request $request) {
    
    if($request->user()->idPerfil === 3)
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
                where o.status != 2 and o.conductor_id = ".$request->user()->id."
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
    return $data;
});

Route::middleware('auth:sanctum')->get('/user/revoke', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();
    return 'tokens are deleted';
});
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
	{
	    // Comprobamos si el usuario ya está logado
	    if (Auth::check()) {
	
	        // Si está logado le mostramos la vista de logados
	        return view('admin.home');
	    }
	
	    // Si no está logado le mostramos la vista con el formulario de login
	    return view('login');
	}

    public function login(Request $request)
	{
       
	    // Comprobamos que el email y la contraseña han sido introducidos
	    $request->validate([
	        'email' => 'required',
	        'password' => 'required',
	    ]);
        
	    // Almacenamos las credenciales de email y contraseña
	    $credentials = $request->only('email', 'password');
        
	    // Si el usuario existe lo logamos y lo llevamos a la vista de "logados" con un mensaje
	    if (Auth::attempt($credentials)) {
	        //return redirect()->intended('logados')->withSuccess('Logado Correctamente');
            return redirect()->intended('home')->withSuccess('Logado Correctamente');
	    }
	    
	    // Si el usuario no existe devolvemos al usuario al formulario de login con un mensaje de error
	    return redirect("/")->withSuccess('Los datos introducidos no son correctos');
	}

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
      }
	
	/**
	* Función que muestra la vista de logados si el usuario está logado y si no le devuelve al formulario de login
	* con un mensaje de error
	*/
	public function logados()
	{
	    if (Auth::check()) {
	        return view('logados');
	    }
	
	    return redirect("/")->withSuccess('No tienes acceso, por favor inicia sesión');
    }

    public function home()
	{
	    if (Auth::check()) {
			if(auth()->user()->idPerfil === 1) return redirect("users");
			if(auth()->user()->idPerfil === 2) return redirect("products");
			if(auth()->user()->idPerfil === 3) return redirect("pickup");
	    }
	
	    return redirect("/")->withSuccess('No tienes acceso, por favor inicia sesión');
    }

	public function maps(){

		$config = array();
		$config['center'] = 'auto';
		$config['onboundschanged'] = 'if (!centreGot) {
				var mapCentre = map.getCenter();
				marker_0.setOptions({
					position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
				});
			}
			centreGot = true;';
	
		app('map')->initialize($config);
	
		// set up the marker ready for positioning
		// once we know the users location
		$marker = array();
		app('map')->add_marker($marker);
	
		$map = app('map')->create_map();
		///echo "";

		
		return view('admin.maps', compact('map'));
	}
}

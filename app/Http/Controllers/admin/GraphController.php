<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function report()
    {

        $array_color_default = array('#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de');

        $data = DB::select("SELECT u.name,o.vendedor_id, count(o.id) as cont
                            FROM `order` o 
                            INNER JOIN `users` u 
                            WHERE o.vendedor_id = u.id and o.status = 1
                            group by u.name,o.vendedor_id;"); 
        
        
        $array_labels = array();
        $array_data = array();
        $array_color = array();
        $i = 0;

        foreach ($data as $value) {
            array_push($array_labels, $value->name );
            array_push($array_data, $value->cont );

            if($i >= count($array_color_default)) $i = 0;
            array_push($array_color, $array_color_default[$i] );
            $i++;
        }

        $array_donut["labels"] = $array_labels;
        $array_donut["datasets"][0]["data"] = $array_data;
        $array_donut["datasets"][0]["backgroundColor"] = $array_color;

        $data = DB::select("SELECT u.name,o.conductor_id, count(o.id) as cont
                                FROM `order` o 
                                INNER JOIN `users` u 
                                WHERE o.conductor_id = u.id and o.status = 1
                                group by u.name,o.conductor_id;"); 


        $array_labels = array();
        $array_data = array();
        $array_color = array();
        $i = 0;

        foreach ($data as $value) {
            array_push($array_labels, $value->name );
            array_push($array_data, $value->cont );

            if($i >= count($array_color_default)) $i = 0;
            array_push($array_color, $array_color_default[count($array_color_default)-1-$i] );
            $i++;
        }

        $array_pie["labels"] = $array_labels;
        $array_pie["datasets"][0]["data"] = $array_data;
        $array_pie["datasets"][0]["backgroundColor"] = $array_color;
               
        return view('admin.report.index', compact('array_donut','array_pie'));
    }
}

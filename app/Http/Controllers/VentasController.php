<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;

class VentasController extends Controller
{
    public function crear(Request $req)
    {

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $venta = new Venta();

        if(isset($datos->nombre))
        {
            $venta->nombre = $datos->nombre;
            $venta->descripcion = $datos->descripcion;
            $venta->coleccion = $datos->coleccion;
        }
        //Escribir en la base de datos
        try
        {
            $venta->save();
            $respuesta['msg'] = "venta guardada con id ".$venta->id;
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }
}

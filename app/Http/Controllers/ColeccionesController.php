<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coleccion;

class ColeccionesController extends Controller
{
    public function crear(Request $req)
    {

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $colecciones = new Coleccion();

        if(isset($datos->nombre))
        {
            $colecciones->nombre = $datos->nombre;
            $colecciones->simbolo = $datos->simbolo;
            $colecciones->fecha_edicion = $datos->fecha_edicion;
        }
        //Escribir en la base de datos
        try
        {
            $colecciones->save();
            $respuesta['msg'] = "colecciones guardada con id ".$colecciones->id;
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }
}

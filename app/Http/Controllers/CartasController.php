<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carta;

class CartasController extends Controller
{
    public function crear(Request $req)
    {

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $carta = new Carta();

        if(isset($datos->nombre))
        {
            $carta->nombre = $datos->nombre;
            $carta->descripcion = $datos->descripcion;
            $carta->coleccion = $datos->coleccion;
        }
        //Escribir en la base de datos
        try
        {
            $carta->save();
            $respuesta['msg'] = "carta guardada con id ".$carta->id;
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }
}

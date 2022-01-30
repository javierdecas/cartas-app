<?php

namespace App\Http\Controllers;

use App\Models\CartasColeccions;
use Illuminate\Http\Request;
use App\Models\Coleccion;
use App\Models\Carta;

class ColeccionsController extends Controller
{
    public function crear(Request $req)
    {

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $colecciones = new Coleccion();
        $asociacion = new CartasColeccions();

        
        //Escribir en la base de datos
        try
        {
            if($req->has('carta_id'))
            {
                try
                {
                    $carta = Carta::where('id', $datos->carta_id)->first();
                }
                catch(\Exception $e)
                {
                    $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
                }

            }

            if(isset($carta))
            {
                if(isset($datos->carta_id))
                {
                    $colecciones->nombre = $datos->nombre;
                    $colecciones->simbolo = $datos->simbolo;
                    $colecciones->fecha_edicion = $datos->fecha_edicion;
                    $colecciones->save();
                    
                    $asociacion->coleccions_id = $colecciones->id;
                    $asociacion->cartas_id = $datos->carta_id;
                    $asociacion->save();

                    $respuesta['msg'] = "colecciones guardada con id ".$colecciones->id;
                }
                else
                {
                    $respuesta['msg'] = "Se necesita asociar una carta a la colección.";
                }
            }
            else
            {
                $respuesta['msg'] = "La carta asociada no existe, inserte un id con carta asociada.";
            }
            
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }

    public function crearyasignar(Request $req)
    {

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $colecciones = new Coleccion();
        $asociacion = new CartasColeccions();
        $carta = new Carta();

        
        //Escribir en la base de datos
        try
        {
            if(isset($datos->nombre_coleccion) && isset($datos->nombre_carta))
            {
                $colecciones->nombre = $datos->nombre_coleccion;
                $colecciones->simbolo = $datos->simbolo_coleccion;
                $colecciones->fecha_edicion = $datos->fecha_edicion;
                $colecciones->save();

                $carta->nombre = $datos->nombre_carta;
                $carta->descripcion = $datos->descripcion_carta;
                $carta->save();

                $asociacion->coleccions_id = $colecciones->id;
                $asociacion->cartas_id = $carta->id;
                $asociacion->save();
            }

            $respuesta['msg'] = "coleccion guardada con id ".$colecciones->id." Y carta asociada con id ".$carta->id;
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }

    public function asignar(Request $req)
    {

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $colecciones = new Coleccion();
        $asociacion = new CartasColeccions();
        $carta = new Carta();

        if($req->has('carta_id') && $req->has('coleccion_id'))
        {
            try
            {
                $carta = Carta::where('id', $datos->carta_id)->first();
                $colecciones = Coleccion::where('id', $datos->coleccion_id)->first();
            }
            catch(\Exception $e)
            {
                $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
            }

        }
        
        //Escribir en la base de datos
        try
        {
            
            if(isset($carta) && isset($colecciones))
            {

                $asociacion->coleccions_id = $datos->coleccion_id;
                $asociacion->cartas_id = $datos->carta_id;
                $asociacion->save();
                $respuesta['msg'] = "asociacion guardada con id ".$asociacion->id;
            }else{
                $respuesta['msg'] = "La carta o coledcción no existen, revise los id.";
            }

            
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }
}

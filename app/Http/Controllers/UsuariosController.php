<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuariosController extends Controller
{
    public function crear(Request $req)
    {

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $usuario = new Usuario();

        if(isset($datos->email))
        {
            $usuario->nombre_usuario = $datos->nombre_usuario;
            $usuario->email = $datos->email;
            $usuario->password = $datos->password;
            $usuario->rol = $datos->rol;
        }
        //Escribir en la base de datos
        try
        {
            $usuario->save();
            $respuesta['msg'] = "Usuario guardada con id ".$usuario->id;
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }
    public function login(Request $req, $nombre_usuario, $password)
    {

        $respuesta = ["status" => 1, "msg" => ""];

        // $datos = $req->getContent();

        // //VALIDAR EL JSON

        // $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.


        //Buscar a la persona
        try
        {
            $usuario = Usuario::find($nombre_usuario);

            if($usuario)
            {
                if(isset($password))
                {
                    //comprobar contraseña
                }
                else
                {
                    $respuesta['msg'] = "Introduzca una contraseña.";
                }
            }
            else
            {
                $respuesta["msg"] = "Nombre de usuario no encontrado";
                $respuesta["status"] = 0;
            }
        }
        catch(\Exception $e)
        {
            $respuesta['status'] = 0;
            $respuesta['msg'] = "Se ha producido un error: ".$e->getMessage();
        }

        return response()->json($respuesta);
    }
    public function recuperarPassword(Request $req, $email)
    {

        $respuesta = ["status" => 1, "msg" => ""];

        // $datos = $req->getContent();

        // //VALIDAR EL JSON

        // $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.


        //Buscar a la persona
        try
        {
            $usuario = Usuario::find($email);

            if($usuario)
            {
                $respuesta['msg'] = '' /* Nueva contraseña */ ;
                $usuario->password = '' /* Nueva contraseña */; 
            }
            else
            {
                $respuesta["msg"] = "Nombre de usuario no encontrado";
                $respuesta["status"] = 0;
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

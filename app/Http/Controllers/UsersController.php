<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersController extends Controller
{
    public function crear(Request $req)
    {

        $respuesta = ["status" => 1, "msg" => ""];

        $datos = $req->getContent();

        //VALIDAR EL JSON

        $datos = json_decode($datos); //Se interpreta como objeto. Se puede pasar un parámetro para que en su lugar lo devuelva como array.

        //VALIDAR LOS DATOS

        $usuario = new User();

        
        //Escribir en la base de datos
        try
        {
            if(isset($datos->email))
            {
                $usuario->nombre_usuario = $datos->nombre_usuario;
                $usuario->email = $datos->email;
                $usuario->password = Hash::make($req->password);
                $usuario->rol = $datos->rol;
                $usuario->save();
            }
            $respuesta['msg'] = "Usuario guardado con id ".$usuario->id;
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

        //Buscar a la persona
        try
        {
            $usuario = User::where('nombre_usuario', $nombre_usuario)->first();

            if($usuario)
            {
                //comprobar contraseña
                if (Hash::check($password, $usuario->password))
                {
                    $token = Hash::make(now().$usuario->id);

                    $usuario->api_token = $token;
                    $usuario->save();

                    return response($token);
                }
                else
                {
                    return response('Contraseña incorrecta', 401);
                }
            }
            else
            {
                $respuesta["msg"] = "Nombre de usuario no encontrado";
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

        try
        {
            $usuario = User::where('email', $email)->first();

            if($usuario)
            {
                $newPassword = Str::random(8);
                $newPasswordEnc = Hash::make($newPassword);
                $respuesta['msg'] = $newPassword;
                $usuario->password = $newPasswordEnc; 
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

<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function mostrarUsuario($id)
    {
        $usuario = Usuario::find($id);
        return response()->json($usuario);
    }

    public function mostrarUsuarios()
    {
        return response()->json(Usuario::all());
    }

    public function cadastrarUsuario(Request $request)
    {
        //validação
        $this->validate($request, [
            'usuario' => 'required|min:5|max:20|unique:usuarios,usuario',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);


        $usuario = new Usuario;
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->verificado = 0;
        $usuario->save();

        return response()->json($usuario);
    }

    public function atualizarUsuario(Request $request, $id)
    {  
        $usuario = Usuario::find($id);
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->save();

        return response()->json($usuario);
    }

    public function deletarUsuario($id)
    {
        $usuario = Usuario::find($id);

        if(!$usuario){
            return response()->json('Usuario não encontrado!', 404);
        }

        $usuario->delete();

        return response()->json('Usuario removido com sucesso!', 200);
    }
    //
}

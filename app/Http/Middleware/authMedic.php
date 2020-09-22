<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class authMedic extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
        } catch(\Exception $e){

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->unauthorized('Token Invalido!');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->unauthorized('Token Expirado!');
            }else{
                return $this->unauthorized('Token não encontrado!');
            }
        }

        //verificação cargo usuario
        $sql = "SELECT
                    descricao 
                FROM
                    cargos 
                WHERE
                    id = $user->id_cargo";
        
        $cargo = DB::select($sql);

        if($cargo[0]->descricao == 'MEDICO'){
            return $next($request);
        }

        return $this->unauthorized('Usuario não é Medico!');
    }

    private function unauthorized($message = null){
        return response()->json([
            'message' => $message ? $message : 'You are unauthorized to access this resource',
            'success' => false
        ], 401);
    }
}

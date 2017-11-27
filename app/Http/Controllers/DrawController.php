<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sale;
use Carbon\Carbon;
use App\Article;

class DrawController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rules = [
            'articles_id' => 'required',
            'draws_id' => 'required',
        ];
        
        try {
            // Ejecutamos el validador y en caso de que falle devolvemos la respuesta
            // con los errores
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return [
                    'created' => false,
                    'errors'  => $validator->errors()->all()
                ];
            }
            
            // Si el validador pasa, almacenamos el usuario
            $sale_premiado = Sale::where([
                                            ['created_at','>=', Carbon::today()],
                                            ['created_at','<=', Carbon::today()->addDay(1)],
                                            ['articles_id', $request->articles_id],
                                            ['draws_id', $request->draws_id]
                                        ])->update(['status' => 'PREMIADO']);
            
            $sale_inhabilitado = Sale::where([
                                                ['created_at','>=', Carbon::today()],
                                                ['created_at','<=', Carbon::today()->addDay(1)],
                                                ['draws_id', $request->draws_id],
                                                ['status', '!=','PREMIADO']
                                            ])->update(['status' => 'INHABILITADO']);
            
            return ['created' => 'SUCCESS'];
            
        } catch (Exception $e) {
            // Si algo sale mal devolvemos un error.
            \Log::info('Error creating user: '.$e);
            return \Response::json(['created' => 'ERROR'], 500);
        }
//         return response()->json(['name' => Auth::guard('api')->user()->email]);
    }


}

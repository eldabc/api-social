<?php

namespace App\Http\Controllers\Api;

use App\Models\Score;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScoreController extends Controller
{
    /**
     * Update or create score data to distribuitor sale.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCreateScore(Request $request)
    {
        try{
            $score = Score::updateOrCreate([
                'order_id' => $request->order_id,
                'user_id' => $request->user_id
                ],
                [ 'score' =>  $request->score ]);
            
            return response([ 'score' => $score, 'success' => "Calificación Modificada"]);
            

        }catch (\Exception $exception){
            return Response("Ha ocurrido un error.".$exception->getMessage(), 500, ['Content-Type' => 'text/plain']);
        }
    }
}

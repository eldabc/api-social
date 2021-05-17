<?php

namespace App\Http\Controllers\Api;

use App\Models\Score;
use Illuminate\Http\Request;
use App\Http\Requests\ScoreRequest;
use App\Http\Controllers\Controller;

class ScoreController extends Controller
{
    /**
     * Update or create score data to distribuitor sale.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCreateScore(ScoreRequest $request)
    {
        try{
            $score = Score::updateOrCreate([
                'user_id' => $request->user_id
                ],
                [ 'score' =>  $request->score,
                  'comment' => $request->comment
                ]);
            
            return response([ 'score' => $score, 'success' => "Calificación Modificada"]);
            

        }catch (\Exception $exception){
            return Response("Ha ocurrido un error.".$exception->getMessage(), 500);
        }
    }
}

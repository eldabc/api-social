<?php

namespace App\Http\Controllers\API;

use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StreamRequest;
use Illuminate\Support\Facades\Storage;
use Exception;


class StreamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Stream::orderBy('id', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StreamRequest $request)
    {
        $validated = $request->validated();
        $validated['img'] = Storage::put('streams', $request->file('img'));
        $stream = Stream::create($validated);

        return response([ 'stream' => $stream, 'success' => "Transmisión Creada"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Stream::where('id', $id)->first();
    }

    /**
     * Update stream since admin role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  id $id
     * @return \Illuminate\Http\Response
     */
    public function update(StreamRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            $validated = $request->validated();

            if ($request->hasFile('img')) {
                $chageImg = Stream::findOrFail($id);
                Storage::delete($chageImg->img);
                $validated['img'] = Storage::put('streams', $request->file('img'));
            }

            $stream = Stream::where('id', $id)->update($validated);
            DB::commit();
            return response([ 'stream' => $stream, 'success' => "Transmisión Modificada"]);

        }catch (\Exception $exception){
            DB::rollBack();
            return Response($exception->getMessage(), 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Stream  $stream
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $stream = Stream::findOrFail($id)->delete();
            return response([ 'success' => "Transmisión Eliminada"]);
        }
        catch(Exception $e){
            return Response($e->getMessage(), 500);
        }  
    }   
}

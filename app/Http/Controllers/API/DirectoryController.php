<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Directory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DirectoryRequest;
use Illuminate\Support\Facades\Storage;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Directory::orderBy('id', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectoryRequest $request)
    {
        $validated = $request->validated();
        $validated['img'] = Storage::put('directory', $request->file('img'));
        $directory = Directory::create($validated);

        return response([ 'directory' => $directory, 'success' => "Directorio Creado"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Directory::where('id', $id)->first();
    }

    /**
     * Update Directory since admin role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  id $id
     * @return \Illuminate\Http\Response
     */
    public function update(DirectoryRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            $validated = $request->validated();

            if ($request->hasFile('img')) {
                $chageImg = Directory::findOrFail($id);
                Storage::delete($chageImg->img);
                $validated['img'] = Storage::put('directory', $request->file('img'));
            }

            $directory = Directory::where('id', $id)->update($validated);

            DB::commit();
            return response([ 'directory' => $directory, 'success' => "Directorio Modificado"]);

        }catch (\Exception $exception){
            DB::rollBack();
            return Response($exception->getMessage(), 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Directory  $directory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $product = Directory::findOrFail($id)->delete();
            return response([ 'success' => "Directorio Eliminado"]);
        }
        catch(Exception $e){
            return Response($e->getMessage(), 500);
        }  
    }
}

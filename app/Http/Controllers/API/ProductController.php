<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Plan;
use App\Models\Product;
use App\Models\ResaleData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductEditRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::orderBy('id', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        //$validated['img'] = Storage::put('products', $request->file('img'));
        $product = Product::create($validated);
        
        // foreach(json_decode($request->imgs) as $key => $value){

        // }

        return response([ 'product' => $product, 'success' => "Producto Creado"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::where('id', $id)->first();
    }

    /**
     * Update product since admin role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  id $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductEditRequest $request, $id)
    {
        try{
            DB::beginTransaction();
            $validated = $request->validated();

            // if ($request->hasFile('img')) {
            //     $chageImg = Product::findOrFail($id);
            //     Storage::delete($chageImg->img);
            //     $validated['img'] = Storage::put('products', $request->file('img'));
            // }

            $product = Product::where('id', $id)->update($validated);
            // foreach(json_decode($request->plans) as $key => $value){
            //     if(!empty($value->id))
            //     {
            //         Plan::where('id', $value->id)->update([
            //             "price" => $value->price,
            //             "quantity" => $value->quantity
            //         ]);
            //     }else{
            //         Plan::create([
            //             "price" => $value->price,
            //             "quantity" => $value->quantity,
            //             "product_id" => $id
            //         ]);
            //     }
            // }
            DB::commit();
            return response([ 'product' => $product, 'success' => "Producto Modificado"]);

        }catch (\Exception $exception){
            DB::rollBack();
            return Response($exception->getMessage(), 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $product = Product::findOrFail($id)->delete();
            return response([ 'success' => "Producto Eliminado"]);
        }
        catch(Exception $e){
            return Response($e->getMessage(), 500);
        }  
    }
}

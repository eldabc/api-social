<?php

namespace App\Http\Controllers\API;

use App\Models\Plan;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductEditRequest;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with('plans')->where('status', '!=', 2)->orderBy('id', 'DESC')->get();
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
        $validated['img'] = Storage::put('products', $request->file('img'));
        $product = Product::create($validated);
        
        foreach(json_decode($request->plans) as $key => $value){
                Plan::create([
                    "price" => $value->price,
                    "quantity" => $value->quantity,
                    "product_id" => $product->id,
                ]);
        }

        return response([ 'product' => $product, 'success' => "Producto Creado"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Api\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Product::where('id', $product->id)->with('plans')->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductEditRequest $request, Product $product)
    {
        try{
            $validated = $request->validated();

            if ($request->hasFile('img')) {
                $chageImg = Product::where('id', $product->id)->first();
                Storage::delete($chageImg->img);
                $validated['img'] = Storage::put('products', $request->file('img'));
            }
                    
            Product::where('id', $product->id)->update($validated);
            $d = Plan::where('product_id', $product->id)->delete();

            foreach(json_decode($request->plans) as $key => $value){
                Plan::create([
                    "price" => $value->price,
                    "quantity" => $value->quantity,
                    "product_id" => $product->id,
                ]);
            }
            return response([ 'product' => $product, 'success' => "Producto Modificado"]);

        }catch (\Exception $exception){
            return Response($exception->getMessage(), 500, ['Content-Type' => 'text/plain']);
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
            $product = Product::findOrFail($id);
            Product::where('id', $id)->update(['status' => 2]);
            
            return response([ 'success' => "Producto Eliminado"]);
        }
        catch(Exception $e){
            return Response($e->getMessage(), 500, ['Content-Type' => 'text/plain']);

        }
        
        
    }
}

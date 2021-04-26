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
        return Product::with('plans')->where('status', '!=', 4)->orderBy('id', 'DESC')->get();
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

            if ($request->hasFile('img')) {
                $chageImg = Product::findOrFail($id);
                Storage::delete($chageImg->img);
                $validated['img'] = Storage::put('products', $request->file('img'));
            }

            $product = Product::where('id', $id)->update($validated);
            foreach(json_decode($request->plans) as $key => $value){
                if(!empty($value->id))
                {
                    Plan::where('id', $value->id)->update([
                        "price" => $value->price,
                        "quantity" => $value->quantity
                    ]);
                }else{
                    Plan::create([
                        "price" => $value->price,
                        "quantity" => $value->quantity,
                        "product_id" => $id
                    ]);
                }
            }
            DB::commit();
            return response([ 'product' => $product, 'success' => "Producto Modificado"]);

        }catch (\Exception $exception){
            DB::rollBack();
            return Response($exception->getMessage(), 500);
        }
        
    }

     /**
     * Update or create resale data since user distribuitor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateResaleData(Request $request)
    {
        try{
            $product = ResaleData::updateOrCreate([
                'product_id' => $request->product_id,
                'user_id' => $request->user_id
                ],
                [
                'stock' =>  $request->stock,
                'shipping_value' => $request->shipping_value,
                'delivery_time' => $request->delivery_time,
                'status' => $request->status,
                'unitary_price' => $request->unitary_price,
                ]);
            
            return response([ 'product' => $product, 'success' => "Producto Modificado"]);
            

        }catch (\Exception $exception){
            return Response("Ha ocurrido un error.".$exception->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function deleteProductResale($id)
    {
        try{
            ResaleData::where('id', $id)->update(['status' => 4]);
            return response([ 'success' => "Producto Eliminado"]);
        }
        catch(Exception $e){
            return Response($e->getMessage(), 500);

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
            Product::where('id', $id)->update(['status' => 4]);
            return response([ 'success' => "Producto Eliminado"]);
        }
        catch(Exception $e){
            return Response($e->getMessage(), 500);

        }
        
        
    }
}

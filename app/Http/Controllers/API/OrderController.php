<?php

namespace App\Http\Controllers\API;

use App\Models\Plan;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::with('order_details')->orderBy('id', 'DESC')->get();
    }

    public function productU(){
        $affec = DB::update(
                        'update products set stock = 10000 where id = 1'
                );
        // $client = Product::findOrFail(1);
        //                 $client->update([
        //                     'stock' => 123
        //                 ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();
        
                $validated = $request->validated();
                $validated['status_id'] = 2; //2 = Pendiente
                $order = Order::create($validated);

                $items = [];
                $distr_id = 0;
                $i = 0;
                foreach(json_decode($request->items) as $key => $value){
       
                    $plan = Plan::findOrFail($value->plan_id);


                    if(!empty($value->distr_id)){//sale client 
                        
                        $distr_id = $value->distr_id; //distributor id

                    } else {//sale distribuitor
                       $product = Product::findOrFail($plan->product_id);
                    //    return $value->quantity;
                       $stock = $product->stock - $value->quantity;

                            if ($stock < 0){
                                DB::rollBack();
                                $product = Product::findOrFail($plan->product_id);
                                return Response('Sin Stock suficiente para la compra de '.$product->name .' disponible: '.$product->stock, 500, ['Content-Type' => 'text/plain']);
                            }

                        DB::update(
                            'update products set stock = ? where id = ?', [$stock, $plan->product_id]
                        );
                    }

                    $orderDetails =  OrderDetails::create([
                            "price" => $value->price,
                            "quantity" => $value->quantity,
                            "plan_id" => $value->plan_id,
                            "distr_id" => $distr_id,
                            "order_id" => $order->id,
                    ]);

                        array_push($items, $orderDetails);
$i++;

                }
                    $order['order_details'] = $items;
            
            DB::commit();
            return response([ 'order' => $order, 'success' => "Pedido Creado"]);
        
        } catch (\Exception $e) {
            DB::rollBack();
            return Response('Ha ocurrido un problema'.$e->getMessage(), 500, ['Content-Type' => 'text/plain']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  users_id $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::with('order_details')->where('user_id', $id)->orderBy('id', 'DESC')->get();
    }
}

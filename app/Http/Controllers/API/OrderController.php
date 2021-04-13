<?php

namespace App\Http\Controllers\API;

use App\Models\Plan;
use App\Models\Order;
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
                foreach(json_decode($request->items) as $key => $value){
       
                    if(!empty($value->distr_id)) $distr_id = $value->distr_id; //distributor id

                    $plan = Plan::findOrFail($value->plan_id);
                    $orderDetails =  OrderDetails::create([
                            "price" => $plan->price,
                            "quantity" => $plan->quantity,
                            "plan_id" => $plan->id,
                            "distr_id" => $distr_id,
                            "order_id" => $order->id,
                    ]);
                    
                        array_push($items, $orderDetails);
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

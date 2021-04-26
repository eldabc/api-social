<?php

namespace App\Http\Controllers\API;

use ErrorException;
use App\Models\Plan;
use App\Models\Order;
use App\Models\Total;
use App\Models\Product;
use App\Models\ResaleData;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Services\EpaycoService;
use App\Mail\CreatedOrderMailable;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\DirectSaleRequest;

class OrderController extends EpaycoService //Controller//
{
    
    private $pay_service;
    public function __construct()
    {
        $this->pay_service = new EpaycoService(); 

    }

    /**
     * Display a listing orders. (view my orders)
     * @param user_id $id paginate $paginate
     * @return \Illuminate\Http\Response
     */
    public function index($user_id, $paginate)
    {
        $details = OrderDetails::with('plan.product')->orderBy('id', 'DESC')->paginate($paginate);
        return $details->load('order.status_order')->where('order.user_id',$user_id);
    }

    /**
     * Store a new orders. (view: orders distribuitor, client)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
                $validated = $request->validated();

                    $pay = $this->pay_service->createPayment();
                    
                    if ($e = isException($pay)) return $e;
                
                $order = Order::create($validated);

                $items = []; $total_purchases = 0;
                foreach(json_decode($request->items) as $key => $value){

                    $res = stock($value, !empty($order['distr_id']));
                        if ($res['stock'] < 0){
                            DB::rollBack();
                            return Response('Sin Stock suficiente para la compra '.$res['product']->name .' disponible: '.$res['product']->stock, 500, ['Content-Type' => 'text/plain']);
                        }

                    updateStock($res['table'],$res['stock'], $res['plan']->product_id);
                    $orderDetails =  OrderDetails::create([
                            "price" => $value->price,
                            "quantity" => $value->quantity,
                            "plan_id" => $value->plan_id,
                            "order_id" => $order->id
                    ]);

                    array_push($items, $orderDetails);
                }
                    $user = Order::getTotalByUser($order['user_id']);                    
                    if($user) $total_purchases = $user->total_purchases;   

                    // Update or create total for the user who buys
                    Order::updateOrCreateTotalByUser($order['user_id'], $total_to_update = 'total_purchases', $total_purchases, $order['total_order']);

                    // Update or create total when the user who buys is client
                    if (!empty($order['distr_id']) > 0) Order::totalDistr($order['distr_id'],$order['total_order']);
            
                $order['order_details'] = $items;
            send_mail_order($order);
            
            DB::commit();
            return response([ 'order' => $order, 'success' => "Pedido Creado"]);
        
        } catch (\Exception $e) {
            DB::rollBack();
            return Response('Ha ocurrido un problema. '.$e->getMessage(), 500);
        }
    }

    /**
     * Store a new direct sale. (view: direct sale)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDirectSale(DirectSaleRequest $request)
    {
        DB::beginTransaction();
        try {
                $validated = $request->validated();
                $validated['status_id'] = 1; //1 = Entregado

                $order = Order::create($validated);
                $items = [];
                foreach(json_decode($request->items) as $key => $value){

                    $res = stock($value,$order['distr_id']);
                        if ($res['stock'] < 0){
                            DB::rollBack();
                            return Response('Sin Stock suficiente para la compra '.$res['product']->name .' disponible: '.$res['product']->stock, 500, ['Content-Type' => 'text/plain']);
                        }

                    updateStock($res['table'],$res['stock'],$res['plan']->product_id);
                    $orderDetails =  OrderDetails::create([
                            "price" => $value->price,
                            "quantity" => $value->quantity,
                            "plan_id" => $value->plan_id,
                            "order_id" => $order->id,
                    ]);

                    array_push($items, $orderDetails);
                }
                
                // Update or create total when the user who buys is client
                Order::totalDistr($order['distr_id'],$order['total_order']);
                $order['order_details'] = $items;
     
            DB::commit();
            return response([ 'order' => $order, 'success' => "Venta Directa Registrada"]);
        
        } catch (\Exception $e) {
            DB::rollBack();
            return Response('Ha ocurrido un problema. '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  order_id $id (view detail order)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::with('order_details', 'status_order','order_details.distribuitor', 'score')->where('id', $id)->get();
    }
}

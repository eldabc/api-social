<?php

namespace App\Http\Controllers\API;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
     /**
     * General list of distribuitors and clients. (View general list)
     *
     * @param  paginate $paginate
     * @return \Illuminate\Http\Response
     */
    function listDistriClient($paginate)
    {
        return  User::role([2,3])->with(['scores'])
                        ->paginate($paginate);
    }

    /**
     * Details distribuitors and clients.
     *
     * @param user_id $id paginate $paginate
     * @return \Illuminate\Http\Response
     */
    function detailDistriClient($id)
    {
        
        $order = Order::with('order_details', 'order_details.distribuitor', 'score')->where('orders.user_id', $id)
                     ->orderby('orders.id','DESC')->get();
        
        return  response([ 'order' => $order, 'roles' => User::find($id)->getRoleNames()]);
    }

    /**
     * List Orders distribuitors and clients.
     *
     * @param role_id $role_id paginate $paginate
     * @return \Illuminate\Http\Response
     */
    function listOrdersByRole($role_id, $paginate)
    {
        return User::role($role_id)
                    ->join('orders', 'orders.user_id', 'users.id')
                    ->join('order_details', 'order_details.order_id', 'orders.id')  
                    ->join('status_orders', 'orders.status_id', 'status_orders.id')
                    ->join('plans', 'order_details.plan_id', 'plans.id')   
                    ->join('products', 'plans.product_id', 'products.id')  
                    ->select(
                            'products.name as name_product', 'products.presentation',
                            'order_details.quantity', 'users.name as name_user',
                            'orders.total_order',
                            'status_orders.status',
                            )
                    ->paginate($paginate);
    }

    /**
     * Change status to orders.
     *
     * @param int $order_id int $status_id
     * @return \Illuminate\Http\Response
     */
    function changeStatusOrder($order_id, $status_id)
    {
        try{
            $order = Order::where('id', $order_id)->update([
                "status_id" => $status_id
            ]);

            return response([ 'success' => "Estatus Modificado"]);

        }catch (\Exception $exception){
            return Response($exception->getMessage(), 500, ['Content-Type' => 'text/plain']);
        }
    }

    /**
     * Change status to products.
     *
     * @param int $product_id int $status_id
     * @return \Illuminate\Http\Response
     */
    function changeStatusProduct($product_id, $status_id)
    {
        try{
            $order = Product::where('id', $product_id)->update([
                "status" => $status_id
            ]);

            return response([ 'success' => "Estatus Modificado"]);

        }catch (\Exception $exception){
            return Response($exception->getMessage(), 500, ['Content-Type' => 'text/plain']);
        }
    }
}

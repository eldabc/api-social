<?php

namespace App\Http\Controllers\API;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
     /**
     * General list of distribuitors and clients.
     *
     * @param  
     * @return \Illuminate\Http\Response
     */
    function listDistriClient()
    {
        return  User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
                    ->join('roles', 'roles.id', 'model_has_roles.role_id')
                    ->where('model_has_roles.role_id', '!=', 1)// 1 = admin user
                    ->select('users.*','roles.name as role_name')->get();
    }

    /**
     * Details distribuitors and clients.
     *
     * @param user_id $id
     * @return \Illuminate\Http\Response
     */
    function detailDistriClient($id)
    {
        $user = User::with('roles')->where('id', $id)->first();

        $join = '';
        $select = '';
        if( $user->roles[0]->id === 2 )//user cliente
        {
            $query = 
            Order::join('order_details', 'order_details.order_id', 'orders.id')  
                    ->join('users', 'users.id', 'order_details.distr_id')
                    ->join('plans', 'order_details.plan_id', 'plans.id')   
                    ->join('products', 'plans.product_id', 'products.id')   
                    ->where('orders.user_id', $id)
                    ->select(
                            'products.name as name_product', 'products.presentation',
                            'order_details.quantity', 'users.name as name_distr', 'orders.created_at as created_at_order','orders.delivery_address as delivery_address_order',
                            'orders.city as city_order','orders.total_order',
                            )
                    ->get();

        }else {
            $query = 
                    Order::join('order_details', 'order_details.order_id', 'orders.id')  
                            ->join('plans', 'order_details.plan_id', 'plans.id')   
                            ->join('products', 'plans.product_id', 'products.id')   
                            ->where('orders.user_id', $id)
                            ->select(
                                    'products.name as name_product', 'products.presentation',
                                    'order_details.quantity', 'orders.created_at as created_at_order','orders.delivery_address as delivery_address_order',
                                    'orders.city as city_order','orders.total_order',
                                    )
                            ->get();

        }
        $user['transactions'] = $query;
        return  $user;
    }
}

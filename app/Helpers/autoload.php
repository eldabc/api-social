<?php

use App\Models\Plan;
use App\Models\Product;
use App\Models\ResaleData;
use App\Mail\CreatedOrderMailable;
use Illuminate\Support\Facades\Mail;

  /**
   * Register exceptions.
   *
   * @param value $r
   * @return stdClass Object token card id
   */
  function isException($r)
  {
    if ( json_encode($r->status) === 'false')
      return json_encode($r->data->description).' '.json_encode($r->data->errors);
      else return false;
  }

   /**
   * Discount stock by role.
   *
   * @param value $value
   * @return array
   */
  function stock($value)
  {
    $plan = Plan::findOrFail($value->plan_id);

      if(!empty($value->distr_id)){ //sale client 
        $distr_id = $value->distr_id;

        $product = ResaleData::findOrFail($plan->product_id);
        $table = 'resale_data';

    } else { //sale distribuitor
        $distr_id = 0;
        $product = Product::findOrFail($plan->product_id);
        $table = 'products';
    }

    return [ 'plan' => $plan,  'distr_id' =>  $distr_id, 'product' => $product, 'table' => $table, 'stock' => $product->stock - $value->quantity ];
  }


  /**
   * Main in create.
   *
   * @param order $order
   * @return array
   */ 
  function send_mail_order($order)
  {
      $data = [
        'name' => $order->name, 
        'phone' => $order->phone, 
        'email' => $order->email, 
        'delivery_address' => $order->delivery_address, 
        'total_order' => $order->total_order, 
        'items' => $order['order_details'] 
      ];
    
    Mail::to($order->email)->send(new CreatedOrderMailable($data));
  }
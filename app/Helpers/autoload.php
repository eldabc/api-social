<?php

use App\Models\Plan;
use App\Models\Product;
use App\Models\ResaleData;
use App\Mail\CreatedUserMailable;
use App\Mail\CreatedOrderMailable;
use App\Mail\ChangePasswordMailable;
use Illuminate\Support\Facades\DB;
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
   * Update stock in data base.
   *
   * @param $table, $stock, $product_id
   * @return array
   */
  function updateStock($table, $stock, $product_id)
  {
    DB::update(
      'update '.$table.' set stock = ? where id = ?', [$stock, $product_id]
    );
  }

  /**
   * Mail in create user.
   *
   * @param order $order
   * @return array
   */ 
  function send_mail_user($user)
  { 
    Mail::to($user->email)->send(new CreatedUserMailable($user));
  }

  /**
   * Mail Change Password.
   *
   * @param email $email, token $token
   * @return array
   */ 
  function send_mail_change_pass($email, $token)
  {
      $data = [
        'email' => $email, 
        'token' => $token
      ];
    
    Mail::to($email)->send(new ChangePasswordMailable($data));
  }
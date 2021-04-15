<?php

namespace App\Http\Controllers\API;

// use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Request;
use App\Services\EpaycoService;

class PayTestController extends EpaycoService
{
    private $service;
    public function __construct()
    {
        $this->service = new EpaycoService(); 

    }

    function payTest(Request $request){
        $token = $this->service->createTokenCreditCard();
        // $token = $this->service->createPayment();
        print_r($token);
    }
}

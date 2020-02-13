<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

use App\Models\PaymentMethod;
use App\Http\Resources\PaymentMethod as PaymentMethodResource;

class PaymentController extends ApiController
{  
    public function __construct()
    {
        parent::__construct();
    }
    public function paymentMethods(){
        $paymentMethods = PaymentMethodResource::Collection(PaymentMethod::where(['isActive'=>1])->get());
        return $paymentMethods->additional(['status'=>true,'message'=>__('api.success')]);
    }
}

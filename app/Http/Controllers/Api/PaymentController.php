<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

use App\Models\PaymentMethod;
use App\Http\Resources\PaymentMethod as PaymentMethodResource;
use App\Models\RestaurantPaymentMethod;

class PaymentController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function paymentMethods($id){
        $paymentMethods = PaymentMethodResource::Collection(RestaurantPaymentMethod::where(['restaurant_id'=>$id])->get());
        return $paymentMethods->additional(['status'=>true,'message'=>__('api.success')]);
    }
}

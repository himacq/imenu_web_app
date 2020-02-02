<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PaymentMethod;
use App\Http\Resources\PaymentMethod as PaymentMethodResource;

class PaymentController extends Controller
{
    public function paymentMethods(){
        $paymentMethods = PaymentMethodResource::Collection(PaymentMethod::where(['isActive'=>1])->get());
        return $paymentMethods->additional(['status'=>true,'message'=>__('api.success')]);
    }
}

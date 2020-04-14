@extends('layouts.print')

@section('content')

    <!-- Main Content -->
    <div class="row" style="margin-top: 30px;">

        <div class="col-md-12">
            <div class="portlet light bordered">


                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-social-dribbble font-purple-soft"></i>
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('orders.order_details')}}</span>
                    </div>

                </div>
                <div class="portlet-body">


                    <div class="panel panel-default" id="printableArea">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-info-circle"></i> {{trans('orders.order')}} (#{{$order->order->id}})</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td style="width: 50%;" class="text">{{trans('orders.order_details')}}</td>
                                    <td style="width: 50%;" class="text">{{trans('orders.order_address')}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text">
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.order_restaurant_number')}} </div>
                                            <div class="col-md-7 value"> {{$order->id }}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.sub_total')}} </div>
                                            <div class="col-md-7 value">{{$order->sub_total}}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.order_date')}} </div>
                                            <div class="col-md-7 value"> {{$order->created_at}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.payment_method')}}</div>
                                            <div class="col-md-7 value"> {{$order->payment_method->translate('name')}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.customer_name')}} </div>
                                            <div class="col-md-7 value"> {{$order->order->customer->name}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.customer_email')}} </div>
                                            <div class="col-md-7 value"> {{$order->order->customer->email}}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name">{{trans('orders.customer_phone')}} </div>
                                            <div class="col-md-7 value"> {{$order->order->customer->phone}}</div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.customer_mobile')}}</div>
                                            <div class="col-md-7 value"> {{$order->order->customer->mobile}} </div>
                                        </div>
                                    </td>
                                    <td class="text">
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.address_type')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->address_type}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.description')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->description}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.formated_address')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->formated_address}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.street')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->street}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.city')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->city}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.house_no')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->house_no}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.house_name')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->house_name}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.floor_no')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->floor_no}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.apartment_no')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->apartment_no}} </div>
                                        </div>
                                        <div class="row static-info">
                                            <div class="col-md-5 name"> {{trans('orders.governorate')}} </div>
                                            <div class="col-md-7 value"> {{$order->address->governorate}} </div>
                                        </div>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td class="text">{{trans('orders.product')}}</td>
                                    <td class="text">{{trans('orders.options')}}</td>
                                    <td class="text">{{trans('orders.ingredients')}}</td>
                                    <td class="text">{{trans('orders.qty')}}</td>
                                    <td class="text">{{trans('orders.price')}}</td>
                                    <td class="text">{{trans('orders.sub_total')}}</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->products as $product)
                                    <?php
                                    $total = 0;
                                    $total = $product->price * $product->qty;
                                    ?>
                                    <tr>
                                        <td class="text-left">
                                            {{$product->product->translate('name')}}
                                            <br>
                                            &nbsp;<small> - {{trans('orders.minutes_required')}} : {{$product->product->minutes_required}}</small>

                                        </td>
                                        <td class="text">
                                            @if($product->options)
                                                @foreach($product->options as $option)
                                                    <?php
                                                    $total += $option->price * $option->qty;
                                                    ?>
                                                    &nbsp;<small>{{$option->option->translate('name')}} ({{$option->price}}{{trans('main.currency')}})</small>
                                                    <br>
                                                @endforeach
                                            @endif
                                        </td>

                                        <td class="text">
                                            @if($product->ingredients)
                                                @foreach($product->ingredients as $ingredient)
                                                    &nbsp;<small>{{$ingredient->ingredient->translate('name')}}</small>
                                                    <br>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text">{{$product->qty}}</td>
                                        <td class="text">{{$product->price}}</td>
                                        <td class="text">{{$total}}{{trans('main.currency')}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-right">{{trans('orders.sub_total')}}</td>
                                    <td class="text">{{$order->sub_total}}{{trans('main.currency')}}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>




                </div>
            </div>

        </div>
    </div>



    <!-- END SAMPLE FORM PORTLET-->


@stop




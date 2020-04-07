@extends('layouts.main')

@section('content')

    <!-- Main Content -->
    <div class="row" style="margin-top: 30px;">

        <div class="col-md-12">
            <div class="portlet light bordered">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-social-dribbble font-purple-soft"></i>
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('orders.order_details')}}</span>



                    </div>

                    <div class="actions">
                            <a class="btn grey-salsa btn-sm active" href="{{url('orders/print/'.$order->id)}}" target="_blank">Print</a>
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
                                                    @role('superadmin')
                                                    <div class="row static-info">
                                                        <div class="col-md-5 name"> {{trans('orders.restaurant')}} </div>
                                                        <div class="col-md-7 value"> {{$order->restaurant->name }}</div>
                                                    </div>
                                                    @endrole
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
                                                        <a target="_blank" href="{{ url('products/'.$product->product->id.'/edit') }}">{{$product->product->translate('name')}}</a>
                                                        <br>
                                                        &nbsp;<small> - {{trans('orders.minutes_required')}} : {{$product->product->minutes_required}}</small>
                                                        @if($product->options)
                                                            @foreach($product->options as $option)
                                                                <?php
                                                                $total += $option->price * $option->qty;
                                                                ?>
                                                                <br>
                                                                &nbsp;<small> + {{$option->qty}} {{$option->option->translate('name')}} ({{$option->price}}{{trans('main.currency')}})</small>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="text">{{$product->qty}}</td>
                                                    <td class="text">{{$product->price}}</td>
                                                    <td class="text">{{$total}}{{trans('main.currency')}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-right">{{trans('orders.sub_total')}}</td>
                                                <td class="text">{{$order->sub_total}}{{trans('main.currency')}}</td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-comment-o"></i>{{trans('orders.order_status_history')}}</h3>
                        </div>
                        <div class="panel-body">

                            <div class="col-md-6">

                                <form class="form-horizontal" action="{{ route('orders.update',$order->id) }}" method="post">
                                    {{csrf_field()}}
                                    {{ method_field('PATCH') }}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">{{trans('orders.status')}}</label>
                                        <div class="col-sm-10">
                                            <select name="order_status" id="input-order-status" class="form-control">
                                                @foreach($order_status as $status)
                                                    <option value="{{$status->id}}">{{$status->translate('display_text')}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-12">
                                                <input type="submit" class="btn btn-success" value="{{trans('main.save')}}">
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div id="history" class='col-md-6'>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td class="text">{{trans('orders.created_at')}}</td>
                                            <td class="text">{{trans('orders.status')}}</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->status as $status)
                                            <tr>
                                                <td class="text">{{$status->created_at}}</td>
                                                <td class="text">{{$status->status_text->translate('display_text')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>



                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-info-circle"></i> {{trans('orders.user_review')}}</h3>
                        </div>
                        <div class="panel-body">
                            @if(isset($order->user_review->review_rank))

                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td class="text">
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> {{trans('orders.review_text')}} </div>
                                                <div class="col-md-7 value"> {{$order->user_review->review_text }}</div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> {{trans('orders.review_rank')}} </div>
                                                <div class="col-md-7 value">{{$order->user_review->review_rank}}</div>
                                            </div>
                                            <div class="row static-info">
                                                <div class="col-md-5 name"> {{trans('orders.created_at')}} </div>
                                                <div class="col-md-7 value"> {{$order->user_review->created_at}} </div>
                                            </div>


                                        </td>

                                    </tr>
                                    </tbody>
                                </table>



                            @else

                                <form id='form-user' class="form-horizontal" action="{{ route('orders.review_customer',$order->id) }}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">{{trans('orders.review_text')}}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="review_text" value="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-order-status">{{trans('orders.review_rank')}}</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="review_rank" value="5" />
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-12">
                                                <input type="submit" class="btn btn-success" value="{{trans('main.save')}}">
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            @endif

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>



    <!-- END SAMPLE FORM PORTLET-->


@stop


@push('css')
    <link href="{{url('')}}/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css" rel="stylesheet" type="text/css" />

@endpush
@push('js')
    <script src="{{url('')}}/assets/global/plugins/fuelux/js/spinner.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PA        GE ONLY -->
    <script>


        $(document).ready(function () {
            $("input[name='review_rank']").TouchSpin({
                min: 1,
                max: 5,
                step: 1
            });

            $('#form-user').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    review_text: {
                        required: true
                    },

                },
                messages: {
//name: "blabla",
                },

                invalidHandler: function (event, validator) { //display error alert on form submit

                },
                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },
                success: function (label) {
                    label.closest('.form-group').removeClass('has-error');
                    label.remove();
                },
                errorPlacement: function (error, element) {
                    if (element.attr("name") == "tnc") { // insert checkbox errors after the container
                        error.insertAfter($('#register_tnc_error'));
                    } else if (element.closest('.input-icon').size() === 1) {
                        error.insertAfter(element.closest('.input-icon'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });


        });
    </script>



@endpush

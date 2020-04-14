@extends('layouts.main')

@section('content')
    <form id='form-data' action="{{ url('reports/financial_bills_print') }}" method="post" target="_blank" >
    @csrf
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

                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">{{$location_title}}</span>
                            </div>

                        </div>

                        <div class="portlet-body form">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 control-label"> {{trans('reports.select_date')}} </label>
                                        <div class="col-md-6">
                                            <div class="input-group input-large date-picker input-daterange"
                                                 data-date-format="yyyy-mm-dd">
                                                <input type="text" required class="form-control" value="{{$from}}" name="from" autocomplete="off">
                                                <span class="input-group-addon"> {{trans('reports.to')}} </span>
                                                <input type="text" required class="form-control" value="{{$to}}" name="to" autocomplete="off">

                                            </div>

                                        </div>

                                    </div>
                                </div>

                                @role(['superadmin','d'])
                                <div class="form-group">
                                    <div class="row">
                                    <label class="col-md-3 control-label">{{trans('reports.restaurant')}}</label>
                                    <div class="col-md-6">
                                        <select name="restaurant_id" class="form-control" style="margin-bottom: 13px;">
                                            @foreach($restaurants as $restaurant)
                                                <option value="{{$restaurant->id}}" >{{$restaurant->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </div>
                                </div>
                                @endrole

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 control-label">{{trans('orders.payment_method')}}</label>
                                        <div class="col-md-6">
                                            <select name="payment_method" class="form-control" style="margin-bottom: 13px;">
                                                @foreach($payment_methods as $method)
                                                    <option value="{{$method->id}}" >{{$method->translate('name')}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-3 control-label">{{trans('reports.paid')}}</label>
                                        <div class="col-md-6">
                                            <select name="paid" class="form-control" style="margin-bottom: 13px;">
                                                <option value="-1" >{{trans('reports.all')}}</option>
                                                <option value="1" >{{trans('main.yes')}}</option>
                                                <option value="0" >{{trans('main.no')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn btn-primary">{{trans('reports.show')}}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>




        </div>

    </form>

@stop

@push('css')


    <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
@endpush
@push('js')


    <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>


@endpush

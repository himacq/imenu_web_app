@extends('layouts.print')

@section('content')

    <!-- Main Content -->
    <div class="row" style="margin-top: 30px;">

        <div class="col-md-12">
            <div class="portlet light bordered">


                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-social-dribbble font-purple-soft"></i>
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('reports.financial_bills')}}</span>
                    </div>

                </div>
                <div class="portlet-body">


                    <div class="panel panel-default" id="printableArea">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-info-circle"></i> {{$payment_method->translate('name')}} {{trans('reports.financial_bills')}} {{$from}} {{trans('reports.to')}} {{$to}}</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td>{{$restaurant->name}}</td>
                                </tr>
                                </thead>

                            </table>


                            <table class="table table-bordered">
                                <thead>

                                <tr>

                                    <th>{{trans('reports.bill_no')}}</th>
                                    <th>{{trans('orders.order_id')}}</th>
                                    <th>{{trans('reports.distance_exceeded')}}</th>
                                    <th>{{trans('restaurants.commision')}}</th>
                                    <th>{{trans('restaurants.discount')}}</th>
                                    <th>{{trans('orders.sub_total')}}</th>
                                    @if($payment_method->id==1)
                                    <th>{{trans('reports.credit')}}</th>
                                    @else
                                    <th>{{trans('reports.debit')}}</th>
                                    @endif
                                    <th>{{trans('reports.paid')}}</th>
                                    <th>{{trans('reports.paid_at')}}</th>
                                    <th>{{trans('main.created_at')}}</th>

                                </tr>
                                </thead>

                                @if(!(empty($reportData)))
                                   <?php
                                   $total = 0;
                                   $credits = 0;
                                   $debits = 0;
                                    ?>
                                    <tbody>
                                    @foreach($reportData as $data)

                                        <tr>
                                            <td>{{$data->id}}</td>
                                            <td>{{$data->order_id}}</td>
                                            <td>{{($data->distance_exceeded?trans('main.yes'):trans('main.no'))}}</td>
                                            <td>%{{$data->commision}}</td>
                                            <td>%{{$data->discount}}</td>
                                            <td>{{trans('main.currency')}}{{$data->sub_total}}</td>
                                            @if($payment_method->id==1)
                                                <td>{{trans('main.currency')}}{{$data->credit}}</td>
                                            @else
                                                <td>{{trans('main.currency')}}{{$data->debit}}</td>
                                            @endif
                                            <td>{{($data->paid?trans('main.yes'):trans('main.no'))}}</td>
                                            <td>{{($data->paid_at?date('d-m-Y', strtotime($data->paid_at)):'')}}</td>
                                            <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
                                        </tr>

                                        <?php
                                        $total+=$data->sub_total;
                                        $credits+=$data->credit;
                                        $debits+=$data->debit;
                                        ?>

                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th colspan="5">
                                            {{trans('reports.total')}}
                                        </th>
                                        <th>{{trans('main.currency')}}{{$total}}</th>
                                        @if($payment_method->id==1)
                                            <td>{{trans('main.currency')}}{{$credits}}</td>
                                        @else
                                            <td>{{trans('main.currency')}}{{$debits}}</td>
                                        @endif

                                        <th></th>
                                        <th></th>
                                        <th></th>

                                    </tr>
                                    </tfoot>
                                @endif
                            </table>

                        </div>
                    </div>




                </div>
            </div>

        </div>
    </div>



    <!-- END SAMPLE FORM PORTLET-->


@stop




@extends('layouts.print')

@section('content')

    <!-- Main Content -->
    <div class="row" style="margin-top: 30px;">

        <div class="col-md-12">
            <div class="portlet light bordered">


                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-social-dribbble font-purple-soft"></i>
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('reports.financial')}}</span>
                    </div>

                </div>
                <div class="portlet-body">


                    <div class="panel panel-default" id="printableArea">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-info-circle"></i> {{trans('reports.financial')}} {{$from}} {{trans('reports.to')}} {{$to}}</h3>
                        </div>
                        <div class="panel-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td>{{trans('reports.credit')}}</td>
                                    <td>{{$credit}}</td>
                                    <td>{{trans('reports.debit')}}</td>
                                    <td>{{$debit}}</td>
                                </tr>
                                <tr>
                                    <td>{{trans('reports.total')}}</td>
                                    <td>{{$total}}</td>
                                    <td>{{trans('reports.orders')}}</td>
                                    <td>{{$counts}}</td>
                                </tr>
                                </thead>

                            </table>


                            <table class="table table-bordered">
                                <thead>

                                <tr>

                                    <th>{{trans('reports.bill_no')}}</th>
                                    <th>{{trans('orders.order_id')}}</th>
                                    @role(['superadmin','d'])
                                    <th>{{trans('orders.restaurant')}}</th>
                                    @endrole
                                    <th>{{trans('orders.payment_method')}}</th>
                                    <th>{{trans('reports.distance_exceeded')}}</th>
                                    <th>{{trans('restaurants.commision')}}</th>
                                    <th>{{trans('restaurants.discount')}}</th>
                                    <th>{{trans('orders.sub_total')}}</th>
                                    <th>{{trans('reports.credit')}}</th>
                                    <th>{{trans('reports.debit')}}</th>
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
                                            @role(['superadmin','d'])
                                            <td>{{$data->restaurant->name}}</td>
                                            @endrole
                                            <td>{{$data->payment_method->translate('name')}}</td>
                                            <td>{{($data->distance_exceeded?trans('main.yes'):trans('main.no'))}}</td>
                                            <td>%{{$data->commision}}</td>
                                            <td>%{{$data->discount}}</td>
                                            <td>{{trans('main.currency')}}{{$data->sub_total}}</td>
                                            <td>{{trans('main.currency')}}{{$data->credit}}</td>
                                            <td>{{trans('main.currency')}}{{$data->debit}}</td>
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
                                        <th @role(['superadmin','d']) colspan="6" @endrole
                                        @role('admin') colspan="5" @endrole> </th>
                                        <th >
                                            {{trans('reports.total')}}
                                        </th>
                                        <th>{{trans('main.currency')}}{{$total}}</th>
                                        <th>{{trans('main.currency')}}{{$credits}}</th>
                                        <th>{{trans('main.currency')}}{{$debits}}</th>
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




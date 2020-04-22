@extends('layouts.print')

@section('content')

    <!-- Main Content -->
    <div class="row" style="margin-top: 30px;">

        <div class="col-md-12">
            <div class="portlet light bordered">


                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-social-dribbble font-purple-soft"></i>
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('reports.orders')}}</span>
                    </div>

                </div>
                <div class="portlet-body">


                    <div class="panel panel-default" id="printableArea">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-info-circle"></i> {{trans('reports.orders')}} {{$from}} {{trans('reports.to')}} {{$to}}</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-bordered">
                                <thead>

                                <tr>

                                    <th>{{trans('orders.order_id')}}</th>
                                    @role('superadmin')
                                    <th>{{trans('orders.restaurant')}}</th>
                                    @endrole
                                    <th>{{trans('orders.customer')}}</th>
                                    <th>{{trans('orders.status')}}</th>
                                    <th>{{trans('orders.qty')}}</th>
                                    <th>{{trans('orders.sub_total')}}</th>
                                    <th>{{trans('main.created_at')}}</th>

                                </tr>
                                </thead>

                                @if(!(empty($reportData)))
                                    <?php
                                    $total = 0;
                                    ?>
                                    <tbody>
                                    @foreach($reportData as $data)


                                        <tr>
                                            <td>{{$data->id}}</td>
                                            @role('superadmin')
                                            <td>{{$data->restaurant->name}}</td>
                                            @endrole
                                            <td>{{$data->order->customer->name}}</td>
                                            <td>

                                                <?php
                                                switch ($data->status->last()->status){

                                                    case \Config::get('settings.new_order_status'):
                                                        echo '<span class="label label-sm label-danger">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                        break;

                                                    case \Config::get('settings.payment_order_status'):
                                                        echo '<span class="label label-sm label-info">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                        break;

                                                    case \Config::get('settings.progress_order_status'):
                                                        echo '<span class="label label-sm label-warning">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                        break;

                                                    case \Config::get('settings.complete_order_status'):
                                                        echo '<span class="label label-sm label-success">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                        break;

                                                    case \Config::get('settings.cancled_order_status'):
                                                        echo '<span class="label label-sm label-default">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                        break;

                                                    case \Config::get('settings.delivered_order_status'):
                                                        echo '<span class="label label-sm label-primary">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                        break;

                                                    case \Config::get('settings.rejected_order_status'):
                                                        echo '<span class="label label-sm label-rejected">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                        break;

                                                    default:
                                                        echo '<span class="label label-sm label-default">'
                                                            .$data->status->last()->status_text->translate('display_text')
                                                            .'</span>';
                                                }
                                                ?>

                                            </td>
                                            <td>{{$data->products->sum('qty')}}</td>
                                            <td>${{$data->sub_total}}</td>
                                            <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
                                        </tr>


                                        <?php
                                        $total+=$data->sub_total;
                                        ?>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th @role('superadmin') colspan="4" @endrole
                                        @role('admin') colspan="3" @endrole> </th>
                                        <th >
                                            {{trans('reports.total')}}
                                        </th>
                                        <th id="total">
                                            {{trans('main.currency')}}{{$total}}
                                        </th>
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




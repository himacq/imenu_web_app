@extends('layouts.print')

@section('content')

    <!-- Main Content -->
    <div class="row" style="margin-top: 30px;">

        <div class="col-md-12">
            <div class="portlet light bordered">


                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-social-dribbble font-purple-soft"></i>
                        <span class="caption-subject font-purple-soft bold uppercase">{{trans('reports.financial_not_paid')}}</span>
                    </div>

                </div>
                <div class="portlet-body">


                    <div class="panel panel-default" id="printableArea">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-info-circle"></i>{{$payment_method->translate('name')}} {{trans('reports.financial_not_paid')}} {{$from}} {{trans('reports.to')}} {{$to}}</h3>
                        </div>
                        <div class="panel-body">


                            <table class="table table-bordered">
                                <thead>

                                <tr>

                                    <th>{{trans('reports.restaurant')}}</th>
                                    <th>{{trans('reports.not_paid_amount')}}</th>
                                    <th>{{trans('reports.bill_counts')}}</th>

                                </tr>
                                </thead>

                                @if(!(empty($reportData)))
                                   <?php
                                   $total = 0;
                                   $counts = 0;
                                    ?>
                                    <tbody>
                                    @foreach($reportData as $data)

                                        <tr>
                                            <td>{{$data->restaurant->name}}</td>
                                            <td>{{$data->total}}</td>
                                            <td>{{$data->counts}}</td>
                                        </tr>

                                        <?php
                                        $total+=$data->total;
                                        $counts+=$data->counts;
                                        ?>

                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <td >
                                            {{trans('reports.total')}}
                                        </td>
                                        <td>{{trans('main.currency')}}{{$total}}</td>
                                        <td>{{$counts}}</td>

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




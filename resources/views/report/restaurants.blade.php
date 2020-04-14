@extends('layouts.main')

@section('content')

    <div class="row">

        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">{{$location_title}}</span>
                    </div>


                </div>
                <div class="portlet-body">

                    <table id="data-table"
                           class="table table-striped table-bordered ">
                        <thead>
                        <tr>

                            <th>{{trans('reports.id')}}</th>
                            <th>{{trans('reports.name')}}</th>
                            <th>{{trans('restaurants.branches')}}</th>
                            <th>{{trans('reports.status')}}</th>
                            <th>{{trans('reports.orders')}}</th>
                            <th>{{trans('reports.owner')}}</th>
                            <th>{{trans('reports.rank')}}</th>
                            <th>{{trans('main.created_at')}}</th>

                        </tr>
                        </thead>

                        @if(!(empty($reportData)))
                            <tbody>
                            @foreach($reportData as $data)
                                <?php
                                $ranks = 0;
                                    if($data->reviews){
                                        if($data->reviews->where('isActive',1)->count()>0)
                                        $ranks = number_format($data->reviews->where('isActive',1)->sum('review_rank')/
                                            $data->reviews->where('isActive',1)->count(),2);
                                    }
                                    ?>

                                <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>{{$data->branches->count()}}</td>
                                    <td>{{($data->isActive?trans('main.isActive'):trans('main.not_active'))}}</td>
                                    <td>{{$data->orders->count()}}</td>
                                    <td>{{$data->owner->name}}</td>
                                    <td>{{$ranks}}</td>
                                    <td>{{date('d-m-Y', strtotime($data->created_at))}}</td>
                                </tr>


                            @endforeach
                                </tbody>

                        @endif

                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@stop

@push('css')
    <link href="{{url('')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css"
          rel="stylesheet" type="text/css"/>

    <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
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

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.20/api/sum().js"></script>
    <script>


        $(document).ready(function() {
            var table = $('#data-table').DataTable( {
                "paging":   false,
                "ordering": false,
                "bFilter": false,
                "info":     false,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        footer: true,
                        title: "{{$location_title}}  "
                    },
                    { extend: 'excelHtml5', footer: true, title: "{{$location_title}}" },
                ],

            } );


        } );


    </script>
@endpush

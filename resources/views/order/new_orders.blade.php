@extends('layouts.main')

@section('content')

    <!-- The Modal -->

    <!-- END PAGE BAR --> <!-- BEGIN PAGE TITLE-->

    <div class="row" style="margin-top: 30px;">

        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">{{trans('main.new_orders')}}</span>
                    </div>

                </div>
                <div class="portlet-body">

                    <table id="data-table"
                           class="table table-striped table-bordered ">
                        <thead>
                        <tr>

                            <th>{{trans('orders.order_id')}}</th>
                            <th>{{trans('orders.customer')}}</th>
                            <th>{{trans('orders.status')}}</th>
                            <th>{{trans('orders.qty')}}</th>
                            <th>{{trans('orders.sub_total')}}</th>
                            <th>{{trans('main.created_at')}}</th>
                            <th>{{trans('main.control')}}</th>


                        </tr>
                        </thead>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="{{asset('css/slideShowImage.css')}}">
    <style>
        .btn-default.btn-on-1.active {
            background-color: #006FFC;
            color: white;
        }

        .btn-default.btn-off-1.active {
            background-color: #DA4F49;
            color: white;
        }

    </style>
@endpush
@push('js')
    <script src="{{url('')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
    <!--
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    -->


    <script src="{{url('')}}/assets/pages/scripts/components-bootstrap-switch.min.js" type="text/javascript"></script>
    <script>


        $(function () {

            var table = $('#data-table').DataTable({
                order: [[ 0, "desc" ]],
                processing: true,
                serverSide: true,
                searching: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "bInfo": false,
                ajax: {
                    url: '{{url("/orders/newOrdersListData")}}',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [

                    {data: 'id' ,name: 'order_id', 'class': 'id'},
                    {data: 'customer',width:"20%" ,name: 'customer', 'class': 'name'},
                    {data: 'status', name: 'status', 'class': 'status'},
                    {data: 'qty', name: 'qty', 'class': 'qty'},
                    {data: 'sub_total', name: 'sub_total', 'class': 'sub_total'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'control', name: 'control','class': 'control' , orderable: false, "searchable": false}

                ]
            });



        });


    </script>
@endpush
